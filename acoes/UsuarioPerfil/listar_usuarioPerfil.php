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


    Sessao::getInstance()->validar();
    $html = '';
    $alert = '';


    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();
    
    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    
    $arrUsuarios = $objUsuarioRN->listar($objUsuario);

    foreach ($arrUsuarios as $usuario){



        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($usuario->getCPF()).'</th>';
        $html .=    '<td>'.Pagina::formatar_html(PerfilUsuarioRN::mostrarDescricaoTipoUsuario($usuario->getListaPerfis()[0])).'</td>';


        if(Sessao::getInstance()->verificar_permissao('editar_usuario_perfilUsuario')) {
            $html .= '  <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_usuario_perfilUsuario&idUsuario=' . $usuario->getIdUsuario()) . '"><i class="fas fa-edit "></i></a></td>';
        }
        if(Sessao::getInstance()->verificar_permissao('remover_usuario_perfilUsuario')) {
            $html .= '  <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_usuario_perfilUsuario&idUsuario=' . $usuario->getIdUsuario()) . '"><i class="fas fa-trash-alt"></a></td>';
        }
        $html .= ' </tr>';
    }
    
       
} catch (Throwable $ex) {
     Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar relacionamento usuário com seus perfis");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();

echo $alert;
echo '

    <div class="container-fluid">
    <h1 class="mt-4">Usuário + Perfil Usuário</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>
            <li class="breadcrumb-item active">Cadastrar Usuário + Perfil Usuário</a></li>
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario_perfilUsuario').'">Listar Usuário + Perfil Usuário</li>
        </ol>
    </div>
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


Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();