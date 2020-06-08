<?php
require_once __DIR__ . '/../Sessao/Sessao.php';
require_once __DIR__ . '/../Log/Log.php';
require_once __DIR__ . '/../Log/LogRN.php';

require_once __DIR__ . '/../Mesa/Mesa.php';
require_once __DIR__ . '/../Mesa/MesaRN.php';

class TaNaMesaREST
{
    function cadastrarPedido($objPedidoRest)
    {
        try {

            $objPedido = new Pedido();
            $objPedido->setData($objPedidoRest->Data);
            $objPedido->setCpf($objPedidoRest->Cpf);

            $objPedidoRN = new PedidoRN();
            $objPedidoRN->cadastrar($objPedido);


            $arrResultado = array('resultado' => 'true', 'id_pedido' => $objPedido->getNumIdPedido());
            return json_encode($arrResultado);
        } catch (Throwable $e) {
            $this->processarExcecao($e);

	    }
    }

    function cadastrarMesa($numMesa,$numLugaresMesa,$situacaoMesa)
    {
        try {


            $objMesa = new Mesa();
            $objMesa->setNumero($numMesa);
            $objMesa->setNumLugares($numLugaresMesa);
            $objMesa->setSituacao($situacaoMesa);

            $objMesaRN = new MesaRN();
            $objMesaRN->cadastrar($objMesa);

            $arrResultado = array('resultado' => 'true', 'id_mesa' => $objMesa->getIdMesa());
            $RET  = json_encode($arrResultado);

            LogRN::gravar($RET);

            DIE($RET);
        } catch (Throwable $e) {


            LogRN::gravar(__METHOD__.$e);

            $this->processarExcecao($e);

        }
    }


    protected function processarExcecao($e) {
        $strCodigoInfra = 'ERRO';
        $strErro = $e->getMessage();

        if ($e instanceof Excecao && $e->possui_validacoes()) {
            $strCodigoInfra = 'VALIDACAO';
            $strErro = $e->__toString();
        }else{
            //grava no log o $e
            $log = new Log();
            $log->setIdUsuario(Sessao::getInstance()->getIdUsuario());
            $log->setTexto($e->__toString()."\n".$e->getTraceAsString());
            date_default_timezone_set('America/Sao_Paulo');
            $log->setDataHora(date("Y-m-d H:i:s"));
            print_r($log);
            $logRN = new LogRN();
            $logRN->cadastrar($log);
        }

        if ($strCodigoInfra == 'VALIDACAO') {
            echo json_encode(array('resultado'=>'false', $strCodigoInfra => utf8_encode($strErro)));
        } elseif ($strCodigoInfra == 'ERRO') {
            echo json_encode(array('resultado'=>'false', $strCodigoInfra => utf8_encode($strErro)));
        }

        die();
    }

}