<?php
session_start();
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    require_once __DIR__ . '/../../classes/Pedido/Pedido.php';
    require_once __DIR__ . '/../../classes/Pedido/PedidoRN.php';

    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProduto.php';
    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProdutoRN.php';

    require_once __DIR__ . '/../../classes/Produto/Produto.php';
    require_once __DIR__ . '/../../classes/Produto/ProdutoRN.php';


    Sessao::getInstance()->validar();
    $objPedido = new Pedido();
    $objPedidoRN = new PedidoRN();


    $objCategoriaProduto = new CategoriaProduto();
    $objCategoriaProdutoRN = new CategoriaProdutoRN();

    $objProduto = new Produto();
    $objProdutoRN = new ProdutoRN();

    $arr_pedidos = $objPedidoRN->listar($objPedido);
    $arr_categorias = $objCategoriaProdutoRN->listar($objCategoriaProduto);

    $quantidadePeixe =0;
    $quantidadeCarne = 0;
    $quantidadeMassa = 0;
    $quantidadeFrango = 0;
    $quantidadeCerveja = 0;
    $quantidadeRefrigerante = 0;
    foreach ($arr_pedidos as $pedido){
        $listaProdutos = $pedido->getListaProdutos();
        foreach ($listaProdutos as $p){
            $objProduto->setIdProduto($p['idProduto']);
            $objProduto = $objProdutoRN->consultar($objProduto);

           foreach ($arr_categorias as $categoria) {
               if ($categoria->getIdCategoriaProduto() == $objProduto->getCategoriaProduto()) {
                   if ($categoria->getDescricao() == 'Peixe') {
                       $quantidadePeixe++;
                   }
                   if ($categoria->getDescricao() == 'Frango') {
                       $quantidadeFrango++;
                   }
                   if ($categoria->getDescricao() == 'Massa') {
                       $quantidadeMassa++;
                   }
                   if ($categoria->getDescricao() == 'Cerveja') {
                       $quantidadeCerveja++;
                   }
                   if ($categoria->getDescricao() == 'Carne') {
                       $quantidadeCarne++;
                   }
               }
           }
        }
    }


    $arr_retorno = array("qntPeixe" => $quantidadePeixe, "qntFrango" => $quantidadeFrango, "qntMassa" => $quantidadeMassa, "qntCerveja" => $quantidadeCerveja, "qntCarne" => $quantidadeCarne);
    echo json_encode($arr_retorno);

}catch (Throwable $e){
    die($e);
}