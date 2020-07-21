<?php


require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class HistoricoBD
{

    protected $database;
    protected $dbname = 'app';
    protected $child = 'Historico';

    public function __construct()
    {
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }

    public function consultar(Historico $objHistorico)
    {
        try {
            //echo "a";
            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objHistorico->getDataHistorico())->getValue();

            if (!is_null($filho)) {
                $historico = new Historico();

                $historico->setDataHistorico( $objHistorico->getDataHistorico());
                $precoTotal = 0;
                $arr_produtos = array();
                foreach ($filho as $p){

                    $produto = new Produto();
                    $produto->setIdProduto($p['productId']);
                    $produto->setCategoriaProduto($p['productCategoryId']);
                    $historico->setIdMesa($p['table']);
                    $produtoRN = new ProdutoRN();
                    $produto = $produtoRN->consultar($produto);
                    $arr_produtos[] = $produto;


                }
                $historico->setObjProdutos($arr_produtos);
                return $historico;
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os pedidos no BD.", $ex);
        }

    }

    public function alterar(Historico $objHistorico)
    {
        try {


            return $objHistorico;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando os pedidos no BD.", $ex);
        }

    }

    public function cadastrar(Historico $objHistorico)
    {
        try {
            if (empty($objHistorico) || !isset($objHistorico)) {
                return FALSE;
            }
            date_default_timezone_set('America/Sao_Paulo');

            foreach ($objHistorico->getObjProdutos() as $produto) {
                $arrP[$produto->getIdProduto() . '_' . rand(5, 15)] = array('productId' => $produto->getIdProduto(),
                    'productName' => $produto->getNome(),
                    'price' => $produto->getPreco(),
                    'productCategoryId' => $produto->getCategoriaProduto(),
                    'thumbURL' => $produto->getStrURLImagem(),
                    'table' => $objHistorico->getIdMesa()
                );
            }



            //$arrHistorico =

            echo "<pre>";
            //print_r($arrP);
            echo "</pre>";


            echo "<pre>";
            //print_r($arrP);
            echo "</pre>";
            //die();
            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objHistorico->getDataHistorico())->set($arrP);

            return $objHistorico;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando os pedidos no BD.", $ex);
        }
    }

    public function listar(Historico $objHistorico)
    {
        try {
            if (empty($objHistorico) || !isset($objHistorico)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            //echo "<pre>";
            //print_r($arr);
            //echo "</pre>";
            //die();
            $arrHistorico = array();
            foreach ($arr as $id => $value) {

                $historico = new Historico();
                //$historico->setDataHistorico(str_replace('_', '/', $id));
                $historico->setDataHistorico( $id);
                $precoTotal = 0;
                $arr_produtos = array();
                foreach ($value as $p){

                    $produto = new Produto();
                    $produto->setIdProduto($p['productId']);
                    $produto->setCategoriaProduto($p['productCategoryId']);
                    $historico->setIdMesa($p['table']);
                    $produtoRN = new ProdutoRN();
                    $produto = $produtoRN->consultar($produto);
                    $arr_produtos[] = $produto;

                    $preco = explode(' ', $p['price']);
                    $precoTotal += $preco[1];

                }
                $historico->setObjProdutos($arr_produtos);
                $arrHistorico[] = $historico;
                //die();

            }

            return $arrHistorico;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os pedidos no BD.", $ex);
        }
    }

    public function getLastId()
    {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id) {
                if ($maior < $id['productId']) {
                    $maior = $id['productId'];
                }
            }
            return $maior;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pegando o último id das mesas no BD.", $ex);
        }
    }

    public function remover(Historico $objHistorico)
    {
        try {
            if (empty($objHistorico) || !isset($objHistorico)) {
                return FALSE;
            }
            if ($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objHistorico->getIdPedido())) {
                //print_r($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->getValue());
                $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objHistorico->getIdPedido())->remove();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o pedido no BD.", $ex);
        }
    }


}