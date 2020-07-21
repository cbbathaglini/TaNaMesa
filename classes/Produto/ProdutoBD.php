<?php
require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class ProdutoBD {
    protected $database;
    protected $dbname = 'app';
    protected $child = 'Products';

    public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }
    public function consultar($objProduto = null){
        try {

            if (empty($objProduto->getIdProduto())) { return FALSE; }

            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objProduto->getCategoriaProduto())->getChild($objProduto->getIdProduto())->getValue();

            if(!is_null($filho)) {
                $produto = new Produto();
                $produto->setIdProduto($filho['idMeal']);
                $produto->setCategoriaProduto($filho['category']);
                $produto->setNome($filho['strMeal']);
                $produto->setIndexNome($filho['englishName']);
                $produto->setPreco($filho['price']);
                $produto->setStrURLImagem($filho['strMealThumb']);

                return $produto;
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os produtos no BD.", $ex);
        }

    }

    public function alterar($objProduto){
        try {


            $arr =  array( 'idProduto' => $objProduto->getIdProduto(),
                'nome' =>  $objProduto->getNome(),
                'preco' =>  $objProduto->getPreco(),
                'index_produto' =>  $objProduto->getIndexNome(),
                'categoria_produto' =>  $objProduto->getCategoriaProduto(),
                'caminho_img_sistWEB' =>  $objProduto->getStrURLImagem()
            );


            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objProduto->getIdProduto())->set($arr);

            return $objProduto;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os produtos no BD.", $ex);
        }

    }
    public function cadastrar($objProduto) {
        try {
            if (empty($objProduto) || !isset($objProduto)) { return FALSE; }

            $ultimoId = $this->getLastId();
            $objProduto->setIdProduto($ultimoId+1);
            $arr =  array( 'idProduto' => $objProduto->getIdProduto(),
                            'nome' =>  $objProduto->getNome(),
                            'preco' =>  $objProduto->getPreco(),
                        'index_produto' =>  $objProduto->getIndexNome(),
                'categoria_produto' =>  $objProduto->getCategoriaProduto(),
                'caminho_img_sistWEB' =>  $objProduto->getStrURLImagem()
                );


            $postdata = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objProduto->getIdProduto())->set($arr);


            if($postdata){
                return true;
            }else{
                return false;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os produtos no BD.", $ex);
        }
    }

    public function listar($objProduto)
    {
        try {
            if (empty($objProduto) || !isset($objProduto)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            /*
            echo "<pre>";
            print_r($arr);
            echo "</pre>";
            */

            $arrProdutos = array();
            foreach ($arr as $nome => $id) {
                foreach ($id as $valor){
                    if (!is_null($valor)) {
                        $produto = new Produto();
                        $produto->setIdProduto($valor['idMeal']);
                        $produto->setCategoriaProduto($valor['category']);
                        //$produto->setIndexNome($id['strMeal']);
                        $produto->setNome($valor['strMeal']);
                        $produto->setPreco($valor['price']);
                        $produto->setStrURLImagem($valor['strMealThumb']);

                        $arrProdutos[] = $produto;
                    }

                }
                /*
                //echo $nome;
                echo "<pre>";
                print_r($id);
                echo "</pre>";
                echo $id['idMeal'];

                */
            }
            return $arrProdutos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os produtos no BD.", $ex);
        }
    }

    public function getLastId() {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id){
                if($maior < $id['idProduto']){
                    $maior = $id['idProduto'];
                }
            }
            return $maior;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pegando o último id dos produtos no BD.", $ex);
        }
    }

    public function remover($objProduto) {
        try{
            if (empty($objProduto) || !isset($objProduto)) { return FALSE; }
            if ($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objProduto->getIdProduto())){
                //print_r($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objProduto->getIdProduto())->getValue());
                $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objProduto->getIdProduto())->remove();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o produto no BD.", $ex);
        }
    }
}
?>