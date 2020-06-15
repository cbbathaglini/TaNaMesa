<?php
session_start();
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    require_once __DIR__ . '/../../classes/Pedido/Pedido.php';
    require_once __DIR__ . '/../../classes/Pedido/PedidoRN.php';

    require_once __DIR__ . '/../../classes/Produto/Produto.php';
    require_once __DIR__ . '/../../classes/Produto/ProdutoRN.php';


    Sessao::getInstance()->validar();

    $objPedido = new Pedido();
    $objPedidoRN = new PedidoRN();

    $objProduto = new Produto();
    $objProdutoRN = new ProdutoRN();

    $arr_pedidos = $objPedidoRN->listar($objPedido);
    $arr_produtos = $objProdutoRN->listar($objProduto);

    foreach ($arr_produtos as $produto){
        $quantidade = 0;
        foreach ($arr_pedidos as $pedido){
            $listaProdutos = $pedido->getListaProdutos();
            foreach ($listaProdutos as $p){
                if($p['idProduto'] == $produto->getIdProduto()){
                    $quantidade++;
                }
            }
        }
        $arr_mais_pedidos[] = array("idProduto" => $produto->getIdProduto(), "nomeProduto" => $produto->getNome(), "quantidade" => $quantidade);
        $arr_nomes[] = $produto->getNome();
        $arr_quantidade[] = $quantidade;
    }

    $arr_retorno = array("nomeProduto" => $arr_nomes, "quantidade" => $arr_quantidade);

    echo json_encode($arr_retorno);

}catch (Throwable $e){
    die($e);
}