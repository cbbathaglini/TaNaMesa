<?php
require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class MesaBD {
    protected $database;
    protected $dbname = 'app';
    protected $child = 'Tables';

    public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }
    public function consultar(Mesa $objMesa){
        try {

            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objMesa->getIdMesa())->getValue();
            if(!is_null($filho)) {
                $mesa = new Mesa();
                $mesa->setIdMesa($filho['id']);
                $mesa->setDisponivel($filho['available']);
                $mesa->setIdFuncionario($filho['lista_funcionarios']);
                $mesa->setEsperandoPedido($filho['waitingOrder']);
                $mesa->setBoolPrecisaFunc($filho['needingWaiter']);
                return $mesa;
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando as mesas no BD.", $ex);
        }

    }

    public function alterar(Mesa $objMesa){
        try {

            $arr =  array( 'id' => $objMesa->getIdMesa(),
                'available' =>  $objMesa->getDisponivel(),
                'needingWaiter' =>  $objMesa->getBoolPrecisaFunc(),
                'waitingOrder' =>  $objMesa->getEsperandoPedido(),
                'lista_funcionarios' => $objMesa->getIdFuncionario());


            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objMesa->getIdMesa())->set($arr);

            return $objMesa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando as mesas no BD.", $ex);
        }

    }
    public function cadastrar(Mesa $objMesa) {
        try {
            if (empty($objMesa) || !isset($objMesa)) { return FALSE; }

            $ultimoId = $this->getLastId();
            $objMesa->setIdMesa($ultimoId+1);
            $arr =  array( 'id' => $objMesa->getIdMesa(),
                'available' =>  $objMesa->getDisponivel(),
                'needingWaiter' =>  $objMesa->getBoolPrecisaFunc(),
                'waitingOrder' =>  $objMesa->getEsperandoPedido(),
                'lista_funcionarios' =>  $objMesa->getIdFuncionario());

            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objMesa->getIdMesa())->set($arr);

            return $objMesa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando as mesas no BD.", $ex);
        }
    }

    public function listar(Mesa $objMesa)
    {
        try {
            if (empty($objMesa) || !isset($objMesa)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            //print_r($arr);
            $arrMesas =  array();
            foreach ($arr as $id) {
                if (!is_null($id)) {
                    $mesa = new Mesa();
                    $mesa->setIdMesa($id['id']);
                    $mesa->setDisponivel($id['available']);
                    $mesa->setBoolPrecisaFunc($id['needingWaiter']);
                    $mesa->setIdFuncionario($id['lista_funcionarios']);
                    $mesa->setEsperandoPedido($id['waitingOrder']);
                    $arrMesas[] = $mesa;
                }
            }
            return $arrMesas;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando as mesas no BD.", $ex);
        }
    }

    public function getLastId() {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id){
                if($maior < $id['id']){
                    $maior = $id['id'];
                }
            }
            return $maior;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pegando o último id das mesas no BD.", $ex);
        }
    }

    public function remover(Mesa $objMesa) {
        try{
            if (empty($objMesa) || !isset($objMesa)) { return FALSE; }
            if ($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objMesa->getIdMesa())){
                //print_r($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->getValue());
                $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objMesa->getIdMesa())->remove();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a mesa no BD.", $ex);
        }
    }
}
?>