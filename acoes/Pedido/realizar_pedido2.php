<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{

    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Mesa/Mesa.php';
    require_once __DIR__ . '/../../classes/Mesa/MesaRN.php';

    require_once __DIR__ . '/../../classes/Produto/Produto.php';
    require_once __DIR__ . '/../../classes/Produto/ProdutoRN.php';

    require_once __DIR__ . '/../../classes/Pedido/Pedido.php';
    require_once __DIR__ . '/../../classes/Pedido/PedidoRN.php';

    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProduto.php';
    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProdutoRN.php';
    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProdutoINT.php';

    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    Sessao::getInstance()->validar();

    date_default_timezone_set('America/Sao_Paulo');
    //$_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");

    $objUtils = new Utils();

    $objProduto = new Produto();
    $objProdutoRN = new ProdutoRN();

    $objCategoriaProduto = new CategoriaProduto();
    $objCategoriaProdutoRN = new CategoriaProdutoRN();

    $objPedido = new Pedido();
    $objPedidoRN = new PedidoRN();

    $objMesa = new Mesa();
    $objMesaRN = new MesaRN();

    $alert = '';
    $caractere = '';


    $arrProdutos = $objProdutoRN->listar($objProduto);
    switch($_GET['action']){
        case 'realizar_pedido':

            if(isset($_POST['btn_salvar_pedido'])){
                if(isset($_GET['idMesa'])) {
                    $objPedido->setIdMesa(intval($_GET['idMesa']));
                }else{
                    $objPedido->setIdMesa(intval($_POST['numMesa']));
                }

                $objMesa->setIdMesa($objPedido->getIdMesa());
                $objMesa = $objMesaRN->consultar($objMesa);

                if($objMesa->getDisponivel() || $objMesa->getBoolPrecisaFunc()) {
                    $objPedido->setDataHora(date("d/m/Y H:i:s"));

                    $total = 0;
                    foreach ($arrProdutos as $p) {
                        if (isset($_POST['numQuantidade_produto' . $p->getIdProduto()])) {
                            //echo "produ: ".$p->getIdProduto()."\n";
                            //echo "qnt: ".$_POST['numQuantidade_produto'.$p->getIdProduto()]."\n\n";
                            if (strlen($_POST['numQuantidade_produto' . $p->getIdProduto()]) > 0) {
                                $arr_lista_produtos[] = array("idProduto" => $p->getIdProduto(), "quantidade" => $_POST['numQuantidade_produto' . $p->getIdProduto()]);
                                $total += $p->getPreco() * $_POST['numQuantidade_produto' . $p->getIdProduto()];
                            }
                        }
                    }

                    //print_r($arr_lista_produtos);
                    //die("a");
                    //echo $total;
                    $objPedido->setPreco($total);
                    $objPedido->setListaProdutos($arr_lista_produtos);
                    $objPedido->setSituacao("andamento");


                    //$objMesa = $objMesaRN->consultar();
                    $objMesa->setDisponivel(false);
                    $objMesa->setEsperandoPedido(true);
                    $objMesa->setBoolPrecisaFunc(false);

                    $objPedido = $objPedidoRN->cadastrar($objPedido);
                    $objMesa->setIdPedido($objPedido->getIdPedido());
                    $objMesaRN->alterar($objMesa);

                    // $objProdutoRN->cadastrar($objProduto);

                    $alert = Alert::alert_success("Pedido " . $objPedido->getIdPedido() . "  <strong>cadastrado</strong> com sucesso");
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_pedido&idMesa='.$objMesa->getIdMesa().'&idPedido='.$objPedido->getIdPedido()));
                    die();
                }else{
                    $alert = Alert::alert_danger("A mesa tem um pedido em andamento");
                }

            }

            break;

        case 'editar_pedido':
            /*
            $disabled = ' disabled ';

            $objPedido->setIdPedido($_GET['idPedido']);
            $objPedido = $objPedidoRN->consultar($objPedido);

            $arr_todos_produtos = $objProdutoRN->listar($objProduto);

            $arr_produtos = $objPedido->getListaProdutos();

            foreach ($arr_produtos as $produto){
                //$objCategoriaProduto->setIdCategoriaProduto($objProduto->getCategoriaProduto());
                //$objCategoriaProduto = $objCategoriaProdutoRN->consultar($objCategoriaProduto);
                $html.='<tr>
                        <th scope="row"><img src="'.$produto->getStrURLImagem().'" ></th>
                         <td>'.Pagina::formatar_html($produto->getNome()).'</td>
                        <td>'.Pagina::formatar_html($produto->getCategoriaProduto()).'</td>
                        <td>'.Pagina::formatar_html($produto->getPreco()).'</td>';

                $html .= '<td><input type="number" '.$disabled.' class="form-control" placeholder="nº"
                   name="numQuantidade_produtosAntigos'.$objProduto->getIdProduto().'"  value="'.$produto['quantidade'].'"></td>';


                $html .= ' </tr>';

            }
            $html .= '<tr><td colspan="5"> <hr/><hr/></td></tr>';


            if(isset($_POST['btn_editar_pedido'])){

                $objPedido->setIdMesa(intval($_GET['idMesa']));
                $objMesa->setIdMesa($objPedido->getIdMesa());
                $objMesa = $objMesaRN->consultar($objMesa);

                $objPedido->setIdPedido(intval($_GET['idPedido']));
                $objPedido = $objPedidoRN->consultar($objPedido);

                //if($objMesa->getDisponivel()) {
                $objPedido->setDataHora(date("d/m/Y H:i:s"));
                $arr_lista_produtos = $arr_produtos;

                $total = 0;
                $encontrou = false;
                foreach ($arrProdutos as $p) {
                    $encontrou = false;
                    if (isset($_POST['numQuantidade_produto' . $p->getIdProduto()])) {
                        //echo "produ: ".$p->getIdProduto()."\n";
                        //echo "qnt: ".$_POST['numQuantidade_produto'.$p->getIdProduto()]."\n\n";
                        if (strlen($_POST['numQuantidade_produto' . $p->getIdProduto()]) > 0) {

                            for($i=0; $i<count($arr_lista_produtos); $i++){
                                if($p->getIdProduto() == $arr_lista_produtos[$i]['idProduto']){
                                    $encontrou = true;
                                    $arr_lista_produtos[$i] = array("idProduto" => intval($p->getIdProduto()), "quantidade" =>intval(($_POST['numQuantidade_produto' . $p->getIdProduto()]+$arr_lista_produtos[$i]['quantidade'])));
                                    $total += $p->getPreco() * ($_POST['numQuantidade_produto' . $p->getIdProduto()]+$arr_lista_produtos[$i]['quantidade']);
                                }
                            }

                            if(!$encontrou) {
                                $encontrou = false;
                                $arr_lista_produtos[] = array("idProduto" => intval($p->getIdProduto()), "quantidade" => intval($_POST['numQuantidade_produto' . $p->getIdProduto()]));
                                $total += $p->getPreco() * $_POST['numQuantidade_produto' . $p->getIdProduto()];
                            }
                        }
                    }
                }



                //echo $total;
                $objPedido->setPreco(doubleval($total));
                $objPedido->setListaProdutos($arr_lista_produtos);
                $objPedido->setSituacao("andamento");


                //$objMesa = $objMesaRN->consultar();
                $objMesa->setDisponivel(false);
                $objMesa->setEsperandoPedido(true);


                $objPedidoRN->alterar($objPedido);
                $objMesa->setIdPedido($objPedido->getIdPedido());
                $objMesaRN->alterar($objMesa);

                // $objProdutoRN->cadastrar($objProduto);

                $alert = Alert::alert_success("Pedido " . $objPedido->getIdPedido() . " <strong>alterado</strong> com sucesso");
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_pedido&idMesa='.$_GET['idMesa'].'&idPedido='.$_GET['idPedido']));
                die();
            }
            */

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_produto.php');
    }

    $arrProdutos = $objProdutoRN->listar($objProduto);
    /*
    echo "<pre>";
    print_r($arrProdutos);
    echo "</pre>";
    */
    $arrCategorias = $objCategoriaProdutoRN->listar($objCategoriaProduto);
    $contador = 0;
    $colunas =0;
    foreach ($arrCategorias as $categoria) {
        $html .= '<div id="accordion" style="margin-top: 10px;">
                              <div class="card">
                                <div class="card-header" id="heading_'.$contador.'">
                                  <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$contador.'" aria-expanded="true" aria-controls="collapse'.$contador.'">
                                                '.$categoria->getStrCategoria().'
                                            </button>
                                  </h5>
                                </div>
                                <div id="collapse'.$contador.'" class="collapse show" aria-labelledby="heading'.$contador.'" data-parent="#accordion">
                                  <div class="card-body">
                                  ';
        foreach ($arrProdutos as $p){
            if($p->getCategoriaProduto() == $categoria->getStrCategoriaEnglish()) {
                if($colunas == 3){
                    $colunas = 0;
                    $html .= '    </div>
                                </div>
                                <div class="container">
                                  <div class="row">';
                }

                $html .= '<div class="container">
                              <div class="row">
                                <div class="col-sm">
                                  One of three columns
                                </div>
                                <div class="col-sm">
                                  One of three columns
                                </div>
                                <div class="col-sm">
                                  One of three columns
                                </div>
                              </div>
                            </div>';

                $html .= '<div class="col-sm">
                            <div class="card" style="width: 18rem;">
                              <img class="card-img-top" style="width: 100%;" src="' . $p->getStrURLImagem() . '" alt="Card image cap">
                              <div class="card-body">
                                <h5 class="card-title">' . Pagina::formatar_html($p->getNome()) . '</h5>
                                <!-- <p class="card-text">'.$categoria->getStrDescricao().'</p> -->
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                              </div>
                            </div>
                          </div>';

                /*
                $html .= '<table class="table table-hover" >';
                $html .= '<tr>
                        <th scope="row">' . Pagina::formatar_html($p->getIdProduto()) . '</th>
                         <td ><img style="width: 100px;height: 100px;" src="' . $p->getStrURLImagem() . '" ></td>
                         <td>' . Pagina::formatar_html($p->getNome()) . '</td>
                        <td>' . Pagina::formatar_html($p->getCategoriaProduto()) . '</td>
                        <td>' . Pagina::formatar_html($p->getPreco()) . '</td>';

                if (Sessao::getInstance()->verificar_permissao('editar_produto')) {
                    $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_produto&idProduto=' . Pagina::formatar_html($p->getIdProduto())) . '"><i class="fas fa-edit "></i></a></td>';
                }

                if (Sessao::getInstance()->verificar_permissao('remover_produto')) {
                    $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_produto&idProduto=' . Pagina::formatar_html($p->getIdProduto())) . '"><i class="fas fa-trash-alt"></a></td>';
                }

                $html .= ' </tr>';
                $html .= '</table>';
                */
                $colunas++;

            }
        }
        $contador++;
        $html .= '        
                        </div>
                    </div>
                  </div>
                </div>';
    }




} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Realizar Pedido");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();


