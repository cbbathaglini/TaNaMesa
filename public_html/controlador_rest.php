<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once __DIR__ . '/../classes/TaNaMesaREST/TaNaMesaREST.php';
require_once __DIR__ . '/../classes/Sessao/Sessao.php';

require_once __DIR__ . '/../classes/Log/Log.php';
require_once __DIR__ . '/../classes/Log/LogRN.php';
try{

    session_start();

    Sessao::getInstance(false);

    //LogRN::gravar(print_r($_GET,true).print_r($_POST,true));

    $objTaNaMesaRest = new TaNaMesaREST();

    switch($_GET['action_rest']){
        case 'cadastrar_pedido':
            $objTaNaMesaRest->cadastrarPedido(json_decode($_POST['objPedido']));
            break;
        case 'cadastrar_mesa':
            $objTaNaMesaRest->cadastrarMesa($_POST['numeroMesa'],$_POST['numLugaresMesa'],$_POST['situacaoMesa']);
            break;

    }
} catch(Throwable $e) {
    //Log::getInstance()->gravar($e->__toString());
    die($e);
}