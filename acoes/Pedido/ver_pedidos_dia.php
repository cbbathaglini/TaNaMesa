<?php
session_start();
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    Sessao::getInstance()->validar();
    $arrTeste = array(89,23,67,35,52,43,7,8,9,0,0,45,25);

    echo json_encode($arrTeste);

}catch (Throwable $e){
    die($e);
}