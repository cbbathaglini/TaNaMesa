<?php
require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class PedidoBD {
    protected $database;
    protected $dbname = 'app';
    protected $child = 'Orders';

    public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }

    public function consultar(Pedido $objPedido){
        try {
            //echo "a";
            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPedido->getIdPedido())->getValue();
            //print_r($filho);

            //die();
            if(!is_null($filho)) {
                $pedido = new Pedido();
                $pedido->setIdMesa($filho['idMesa']);
                $pedido->setIdPedido($filho['idPedido']);
                $pedido->setPreco($filho['preco']);
                $pedido->setDataHora($filho['dataHora']);
                $pedido->setListaProdutos($filho['lista_produtos']);
                $pedido->setSituacao($filho['situacao']);
                return $pedido;
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os pedidos no BD.", $ex);
        }

    }

    public function alterar(Pedido $objPedido){
        try {

            $arr =  array( 'idMesa' => $objPedido->getIdMesa(),
                'idPedido' =>  $objPedido->getIdPedido(),
                'preco' =>  $objPedido->getPreco(),
                'dataHora' =>  $objPedido->getDataHora(),
                'lista_produtos' => $objPedido->getListaProdutos(),
                'situacao' => $objPedido->getSituacao());


            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPedido->getIdPedido())->set($arr);

            return $objPedido;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando os pedidos no BD.", $ex);
        }

    }
    public function cadastrar(Pedido $objPedido) {
        try {
            if (empty($objPedido) || !isset($objPedido)) { return FALSE; }

            foreach ($objPedido->getListaProdutos() as $produto){
                $arrP[$produto->getIdProduto().'_'.rand(5, 15)] =  array( 'productId' => $produto->getIdProduto(),
                    'productName' =>  $produto->getNome(),
                    'price' =>  $produto->getPreco(),
                    'productCategoryId' =>  $produto->getCategoriaProduto(),
                    'thumbURL' =>  $produto->getStrURLImagem(),
                    'date' => $produto->getDataHora()['date'],
                    'table' => $objPedido->getIdMesa()
                );
            }




            echo "<pre>";
            //print_r($arrP);
            echo "</pre>";

            /*$arr = array();
            $arr['table'] = $objPedido->getIdMesa();
            $arr['orderId'] = $objPedido->getIdPedido();
            $arr['dataHora'] = $objPedido->getDataHora();
            $arr['situacao'] = $objPedido->getSituacao();
            $arr['totalPrice'] = $objPedido->getPreco();
            foreach ($objPedido->getListaProdutos() as $produto){
            $arr[ $produto->getIdProduto().'_'.rand(5, 15)] =  array( 'productId' => $produto->getIdProduto(),
                    'productName' =>  $produto->getNome(),
                    'price' =>  $produto->getPreco(),
                    'productCategoryId' =>  $produto->getCategoriaProduto(),
                    'thumbURL' =>  $produto->getStrURLImagem(),
                    'date' => $produto->getDataHora()['date']
                );
            }*/


            echo "<pre>";
            //print_r($arrP);
            echo "</pre>";
            //die();
           $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPedido->getIdMesa())->set($arrP);

            return $objPedido;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando os pedidos no BD.", $ex);
        }
    }

    public function listar(Pedido $objPedido)
    {
        try {
            if (empty($objPedido) || !isset($objPedido)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();

            $arrPedidos =  array();
            foreach ($arr as $id) {

                $pedido = new Pedido();
                $pedido->setIdMesa($id['table']);
                $pedido->setIdPedido($id['table']);
                $pedido->setSituacao($id['situacao']);

                $precoTotal =0;
                $arr_produtos = array();
                foreach ($id as $p){
                    //print_r($p);
                    $produto = new Produto();
                    $produto->setIdProduto($p['productId']);
                    $produto->setCategoriaProduto($p['productCategoryId']);
                    $pedido->setIdMesa($p['table']);
                    $produtoRN = new ProdutoRN();
                    $produto =$produtoRN->consultar($produto);


                    if($p['date'] != 1) {
                        $produto->setDataHora($p['date']['day'] . "/" . $p['date']['month'] . "/" . $p['date']['year'] . " " . $p['date']['hours'] . ":" . $p['date']['minutes'] . ":" . $p['date']['seconds']);
                    }else{
                        $produto->setDataHora('1/1/1 1:1:1');
                    }

                    //print_r($produto);
                    $arr_produtos[] = $produto;

                    $preco = explode(' ', $p['price']);
                    $precoTotal += $preco[1];

                }
                $pedido->setPreco($precoTotal);
                $pedido->setListaProdutos(array_filter($arr_produtos));
                //$pedido->setDataHora();
                $arrPedidos[] = $pedido;
                //die();

            }

            return $arrPedidos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os pedidos no BD.", $ex);
        }
    }

    public function getLastId() {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id){
                if($maior < $id['productId']){
                    $maior = $id['productId'];
                }
            }
            return $maior;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pegando o último id das mesas no BD.", $ex);
        }
    }

    public function remover(Pedido $objPedido) {
        try{
            if (empty($objPedido) || !isset($objPedido)) { return FALSE; }
            if ($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPedido->getIdPedido())){
                //print_r($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->getValue());
                $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPedido->getIdPedido())->remove();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o pedido no BD.", $ex);
        }
    }
}
?>