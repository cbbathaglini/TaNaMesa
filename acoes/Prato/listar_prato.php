<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Prato/Prato.php';
    require_once __DIR__.'/../../classes/Prato/PratoRN.php';
    require_once __DIR__.'/../../classes/CategoriaPrato/CategoriaPrato.php';
    require_once __DIR__.'/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $objPrato = new Prato();
    $objPratoRN = new PratoRN();

    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_prato':
            try{
                $objPrato->setIdPrato($_GET['idPrato']);
                $objPratoRN->remover($objPrato);
                $alert .= Alert::alert_success("Prato removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    $arrPratos = $objPratoRN->listar(new Prato());

    foreach ($arrPratos as $p){

        $html.='<tr>
                        <th scope="row">'.Pagina::formatar_html($p->getIdPrato()).'</th>
                        <td>'.Pagina::formatar_html($p->getNome()).'</td>
                        <td>'.Pagina::formatar_html(CategoriaPrato::mostrarDescricaoCategoriaPrato($p->getCategoriaPrato())).'</td>
                        <td>'.Pagina::formatar_html($p->getInformacoes()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_prato')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_prato&idPrato='.Pagina::formatar_html($p->getIdPrato())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_prato')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_prato&idPrato='.Pagina::formatar_html($p->getIdPrato())).'"><i class="fas fa-trash-alt"></a></td>';
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

