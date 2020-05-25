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
        if($m->getSituacao() == MesaRN::$STA_LIBERADA){
            $style = ' style="background: rgba(0,255,0,0.2);" ';
        }else{
            $style = ' style="background: rgba(255,0,0,0.2);" ';
        }

        $html.='<tr'.$style.'>
                        <th scope="row">'.Pagina::formatar_html($m->getIdMesa()).'</th>
                        <td>'.Pagina::formatar_html($m->getNumero()).'</td>
                        <td>'.Pagina::formatar_html($m->getNumLugares()).'</td>
                        <td>'.Pagina::formatar_html(MesaRN::mostrarDescricaoSituacaoMesa($m->getSituacao())).'</td>';

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
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
//Pagina::montar_topo_listar('LISTAR ME',null,null, 'cadastrar_recurso', 'NOVO RECURSO');
Pagina::getInstance()->mostrar_excecoes();

echo $alert.'
    <div class="conteudo_listar">'.
    '<div class="conteudo_tabela"><table class="table table-hover">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">NÚMERO</th>
                        <th scope="col">NÚMERO DE LUGARES</th>
                        <th scope="col">SITUAÇÃO</th>
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


Pagina::getInstance()->fechar_corpo();

