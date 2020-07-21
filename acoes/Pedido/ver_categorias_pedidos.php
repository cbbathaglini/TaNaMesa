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

    $objProduto = new Produto();
    $objProdutoRN = new ProdutoRN();

    $objCategoriaProduto = new CategoriaProduto();
    $objCategoriaProdutoRN = new CategoriaProdutoRN();

    $arr_pedidos = $objPedidoRN->listar($objPedido);
    $arr_categorias = $objCategoriaProdutoRN->listar($objCategoriaProduto);

    foreach ($arr_pedidos as $pedido){
        $listaProdutos = $pedido->getListaProdutos();
        foreach ($listaProdutos as $p){
            $arr_categoria[] = $p->getCategoriaProduto();
            $arr_produtos[] = $p->getNome();
            /*foreach ($arr_categorias as $categoria) {
                if ($categoria->getIdCategoriaProduto() == $objProduto->getCategoriaProduto()) {

                }
            }*/
        }
    }
    $arr_categoria_count = array_count_values($arr_categoria);
    $arr_categoria_cores = array();
    for($i=0; $i<count($arr_categoria_count); $i++){
        $arr_categoria_cores[] = Utils::random_color(0.5);
    }

    $arr_produtos_count = array_count_values($arr_produtos);
    $arr_produtos_cores = array();
    for($i=0; $i<count($arr_produtos_count); $i++){
        $arr_produtos_cores[] = Utils::random_color(0.5);
    }
    $arr_JSON['categorias'] = $arr_categoria_count;
    $arr_JSON['categorias_cores'] = $arr_categoria_cores;
    $arr_JSON['produtos'] = $arr_produtos_count;
    $arr_JSON['produtos_cores'] = $arr_produtos_cores;



    echo json_encode($arr_JSON);

}catch (Throwable $e){
    die($e);
}