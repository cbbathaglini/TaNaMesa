<?php
session_start();
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../classes/Historico/Historico.php';
    require_once __DIR__ . '/../../classes/Historico/HistoricoRN.php';

    require_once __DIR__ . '/../../classes/Produto/Produto.php';
    require_once __DIR__ . '/../../classes/Produto/ProdutoRN.php';

    Sessao::getInstance()->validar();

    $objHistorico = new Historico();
    $objHistoricoRN = new HistoricoRN();

    $objProduto = new Produto();
    $objProdutoRN = new ProdutoRN();

    //$arrDias = Utils::getLastSevenDays();

    date_default_timezone_set('America/Sao_Paulo');
    $dataAtual = date("d_m_Y ");
    $objHistorico = new Historico();
    $objHistoricoRN = new HistoricoRN();

    $dataAtual = date("d_m_Y ");
    $objHistorico->setDataHistorico("17_07_2020");
    $objHistorico = $objHistoricoRN->consultar($objHistorico);


    foreach ($objHistorico->getObjProdutos() as $objProduto) {
        $arr_nomes[] = $objProduto->getNome();
    }


    $arr_nomes_count = array_count_values($arr_nomes);
    for($i=0; $i<count($arr_nomes_count); $i++){
        $arr_nomes_cores[] = Utils::random_color(0.5);
    }

    $arr_JSON['nomes'] = $arr_nomes_count;
    $arr_JSON['nomes_cores'] = $arr_nomes_cores;

    //echo "<pre>";
    //print_r($arr_JSON);
    //echo "</pre>";

    echo json_encode($arr_JSON);

}catch (Throwable $e){
    die($e);
}