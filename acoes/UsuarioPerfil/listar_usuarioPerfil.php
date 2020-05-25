<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';

    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuario.php';
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuarioRN.php';

    require_once __DIR__ . '/../../classes/Usuario/Usuario.php';
    require_once __DIR__ . '/../../classes/Usuario/UsuarioRN.php';

    require_once __DIR__ . '/../../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario.php';
    require_once __DIR__ . '/../../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario_RN.php';

    Sessao::getInstance()->validar();
    $html = '';

     /* USUÁRIO + PERFIL DO USUÁRIO */
    $objRel_usuario_perfilUsuario = new Rel_usuario_perfilUsuario();
    $objRel_usuario_perfilUsuario_RN = new Rel_usuario_perfilUsuario_RN();

    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();
    
    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    
    $arr_usuarios_com_perfil = $objRel_usuario_perfilUsuario_RN->listar_usuario_com_perfil(new Rel_usuario_perfilUsuario());

    foreach ($arr_usuarios_com_perfil as $usuarioPerfil){
        $strPerfis = '';
        foreach ($usuarioPerfil->getObjPerfis() as $perfil){
            $strPerfis .= $perfil->getPerfil().",";
        }
        if($strPerfis == ''){
            $strPerfis = ' - ';
        }
        $strPerfis = substr($strPerfis,0,-1);

        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($usuarioPerfil->getCPF()).'</th>';
        $html .=    '<td>'.Pagina::formatar_html($strPerfis).'</td>';


        if(Sessao::getInstance()->verificar_permissao('editar_usuario_perfilUsuario')) {
            $html .= '  <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_usuario_perfilUsuario&idUsuario=' . $usuarioPerfil->getIdUsuario()) . '"><i class="fas fa-edit "></i></a></td>';
        }
        if(Sessao::getInstance()->verificar_permissao('remover_usuario_perfilUsuario')) {
            $html .= '  <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_usuario_perfilUsuario&idUsuario=' . $usuarioPerfil->getIdUsuario()) . '"><i class="fas fa-trash-alt"></a></td>';
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
