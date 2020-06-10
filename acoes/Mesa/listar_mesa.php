<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Mesa/Mesa.php';
    require_once __DIR__.'/../../classes/Mesa/MesaRN.php';
    require_once __DIR__.'/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $objMesa = new Mesa();
    $objMesaRN = new MesaRN();
    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_mesa':
            try{
                $objMesa->setIdMesa($_GET['idMesa']);
                $objMesaRN->remover($objMesa);
                $alert .= Alert::alert_success("Mesa removida com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    $arrMesas = $objMesaRN->listar(new Mesa());

    foreach ($arrMesas as $m){
        if($m->getDisponivel()){
            $style = ' style="background: rgba(0,255,0,0.2);" ';
            $txtDisp = ' sim ';
        }else{
            $style = ' style="background: rgba(255,0,0,0.2);" ';
            $txtDisp = ' não ';
        }
        if($m->getBoolPrecisaFunc()){ $txtPrecisa = ' sim '; }
        else{ $txtPrecisa = ' não ';  }
        if($m->getEsperandoPedido()){ $txtEsperando = ' sim '; }
        else{ $txtEsperando = ' não ';}

        $html.='<tr>
                        <th scope="row">'.Pagina::formatar_html($m->getIdMesa()).'</th>
                        <td '.$style.'>'.Pagina::formatar_html($txtDisp).'</td>
                        <td>'.Pagina::formatar_html($txtPrecisa).'</td>
                        <td>'.Pagina::formatar_html($txtEsperando).'</td>
                        ';

        if(Sessao::getInstance()->verificar_permissao('editar_mesa')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_mesa&idMesa='.Pagina::formatar_html($m->getIdMesa())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_mesa')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_mesa&idMesa='.Pagina::formatar_html($m->getIdMesa())).'"><i class="fas fa-trash-alt"></a></td>';
        }

        $html .= ' </tr>';
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Recursos");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();

echo $alert.'
    <div class="container-fluid">
    <h1 class="mt-4">Mesa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_mesa').'">Cadastrar Mesa</a></li>
            <li class="breadcrumb-item active">Listar Mesa</li>
        </ol>
    </div>
    <div class="conteudo_listar">'.
    '<div class="conteudo_tabela"><table class="table table-hover">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">DISPONÍVEL</th>
                        <th scope="col">PRECISA DE FUNCIONÁRIO</th>
                        <th scope="col">ESPERANDO PEDIDO</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>'
    .$html.
    '</tbody>
              </table>
        </div>
    </div>';


Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();


