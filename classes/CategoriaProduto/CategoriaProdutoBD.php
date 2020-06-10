<?php
require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class CategoriaProdutoBD {
    protected $database;
    protected $dbname = 'app';
    protected $child = 'categoriaProduto';

    public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }
    public function consultar(CategoriaProduto $objCategoriaProduto){
        try {

            if (empty($objCategoriaProduto->getIdCategoriaProduto())) { return FALSE; }

            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objCategoriaProduto->getIdCategoriaProduto())->getValue();
            if(!is_null($filho)) {
                $categoriaProduto = new CategoriaProduto();
                $categoriaProduto->setIdCategoriaProduto($filho['idCategoriaProduto']);
                $categoriaProduto->setDescricao($filho['descricao']);

                return $categoriaProduto;
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando as categorias dos produtos no BD.", $ex);
        }

    }

    public function alterar($objCategoriaProduto){
        try {

            $arr =  array( 'idCategoriaProduto' => $objCategoriaProduto->getIdCategoriaProduto(),
                'descricao' =>  $objCategoriaProduto->getDescricao()
            );


            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objCategoriaProduto->getIdCategoriaProduto())->set($arr);

            return $objCategoriaProduto;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando as categorias dos produtos no BD.", $ex);
        }

    }
    public function cadastrar($objCategoriaProduto) {
        try {
            if (empty($objCategoriaProduto) || !isset($objCategoriaProduto)) { return FALSE; }

            $ultimoId = $this->getLastId();
            $objCategoriaProduto->setIdCategoriaProduto($ultimoId+1);
            $arr =  array( 'idCategoriaProduto' => $objCategoriaProduto->getIdCategoriaProduto(),
                'descricao' =>  $objCategoriaProduto->getDescricao()
            );


            $postdata = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objCategoriaProduto->getIdCategoriaProduto())->set($arr);


            if($postdata){
                return true;
            }else{
                return false;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando as categorias dos produtos no BD.", $ex);
        }
    }

    public function listar($objCategoriaProduto)
    {
        try {
            if (empty($objCategoriaProduto) || !isset($objCategoriaProduto)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();

            $arrCategoriasProdutos = array();
            foreach ($arr as $id) {
                if (!is_null($id)) {
                    $categoriaProduto = new CategoriaProduto();
                    $categoriaProduto->setIdCategoriaProduto($id['idCategoriaProduto']);
                    $categoriaProduto->setDescricao($id['descricao']);
                    $arrCategoriasProdutos[] = $categoriaProduto;
                }
            }
            return $arrCategoriasProdutos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os produtos no BD.", $ex);
        }
    }

    public function getLastId() {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id){
                if($maior < $id['idCategoriaProduto']){
                    $maior = $id['idCategoriaProduto'];
                }
            }
            return $maior;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pegando o último id das categorias dos produtos no BD.", $ex);
        }
    }

    public function remover($objCategoriaProduto) {
        try{
            if (empty($objCategoriaProduto) || !isset($objCategoriaProduto)) { return FALSE; }
            if ($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objCategoriaProduto->getIdCategoriaProduto())){
                //print_r($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objCategoriaProduto->getIdCategoriaProduto())->getValue());
                $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objCategoriaProduto->getIdCategoriaProduto())->remove();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a categoria do produto no BD.", $ex);
        }
    }
}
?>