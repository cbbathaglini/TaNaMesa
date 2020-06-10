<?php
require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class PratoBD {
    protected $database;
    protected $dbname = 'app';
    protected $child = 'pratos';

    public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }
    public function consultar($objPrato = null){
        try {

            if (empty($objPrato->getIdPrato())) { return FALSE; }

            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->getValue();
            if(!is_null($filho)) {
                $prato = new Prato();
                $prato->setIdPrato($filho['idPrato']);
                $prato->setCategoriaPrato($filho['categoria']);
                $prato->setInformacoes($filho['informacoes']);
                $prato->setNome($filho['prato']);
                $prato->setIndexNome($filho['index_prato']);
                $prato->setPreco($filho['preco']);

                return $prato;
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os pratos no BD.", $ex);
        }

    }

    public function alterar($objPrato){
        try {

            $arr =  array( 'idPrato' => $objPrato->getIdPrato(),
                'prato' =>  $objPrato->getNome(),
                'preco' =>  $objPrato->getPreco(),
                'index_prato' =>  $objPrato->getIndexNome(),
                'categoria_prato' =>  $objPrato->getCategoriaPrato());


            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->set($arr);

            return $objPrato;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os pratos no BD.", $ex);
        }

    }
    public function cadastrar($objPrato) {
        try {
            if (empty($objPrato) || !isset($objPrato)) { return FALSE; }

            $ultimoId = $this->getLastId();
            $objPrato->setIdPrato($ultimoId+1);
            $arr =  array( 'idPrato' => $objPrato->getIdPrato(),
                            'prato' =>  $objPrato->getNome(),
                            'preco' =>  $objPrato->getPreco(),
                        'index_prato' =>  $objPrato->getIndexNome(),
                'categoria_prato' =>  $objPrato->getCategoriaPrato());


            $postdata = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->set($arr);


            if($postdata){
                return true;
            }else{
                return false;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os pratos no BD.", $ex);
        }
    }

    public function listar($objPrato)
    {
        try {
            if (empty($objPrato) || !isset($objPrato)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();

            $arrPratos = array();
            foreach ($arr as $id) {
                if (!is_null($id)) {
                    $prato = new Prato();
                    $prato->setIdPrato($id['idPrato']);
                    $prato->setCategoriaPrato($id['categoria_prato']);
                    $prato->setIndexNome($id['index_prato']);
                    $prato->setNome($id['prato']);
                    $prato->setPreco($id['preco']);
                    $prato->setInformacoes($id['informacoes']);
                    $prato->setListaIngredientes($id['lista_ingredientes']);
                    $arrPratos[] = $prato;
                }
            }
            return $arrPratos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os pratos no BD.", $ex);
        }
    }

    public function getLastId() {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id){
                if($maior < $id['idPrato']){
                    $maior = $id['idPrato'];
                }
            }
            return $maior;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pegando o último id dos pratos no BD.", $ex);
        }
    }

    public function remover($objPrato) {
        try{
            if (empty($objPrato) || !isset($objPrato)) { return FALSE; }
            if ($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())){
                //print_r($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->getValue());
                $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->remove();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o prato no BD.", $ex);
        }
    }
}
?>