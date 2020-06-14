<?php
require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class PedidoBD {
    protected $database;
    protected $dbname = 'app';
    protected $child = 'pedido';

    public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }
    public function consultar(Pedido $objPedido){
        try {

            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPedido->getIdPedido())->getValue();
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

            $ultimoId = $this->getLastId();
            $objPedido->setIdPedido($ultimoId+1);
            $arr =  array( 'idMesa' => $objPedido->getIdMesa(),
                'idPedido' =>  $objPedido->getIdPedido(),
                'preco' =>  $objPedido->getPreco(),
                'dataHora' =>  $objPedido->getDataHora(),
                'lista_produtos' => $objPedido->getListaProdutos(),
                'situacao' => $objPedido->getSituacao());

            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPedido->getIdPedido())->set($arr);

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
            //print_r($arr);
            $arrMesas =  array();
            foreach ($arr as $id) {
                if (!is_null($id)) {
                    $pedido = new Pedido();
                    $pedido->setIdMesa($id['idMesa']);
                    $pedido->setIdPedido($id['idPedido']);
                    $pedido->setPreco($id['preco']);
                    $pedido->setDataHora($id['dataHora']);
                    $pedido->setListaProdutos($id['lista_produtos']);
                    $pedido->setSituacao($id['situacao']);
                    $arrMesas[] = $pedido;
                }
            }
            return $arrMesas;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os pedidos no BD.", $ex);
        }
    }

    public function getLastId() {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id){
                if($maior < $id['idPedido']){
                    $maior = $id['idPedido'];
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