echo $alert.'
  <div class="container-fluid">
    <h1 class="mt-4">Pedido</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>';
echo '         <li class="breadcrumb-item active">Realizar Pedido</li>';
if(Sessao::getInstance()->verificar_permissao('listar_pedido')) {
    echo '          <li class="breadcrumb-item"><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_pedido') . '">Listar Pedido</a></li>';
}
echo '  </ol>
    </div>';

if($_GET['action'] == 'realizar_pedido') {
    echo '<div class="conteudo_grande" >
    <form method="POST">';
    if (!isset($_GET['idMesa'])) {
        echo ' <div class="col-md-12 mb-3">
            <label >Informe a mesa:</label>
            <input type="number" class="form-control" placeholder="nº mesa" 
                   name="numMesa"  value="' . $objPedido->getIdMesa() . '">
        </div>';
    }
}
echo '<div class="conteudo_grande" >';
echo $html;
echo '</div>';

/*

echo ' <table class="table table-hover">
        <thead>
            <tr>

                <th scope="col">FOTO PRODUTO</th>
                <th scope="col">NOME</th>
                <th scope="col">CATEGORIA</th>
                <th scope="col">PREÇO</th>
                <th scope="col">QUANTIDADE</th>

            </tr>
        </thead>
        <tbody>'
    . $html .
    '</tbody>
    </table>
<button class="btn btn-primary" type="submit" style="width: 30%; margin-left: 35%;" name="btn_salvar_pedido">SALVAR</button>

</form>
</div>';
}
if($_GET['action'] == 'editar_pedido') {
echo '<div class="conteudo_grande" >
<form method="POST">';
    echo '  <div class="form-row">
        <div class="col-md-12 mb-3">
    <label >Número da mesa:</label>
    <input  type="number" class="form-control" placeholder="nº mesa"
           name="numMesa"  value="' . $objPedido->getIdMesa() . '">
           </div>
</div>';

echo '  <div class="form-row">
<div class="col-md-12">
        <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">PRODUTO</th>
                <th scope="col">NOME</th>
                <th scope="col">CATEGORIA</th>
                <th scope="col">PREÇO</th>
                <th scope="col">QUANTIDADE</th>

            </tr>
            <tr>
                <td colspan="3">
                    <strong>-</strong>
                </td>
                <td colspan="1">
                    <strong>Total:</strong>
                </td>
                <td>R$
                    '.$objPedido->getPreco().'
                </td>
            </tr>

        </thead>
        <tbody>'
    . $html .'
     <tr>
                <td colspan="3">
                    <strong>-</strong>
                </td>
                <td colspan="1">
                    <strong>Total:</strong>
                </td>
                <td>R$
                    '.$objPedido->getPreco().'
                </td>
            </tr>
    </tbody>
    </table>
    </div>
    </div>

<div class="form-row" style="margin-left: -25%;">
    <div class="col-md-6">
        <button class="btn btn-primary" type="submit" style="width: 80%;margin-left: 30%; " name="btn_editar_pedido">EDITAR PEDIDO</button>
    </div>

    <div class="col-md-6">
        <button class="btn btn-primary" type="submit" style="width: 80%;margin-right: 15%; " name="btn_pagar_pedido">FINALIZAR PEDIDO</button>
    </div>
</div>

</form>
</div>';
}

*/


Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();