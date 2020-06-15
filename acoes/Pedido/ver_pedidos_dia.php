<?php
session_start();
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../classes/Pedido/Pedido.php';
    require_once __DIR__ . '/../../classes/Pedido/PedidoRN.php';

    Sessao::getInstance()->validar();

    $objPedido = new Pedido();
    $objPedidoRN = new PedidoRN();

    $arrDias = Utils::getLastSevenDays();

    $arrPedidos = $objPedidoRN->listar($objPedido);

    $diaX = 0;
    //percorrendo os últimos 7 dias
    for ($i=0; $i<count($arrDias); $i++) {
        $diaX = 0;
        foreach ($arrPedidos as $pedido) {
            $dataHoraPedido = $pedido->getDataHora();
            $dataPedido = explode(" ", $dataHoraPedido);
            $data = explode("/", $dataPedido[0]);
            if($data[0] == $arrDias[$i]){
                $diaX++;
            }
        }
        if($diaX > 0) {
            //$arrDiasPedidos[] = array("dia"=>$arrDias[$i],"qntPedidos"=> $diaX);
            $arrDiasPedidos[] = $diaX;
        }else{
            //$arrDiasPedidos[] = array("dia"=>$arrDias[$i],"qntPedidos"=> 0);
            $arrDiasPedidos[] = 0;
        }
    }

    $arrDiasStr = Utils::getLastSevenDaysWithStr();

    //print_r($arrDiasPedidos);

    $arrRetorno = array("mes" => $arrDiasStr, "qntPedidos" => $arrDiasPedidos);


    echo json_encode($arrRetorno);

}catch (Throwable $e){
    die($e);
}