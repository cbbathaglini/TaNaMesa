<?php
session_start();
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';

    require_once __DIR__ . '/../../utils/Utils.php';

    require_once __DIR__ . '/../../classes/Usuario/Usuario.php';
    require_once __DIR__ . '/../../classes/Usuario/UsuarioRN.php';
    require_once __DIR__ . '/../../classes/Mesa/Mesa.php';
    require_once __DIR__ . '/../../classes/Mesa/MesaRN.php';

    Sessao::getInstance()->validar();

    $objMesa = new Mesa();
    $objMesaRN = new MesaRN();

    $html_mesas = '';
    $mesas = $objMesaRN->listar($objMesa);
    foreach ($mesas as $mesa) {
        if($mesa->getBoolPrecisaFunc()){
            $arr_JSON[] = $mesa->getIdMesa();
        }
    }

    echo json_encode($arr_JSON);
}catch (Throwable $e){
    die($e);
    //Pagina::getInstance()->processar_excecao($e);
}