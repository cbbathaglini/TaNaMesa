<?php
require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class PerfilUsuarioBD {
    protected $database;
    protected $dbname = 'app';
    protected $child = 'perfilUsuario';

    public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }
    public function consultar(PerfilUsuario $objPerfilUsuario){
        try {

            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPerfilUsuario->getIdPerfilUsuario())->getValue();
            if(!is_null($filho)) {
                $perfilUsuario = new PerfilUsuario();
                $perfilUsuario->setIdPerfilUsuario($filho['idPerfilUsuario']);
                $perfilUsuario->setPerfil($filho['perfil']);
                $perfilUsuario->setIndex_perfil($filho['index_perfil']);
                $perfilUsuario->setListaRecursos($filho['lista_recursos']);

                return $perfilUsuario;
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os perfis de usuário no BD.", $ex);
        }

    }

    public function alterar(PerfilUsuario $objPerfilUsuario){
        try {

            $arr =  array( 'idPerfilUsuario' => $objPerfilUsuario->getIdPerfilUsuario(),
                'perfil' =>  $objPerfilUsuario->getPerfil(),
                'index_perfil' =>  $objPerfilUsuario->getIndex_perfil(),
                'lista_recursos' =>  $objPerfilUsuario->getListaRecursos());


            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPerfilUsuario->getIdPerfilUsuario())->set($arr);

            return $objPerfilUsuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando os perfis de usuário no BD.", $ex);
        }

    }
    public function cadastrar(PerfilUsuario $objPerfilUsuario) {
        try {
            if (empty($objPerfilUsuario) || !isset($objPerfilUsuario)) { return FALSE; }

            $ultimoId = $this->getLastId();
            $objPerfilUsuario->setIdPerfilUsuario($ultimoId+1);
            $arr =  array( 'idPerfilUsuario' => $objPerfilUsuario->getIdPerfilUsuario(),
                'perfil' =>  $objPerfilUsuario->getPerfil(),
                'index_perfil' =>  $objPerfilUsuario->getIndex_perfil(),
                'lista_recursos' =>  $objPerfilUsuario->getListaRecursos());

            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPerfilUsuario->getIdPerfilUsuario())->set($arr);

            return $objPerfilUsuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando os perfis de usuário no BD.", $ex);
        }
    }

    public function listar(PerfilUsuario $objPerfilUsuario)
    {
        try {
            if (empty($objPerfilUsuario) || !isset($objPerfilUsuario)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();

             $arrPerfis =  array();
            foreach ($arr as $id) {
                if (!is_null($id)) {
                    $perfilUsuario = new PerfilUsuario();
                    $perfilUsuario->setIdPerfilUsuario($id['idPerfilUsuario']);
                    $perfilUsuario->setPerfil($id['perfil']);
                    $perfilUsuario->setIndex_perfil($id['index_perfil']);
                    $perfilUsuario->setListaRecursos($id['lista_recursos']);
                    $arrPerfis[] = $perfilUsuario;
                }
            }
            return $arrPerfis;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os perfis de usuário no BD.", $ex);
        }
    }

    public function getLastId() {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id){
                if($maior < $id['idPerfilUsuario']){
                    $maior = $id['idPerfilUsuario'];
                }
            }
            return $maior;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pegando o último id dos perfis de usuário no BD.", $ex);
        }
    }

    public function remover(PerfilUsuario $objPerfilUsuario) {
        try{
            if (empty($objPerfilUsuario) || !isset($objPerfilUsuario)) { return FALSE; }
            if ($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPerfilUsuario->getIdPerfilUsuario())){
                //print_r($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->getValue());
                $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPerfilUsuario->getIdPerfilUsuario())->remove();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o perfil do usuário no BD.", $ex);
        }
    }
}
?>