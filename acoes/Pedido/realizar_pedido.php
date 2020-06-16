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

                if($objMesa->getDisponivel()) {
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


                    $objPedidoRN->cadastrar($objPedido);
                    $objMesa->setIdPedido($objPedido->getIdPedido());
                    $objMesaRN->alterar($objMesa);

                    // $objProdutoRN->cadastrar($objProduto);

                    $alert = Alert::alert_success("Pedido " . $objPedido->getIdPedido() . "  <strong>cadastrado</strong> com sucesso");
                }else{
                    $alert = Alert::alert_danger("A mesa tem um pedido em andamento");
                }

            }

            break;

        case 'editar_pedido':
            $disabled = ' disabled ';

            $objPedido->setIdPedido($_GET['idPedido']);
            $objPedido = $objPedidoRN->consultar($objPedido);

            $arr_todos_produtos = $objProdutoRN->listar($objProduto);

            $arr_produtos = $objPedido->getListaProdutos();

            foreach ($arr_produtos as $produto){
                $objProduto->setIdProduto($produto['idProduto']);
                $objProduto = $objProdutoRN->consultar($objProduto);

                if($objProduto->getCategoriaProduto() == 2 || $objProduto->getCategoriaProduto() == 1 || $objProduto->getCategoriaProduto() == 8){ //massas,frangos e massas
                    $style = ' width="100px" height="80px" ';
                }else{
                    $style = ' width="50px" height="80px" ';
                }
                $objCategoriaProduto->setIdCategoriaProduto($objProduto->getCategoriaProduto());
                $objCategoriaProduto = $objCategoriaProdutoRN->consultar($objCategoriaProduto);
                $html.='<tr>
                        <th scope="row"><img '.$style.'  src="'.$objProduto->getCaminhoImgSistWEB().'" ></th>
                         <td>'.Pagina::formatar_html($objProduto->getNome()).'</td>
                        <td>'.Pagina::formatar_html($objCategoriaProduto->getDescricao()).'</td>
                        <td>'.Pagina::formatar_html($objProduto->getPreco()).'</td>';

                $html .= '<td><input type="number" '.$disabled.' class="form-control" placeholder="nº" 
                   name="numQuantidade_produtosAntigos'.$objProduto->getIdProduto().'"  value="'.$produto['quantidade'].'"></td>';


                $html .= ' </tr>';
                /*if($_POST['numQuantidade_produtosAntigos'.$objProduto->getIdProduto()]){
                    $arr_lista_produtos[] = array("idProduto" => $objProduto->getIdProduto(), "quantidade" =>$_POST['numQuantidade_produtosAntigos'.$objProduto->getIdProduto()]);
                    $total += $objProduto->getPreco() * $_POST['numQuantidade_produtosAntigos'.$objProduto->getIdProduto()];
                }*/
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

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_produto.php');
    }

    foreach ($arrProdutos as $p){
        if($p->getCategoriaProduto() == 2 || $p->getCategoriaProduto() == 1 || $p->getCategoriaProduto() == 8){ //massas,frangos e massas
            $style = ' width="100px" height="80px" ';
        }else{
            $style = ' width="50px" height="80px" ';
        }
        $objCategoriaProduto->setIdCategoriaProduto($p->getCategoriaProduto());
        $objCategoriaProduto = $objCategoriaProdutoRN->consultar($objCategoriaProduto);
        $html.='<tr>
                       
                         <th scope="row"><img '.$style.'  src="'.$p->getCaminhoImgSistWEB().'" ></th>
                         <td>'.Pagina::formatar_html($p->getNome()).'</td>
                        <td>'.Pagina::formatar_html($objCategoriaProduto->getDescricao()).'</td>
                        <td>'.Pagina::formatar_html($p->getPreco()).'</td>';

        $html .= '<td><input type="number" class="form-control" placeholder="nº" 
                   name="numQuantidade_produto'.$p->getIdProduto().'"  value="'.$_POST['numQuantidade_produto'.$p->getIdProduto()].'"></td>';


        $html .= ' </tr>';
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
    <!-- <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_numero_Prato">Informe o nome do produto:</label>
            <input type="text" class="form-control" placeholder="prato" 
                   onblur="" name="txtNome"  value="' . Pagina::formatar_html($objProduto->getNome()) . '">
        </div>
        <div class="col-md-4 mb-3">
            <label for="label_numero_Prato">Selecione a categoria do produto:</label>
            ' . $select_categorias . '
        </div>
        <div class="col-md-4 mb-3">
            <label for="label_numLugares">Informe o preço do produto:</label>
            <input type="number" class="form-control" placeholder="R$" step="any"
                   name="numPreco"  value="' . Pagina::formatar_html($objProduto->getPreco()) . '">
        </div>
    </div> --> 
    <button class="btn btn-primary" type="submit" style="width: 30%; margin-left: 35%;" name="btn_salvar_pedido">SALVAR</button>
        
</form>
</div>';
}
if($_GET['action'] == 'editar_pedido') {
    echo '<div class="conteudo_grande" >
    <form method="POST">';

   /* echo ' <div class="col-md-12 mb-3">
        <label >Situação pedido:</label>
        <input '.$disabled.' type="number" class="form-control" placeholder="" 
               name="situacaoPedido"  value="' . $objPedido->getSituacao() . '">
    </div>';*/

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


Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();