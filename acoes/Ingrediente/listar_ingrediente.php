<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Ingrediente/Ingrediente.php';
    require_once __DIR__ . '/../../classes/Ingrediente/IngredienteRN.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    Sessao::getInstance()->validar();

    $objIngrediente = new Ingrediente();
    $objIngredienteRN = new IngredienteRN();

    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_ingrediente':
            try{
                $objIngrediente->setIdIngrediente($_GET['idIngrediente']);
                $objIngredienteRN->remover($objIngrediente);
                $alert .= Alert::alert_success("Ingrediente removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    $arrIngredientes = $objIngredienteRN->listar(new Ingrediente());

    foreach ($arrIngredientes as $i){
        $html.='<tr>
                        <th scope="row">'.Pagina::formatar_html($i->getIdIngrediente()).'</th>
                        <td>'.Pagina::formatar_html($i->getIngrediente()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_ingrediente')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_ingrediente&idIngrediente='.Pagina::formatar_html($i->getIdIngrediente())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_ingrediente')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_ingrediente&idIngrediente='.Pagina::formatar_html($i->getIdIngrediente())).'"><i class="fas fa-trash-alt"></a></td>';
        }

        $html .= ' </tr>';
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Ingredientes");
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
                        <th scope="col">NOME DO INGREDIENTE</th>
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

