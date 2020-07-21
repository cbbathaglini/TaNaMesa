<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try {

    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Mesa/Mesa.php';
    require_once __DIR__ . '/../../classes/Mesa/MesaRN.php';

    require_once __DIR__ . '/../../classes/Produto/Produto.php';
    require_once __DIR__ . '/../../classes/Produto/ProdutoRN.php';

    require_once __DIR__ . '/../../classes/Pedido/Pedido.php';
    require_once __DIR__ . '/../../classes/Pedido/PedidoRN.php';

    require_once __DIR__ . '/../../classes/Historico/Historico.php';
    require_once __DIR__ . '/../../classes/Historico/HistoricoRN.php';

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

    $objHistorico = new Historico();
    $objHistoricoRN = new HistoricoRN();

    $objMesa = new Mesa();
    $objMesaRN = new MesaRN();

    $alert = '';
    $caractere = '';
    $card = '';
    $encontrouPedido = false;

    $objPedido->setIdMesa($_GET['idMesa']);
    $encontrouPedido = false;
    $lista_produtos = '<table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Produto</th>
                              <th scope="col">Quantidade</th>
                              <th scope="col">Preço</th>
                            </tr>
                          </thead>
                          <tbody>';

    $objPedido->setIdPedido($_GET['idMesa']);
    $pedido = $objPedidoRN->consultar($objPedido);

    $arrPedidos = $objPedidoRN->listar($objPedido);
    foreach ($arrPedidos as $pedido) {
        //print_r($pedido);
        if ($pedido->getIdMesa() == $_GET['idMesa']) {
            foreach ($pedido->getListaProdutos() as $p) {
                $arr_nomespe[] = $p->getNome();

            }
            $arr_pe = array_count_values($arr_nomespe);
            //print_r($arr_pe);
            //die();
            $colunas = 0;
            $cardPedido .= '<div class="form-row"  style="margin-left: 0;">';
            $nomesValidos = array();
            $dataHora = '';
            $precoTotal = 0;
            $dataHora = $pedido->getListaProdutos()[0]->getDataHora();
            foreach ($pedido->getListaProdutos() as $p) {
                foreach ($arr_pe as $pe => $value) {
                    if(!in_array($p->getNome(), $nomesValidos)) {
                        if ($pe == $p->getNome()) {
                            $nomesValidos[] = $p->getNome();
                            if ($colunas == 4) {
                                $colunas = 0;
                                $cardPedido .= '    </div>
                          <div class="form-row"  style="margin-left: 0;">';
                            }
                            $cardPedido .= '<div class="col-md-3">
                            <div class="card" style="width:100%;">
                              <img class="card-img-top" style="width:100%;" src="' . $p->getStrURLImagem() . '" alt="Card image cap">
                              <div class="card-body">
                                <h5 class="card-title" style="height: 80px">' . $p->getNome() . '</h5>
                                <hr>
                                <!--<p class="card-text">' . $p->getNome() . '</p>-->
                                <input type="number"  class="form-control" placeholder="quantidade" 
                               name="numQuantidade_' . $p->getIdProduto() . '"  value="' . $value . '">
                             
                                <button type="submit" style="width:100%;margin-left: 0;margin-top: 5px; background: #ddd;" class="btn btn-primary" name="btn_remove_' . $p->getIdProduto() . '">
                                     Remover do pedido <i class="fas fa-cart-arrow-down" style="color: red;"></i>
                                </button>
                              </div>
                            </div>
                           </div>';
                            $colunas++;

                            $preco = explode(' ', $p->getPreco());

                            $lista_produtos .= ' <tr>
                                                      <th scope="row">'.$p->getNome().'</th>
                                                      <td>'.$value.'</td>
                                                      <td>'.($value * $preco[1]).'</td>
                                                     
                                                    </tr>';

                            $precoTotal += ($value * $preco[1]);
                            if (isset($_POST['btn_remove_' . $p->getIdProduto()])) {
                                //echo $_POST['numQuantidade_' . $p->getIdProduto()];

                                for ($i = 0; $i < $_POST['numQuantidade_' . $p->getIdProduto()]; $i++) {
                                    $dtNova = date("d/m/Y H:i:s");
                                    $dt = explode(" ", $dtNova);
                                    $data = explode("/", $dt[0]);
                                    $horario = explode(":", $dt[1]);
                                    $arrData['date'] = array('year' => $data[2], 'month' => $data[1], 'day' => $data[0], 'hours' => $horario[0], 'minutes' => $horario[1], 'seconds' => $horario[2]);
                                    $p->setDataHora($arrData);
                                    $arr_produtos[] = $p;

                                }
                                foreach ($pedido->getListaProdutos() as $produtos) {
                                    if($produtos->getNome() != $p->getNome()) {
                                        $dt = explode(" ", $produtos->getDataHora());
                                        $data = explode("/", $dt[0]);
                                        $horario = explode(":", $dt[1]);
                                        $arrData2['date'] = array('year' => $data[2], 'month' => $data[1], 'day' => $data[0], 'hours' => $horario[0], 'minutes' => $horario[1], 'seconds' => $horario[2]);
                                        $produtos->setDataHora($arrData2);
                                        $arr_produtos[] = $produtos;
                                    }
                                }
                                $pedido->setListaProdutos($arr_produtos);
                                //$objPedido->setPreco($precoTotal);

                                echo "<pre>";
                                //print_r($pedido);
                                echo "</pre>";

                                $pedido->setIdPedido($_GET['idMesa']);
                                $pedido->setIdMesa($_GET['idMesa']);
                                //die();

                                $objPedido = $objPedidoRN->cadastrar($pedido);
                                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_pedido&idMesa='.$_GET['idMesa']));
                                die();
                            }
                        }
                    }

                }
            }
            $lista_produtos .= ' <tr>
                                  <th scope="row">Preço total:</th>
                                  <td colspan="2">'.$precoTotal.'</td>                                    
                                </tr>';
            if(isset($_POST['btn_finalizar_pedido'])){
                $dtHr = explode(" ", $dataHora);
                $dias = explode("/", $dtHr[0]);
                $strIdHistorico = $dias[0]."_".$dias[1]."_".$dias[2];

                $arr_produtos = array();
                $lista_historicos = $objHistoricoRN->listar($objHistorico);
                //echo "<pre>";
                //print_r($lista_historicos);
                //echo "</pre>";
                //die("aaa");
                foreach ($lista_historicos as $historico){
                    if($historico->getDataHistorico()  == $strIdHistorico){
                        //$arr_produtos[] = $historico->getObjProdutos();
                        //$arr_produtos[] = $pedido->getListaProdutos();
                        $result = array_merge($historico->getObjProdutos(), $pedido->getListaProdutos());
                        $objHistorico->setObjProdutos($result);
                        $objHistorico = $objHistoricoRN->cadastrar($objHistorico);
                        $encontrouHistorico = true;
                    }
                }

                if(!$encontrouPedido){
                    $objHistorico->setDataHistorico(date("d_m_Y"));
                    $objHistorico->setObjProdutos($pedido->getListaProdutos());
                    $objHistorico->setIdMesa($_GET['idMesa']);
                    $objHistorico = $objHistoricoRN->cadastrar($objHistorico);
                }
                //echo $precoTotal;
                //echo $dataHora;

                $objPedido->setIdPedido($_GET['idMesa']);
                $objPedido = $objPedidoRN->remover($objPedido);

                $objMesa->setIdMesa($_GET['idMesa']);
                $objMesa->setDisponivel(true);
                $objMesa->setBoolPrecisaFunc(false);
                $objMesa->setEsperandoPedido(false);
                $objMesa = $objMesaRN->alterar($objMesa);
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=principal'));
                die();
                //die();
            }
        }
    }


    if (isset($_POST['btn_salvar_mesa'])) {
        $objMesa->setIdMesa(intval($_POST['numMesa']));
        $objMesa = $objMesaRN->consultar($objMesa);

        if ($objMesa->getDisponivel()) {
            $objMesa->setDisponivel(false);
            $objMesa = $objMesaRN->alterar($objMesa);
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_pedido&idMesa=' . $objMesa->getIdMesa()));
            die();
        } else {
            $alert .= Alert::alert_warning("A mesa não está disponível");
        }
    }


    $arrCategorias = $objCategoriaProdutoRN->listar($objCategoriaProduto);
    foreach ($arrCategorias as $categoria) {
        if (isset($_POST['btn_' . $categoria->getIdCategoriaProduto()])) {
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_pedido&idMesa=' . $_GET['idMesa'] . '&idCategoria=' . $categoria->getIdCategoriaProduto()));
            die();
                }
            }

            if (isset($_GET['idMesa']) && isset($_GET['idCategoria'])  ) {
                $objCategoriaProduto->setIdCategoriaProduto($_GET['idCategoria']);
                $objCategoriaProduto = $objCategoriaProdutoRN->consultar($objCategoriaProduto);

                $arrProdutos = $objProdutoRN->listar($objProduto);
                $card .= '<div class="form-row"  style="margin-left: 0;">';
                $colunas = 0;
                $contador =0;
                foreach ($arrProdutos as $produto) {
                    if ($produto->getCategoriaProduto() == $objCategoriaProduto->getStrCategoriaEnglish()) {
                        if ($colunas == 4) {
                            $colunas = 0;
                            $card .= '    </div>
                                  <div class="form-row"  style="margin-left: 0;">';
                        }
                        $card .= '<div class="col-md-3">
                            <div class="card" style="width:100%;">
                              <img class="card-img-top" style="width:100%;" src="' . $produto->getStrURLImagem() . '" alt="Card image cap">
                              <div class="card-body">
                                <h5 class="card-title" style="height: 80px">' . $produto->getNome() . '</h5>
                                <hr>
                                <!--<p class="card-text">' . $produto->getNome() . '</p>-->
                                <input type="number" class="form-control" placeholder="quantidade" 
                               name="numQuantidade_'.$contador . $produto->getIdProduto() . '"  value="' . $_POST['numQuantidade_'.$contador . $produto->getIdProduto()] . '">
                                <button type="submit" style="width:100%;margin-left: 0;margin-top: 5px;" class="btn btn-primary" name="btn_add_' . $produto->getIdProduto() . '">
                                    Adicionar ao pedido <i class="fas fa-cart-plus"></i>
                                </button>
                              </div>
                            </div>
                           </div>';
                        $colunas++;

                        if (isset($_POST['btn_add_' . $produto->getIdProduto()])) {
                            $objPedido->setIdMesa($_GET['idMesa']);
                            $objPedido->setSituacao('andamento');
                            $objPedido->setIdPedido($_GET['idMesa']);
                            $dtNova = date("d/m/Y H:i:s");
                            $dt = explode(" ", $dtNova);
                            $data = explode("/", $dt[0]);
                            $horario = explode(":", $dt[1]);

                            $arrData['date'] = array('year' => $data[2], 'month' => $data[1], 'day' => $data[0], 'hours' => $horario[0], 'minutes' => $horario[1], 'seconds' => $horario[2]);
                            $objPedido->setDataHora($dtNova);
                            $arrPedidos = $objPedidoRN->listar($objPedido);
                            //echo "<pre>";
                            //print_r($arrPedidos);
                            //echo "</pre>";

                            foreach ($arrPedidos as $pedido) {
                                if ($pedido->getIdMesa() == $_GET['idMesa']) {
                                    $encontrouPedido = true;
                                    //print_r($pedido->getListaProdutos());
                                    //$arr_produtos_anteriores = $pedido->getListaProdutos();

                                    $precoTotal = $pedido->getPreco();
                                    $objProdutoPedido = new Produto();
                                    $objProdutoRN = new ProdutoRN();
                                    $objProdutoPedido->setIdProduto($produto->getIdProduto());
                                    $objProdutoPedido->setCategoriaProduto($produto->getCategoriaProduto());
                                    $novoProduto = $objProdutoRN->consultar($objProdutoPedido);
                                    $novoProduto->setDataHora($arrData);

                                    echo $_POST['numQuantidade_'.$contador . $produto->getIdProduto()];
                                    for ($i = 0; $i < $_POST['numQuantidade_'.$contador . $produto->getIdProduto()]; $i++) {
                                        $arr_produtos[] = $novoProduto;

                                        //$preco = explode(' ', $novoProduto->getPreco());
                                        //$precoTotal += $preco[1];
                                    }
                                    foreach ($pedido->getListaProdutos() as $produtos) {
                                        $arr_produtos[] = $produtos;
                                    }
                                    //print_r($arr_produtos);
                                    //die();
                                    $objPedido->setListaProdutos($arr_produtos);
                                    //$objPedido->setPreco($precoTotal);
                                    //echo "<pre>";
                                   // print_r($objPedido);
                                   // echo "</pre>";

                                    //die("a1");
                                    $objPedido = $objPedidoRN->cadastrar($objPedido);

                                    $objMesa->setIdMesa($_GET['idMesa']);
                                    $objMesa = $objMesaRN->consultar($objMesa);
                                    $objMesa->setDisponivel(false);
                                    $objMesa->setBoolPrecisaFunc(false);
                                    $objMesa = $objMesaRN->alterar($objMesa);


                                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_pedido&idMesa='.$_GET['idMesa']));
                                    die();


                                }
                            }

                            if (!$encontrouPedido) {
                                $precoTotal = 0;
                                $objProdutoPedido = new Produto();
                                $objProdutoRN = new ProdutoRN();
                                $objProdutoPedido->setIdProduto($produto->getIdProduto());
                                $objProdutoPedido->setCategoriaProduto($produto->getCategoriaProduto());
                                $novoProduto = $objProdutoRN->consultar($objProdutoPedido);
                                $novoProduto->setDataHora($arrData);


                                for ($i = 0; $i < $_POST['numQuantidade_'.$contador . $produto->getIdProduto()]; $i++) {
                                    $arr_produtos[] = $novoProduto;
                                }
                                $objPedido->setListaProdutos($arr_produtos);
                                $objPedido->setPreco($precoTotal);

                                $objPedido = $objPedidoRN->cadastrar($objPedido);

                                $objMesa->setIdMesa($_GET['idMesa']);
                                $objMesa = $objMesaRN->consultar($objMesa);
                                $objMesa->setDisponivel(false);
                                $objMesa->setBoolPrecisaFunc(false);
                                $objMesa = $objMesaRN->alterar($objMesa);
                                //print_r($objPedido);
                                //die();

                                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_pedido&idMesa='.$_GET['idMesa']));
                                die();
                            }
                        }
                    }
                    $contador++;
                }
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


echo '
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
echo $alert;

/*if(isset($_POST['btn_finalizar_pedido'])){
    echo $lista_produtos;
    echo '    </tbody>
            </table>';
}*/

echo '<div class="conteudo_grande" >
          <form method="POST" style="margin-left: 0;width:100%;">';
echo $cardPedido;
if(strlen($cardPedido) > 0) {
    echo '<h3> Preço Total: '.$precoTotal.'</h3>';
    echo '<div class="col-md-12 mb-3">
            <button class="btn btn-primary" type="submit" name="btn_finalizar_pedido">Finalizar Pedido</button>
        </div>';
}
echo '    </form>
      </div>';

        if ($_GET['action'] == 'realizar_pedido' && !isset($_GET['idMesa'])) {
            echo '<div class="conteudo_grande" >
                <form method="POST">
                    <div class="col-md-12 mb-3">
                        <label >Informe a mesa:</label>
                        <input type="number" class="form-control" placeholder="nº mesa" 
                               name="numMesa"  value="' . $objPedido->getIdMesa() . '">
                    </div>
                    <div class="col-md-12 mb-3">
                        <button class="btn btn-primary" type="submit" name="btn_salvar_mesa">SELECIONAR</button>
                    </div>
                </form>
            </div>';
        }

        if (isset($_GET['idMesa'])) {
            $arrCategorias = $objCategoriaProdutoRN->listar($objCategoriaProduto);

            echo '<div class="conteudo_grande" style="margin-top:-20px;">
                <form method="POST" style="margin-left: 0;width:100%;">
                    <div class="form-row"  style="margin-left: 0;">';
            $contador = 0;
            foreach ($arrCategorias as $categoria) {
                if ($contador == 4) {
                    $contador = 0;
                    echo '   </div>
                                 <div class="form-row">';
                }
                echo '<div class="col-md-3 mb-3">
                                <button class="btn btn-primary" style="width: 100%;margin-left: 0;padding: 20px;" type="submit" name="btn_' . $categoria->getIdCategoriaProduto() . '">' . $categoria->getStrCategoria() . '</button>
                          </div>';
                $contador++;
            }
            echo '      </form>
            </div>';
        }

        echo '<div class="conteudo_grande" >
          <form method="POST" style="margin-left: 0;width:100%;">';
        echo $card;
        echo '    </form>
      </div>';

        echo '<div class="conteudo_grande" >';
        echo $html;
        echo '</div>';
//        break;
//    case 'editar_pedido':

 //       break;
//}
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
