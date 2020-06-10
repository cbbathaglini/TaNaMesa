<?php
require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class RecursoBD {
    protected $database;
    protected $dbname = 'app';
    protected $child = 'recursos';

    public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }
    public function consultar(Recurso $objRecurso){
        try {

            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objRecurso->getIdRecurso())->getValue();
            if(!is_null($filho)) {
                $recurso = new Recurso();
                $recurso->setIdRecurso($filho['idRecurso']);
                $recurso->setNome($filho['recurso']);
                $recurso->setIndexRecurso($filho['index_recurso']);
                $recurso->setSNMenu($filho['s_n_menu']);
                $recurso->setLink($filho['link']);

                return $recurso;
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os recursos no BD.", $ex);
        }

    }

    public function alterar(Recurso $objRecurso){
        try {

            $arr =  array( 'idRecurso' => $objRecurso->getIdRecurso(),
                'recurso' =>  $objRecurso->getNome(),
                'index_recurso' =>  $objRecurso->getIndexRecurso(),
                's_n_menu' =>  $objRecurso->getSNMenu(),
                'link' =>  $objRecurso->getLink());


            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objRecurso->getIdRecurso())->set($arr);

            return $objRecurso;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando os recursos no BD.", $ex);
        }

    }
    public function cadastrar(Recurso $objRecurso) {
        try {
            if (empty($objRecurso) || !isset($objRecurso)) { return FALSE; }

            $ultimoId = $this->getLastId();
            $objRecurso->setIdRecurso($ultimoId+1);
            $arr =  array( 'idRecurso' => $objRecurso->getIdRecurso(),
                'recurso' =>  $objRecurso->getNome(),
                'index_recurso' =>  $objRecurso->getIndexRecurso(),
                's_n_menu' =>  $objRecurso->getSNMenu(),
                'link' =>  $objRecurso->getLink());


            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objRecurso->getIdRecurso())->set($arr);

            return $objRecurso;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando os recursos no BD.", $ex);
        }
    }

    public function listar(Recurso $objRecurso)
    {
        try {
            if (empty($objRecurso) || !isset($objRecurso)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();

            $arrRecursos = array();
            foreach ($arr as $id) {
                if (!is_null($id)) {
                    $recurso = new Recurso();
                    $recurso->setIdRecurso($id['idRecurso']);
                    $recurso->setNome($id['recurso']);
                    $recurso->setIndexRecurso($id['index_recurso']);
                    $recurso->setSNMenu($id['s_n_menu']);
                    $recurso->setLink($id['link']);
                    $arrRecursos[] = $recurso;
                }
            }
            return $arrRecursos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os recursos no BD.", $ex);
        }
    }

    public function listar_ids(Recurso $objRecurso)
    {
        try {
            if (empty($objRecurso) || !isset($objRecurso)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();

            $arr_ids = array();
            foreach ($arr as $id) {
                if (!is_null($id)) {
                    $arr_ids[] = $id['idRecurso'];
                }
            }
            return $arr_ids;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os recursos no BD.", $ex);
        }
    }

    public function getLastId() {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id){
                if($maior < $id['idRecurso']){
                    $maior = $id['idRecurso'];
                }
            }
            return $maior;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pegando o último id dos recursos no BD.", $ex);
        }
    }

    public function remover(Recurso $objRecurso) {
        try{
            if (empty($objRecurso) || !isset($objRecurso)) { return FALSE; }
            if ($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objRecurso->getIdRecurso())){
                //print_r($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->getValue());
                $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objRecurso->getIdRecurso())->remove();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o recurso no BD.", $ex);
        }
    }
}
?>