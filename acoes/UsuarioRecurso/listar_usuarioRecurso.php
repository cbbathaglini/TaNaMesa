<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';

    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Recurso/Recurso.php';
    require_once __DIR__ . '/../../classes/Recurso/RecursoRN.php';

    require_once __DIR__ . '/../../classes/Usuario/Usuario.php';
    require_once __DIR__ . '/../../classes/Usuario/UsuarioRN.php';


    Sessao::getInstance()->validar();
    $html = '';

    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();
    
    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();

    $arrUsuarios = $objUsuarioRN->listar($objUsuario);
    //print_r($arrUsuarios);

    foreach ($arrUsuarios as $usuario){
        $strRecursos = '';
        $arrRecursos =  explode(",",$usuario->getListaRecursos());
        //print_r($arrPerfis);

        foreach ($arrRecursos as $recurso){
            $objRecurso->setIdRecurso($recurso);
            $objRecurso = $objRecursoRN->consultar($objRecurso);
            $strRecursos .= $objRecurso->getNome().",";
        }
        if($strRecursos == ''){
            $strRecursos = ' - ';
        }
        $strRecursos = substr($strRecursos,0,-1);

        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($usuario->getCPF()).'</th>';
        $html .=    '<td>'.Pagina::formatar_html($strRecursos).'</td>';


        if(Sessao::getInstance()->verificar_permissao('editar_usuario_recurso')) {
            $html .= '  <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_usuario_recurso&idUsuario=' . $usuario->getIdUsuario()) . '"><i class="fas fa-edit "></i></a></td>';
        }
        if(Sessao::getInstance()->verificar_permissao('remover_usuario_recurso')) {
            $html .= '  <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_usuario_recurso&idUsuario=' . $usuario->getIdUsuario()) . '"><i class="fas fa-trash-alt"></a></td>';
        }
        $html .= ' </tr>';
    }
    
       
} catch (Throwable $ex) {
     Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Usuários");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
//Pagina::montar_topo_listar('LISTAR RELACIONAMENTO DO USUÁRIO COM SEU PERFIL',null,null, 'cadastrar_usuario_perfilUsuario', 'NOVO USUÁRIO + PERFIL');

Pagina::getInstance()->mostrar_excecoes();
echo '
    <div class="conteudo_listar">'.
        '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">USUÁRIO</th>
                        <th scope="col">PERFIL</th>';
if(Sessao::getInstance()->verificar_permissao('editar_usuario_perfilUsuario')) {echo '<th scope="col"></th>';}
if(Sessao::getInstance()->verificar_permissao('remover_usuario_perfilUsuario')) {echo '<th scope="col"></th>';}
                   
echo '              </tr>
                </thead>
                <tbody>'
                    .$html.
                '</tbody>
            </table>
        </div>
    </div>';


Pagina::getInstance()->fechar_corpo();
