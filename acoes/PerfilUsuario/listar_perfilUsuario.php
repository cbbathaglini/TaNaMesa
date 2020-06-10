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

    Sessao::getInstance()->validar();

    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();
    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_perfilUsuario':
            try{
                $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
                $objPerfilUsuarioRN->remover($objPerfilUsuario);
                $alert .= Alert::alert_success("Perfil removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }

    $objPerfilUsuario = new PerfilUsuario();
    $arrPerfisUsuarios = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    foreach ($arrPerfisUsuarios as $pu){
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($pu->getIdPerfilUsuario()).'</th>
                    <td>'.Pagina::formatar_html($pu->getPerfil()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_perfil_usuario')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_perfil_usuario&idPerfilUsuario='.Pagina::formatar_html($pu->getIdPerfilUsuario())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_perfil_usuario')) {
            $html .= ' <td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_perfil_usuario&idPerfilUsuario=' . Pagina::formatar_html($pu->getIdPerfilUsuario())).'"><i class="fas fa-trash-alt"></a></td>';
        }
        $html .= '</tr>';
    }

} catch (Throwable $ex) {
      Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Perfis de Usuários");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();
echo $alert.'
<div class="container-fluid">
    <h1 class="mt-4">Perfil Usuário</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_perfil_usuario').'">Cadastrar Perfil Usuário</a></li>
            <li class="breadcrumb-item active">Listar Perfil Usuário</li>
        </ol>
    </div>
    <div class="conteudo_grande" style="margin-top: -20px;" >
            <table class="table table-hover"  >
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">perfil</th>';
if(Sessao::getInstance()->verificar_permissao('editar_perfil_usuario')) {echo '<th scope="col"></th>';};
if(Sessao::getInstance()->verificar_permissao('remover_perfil_usuario')) {echo'<th scope="col"></th>';}
echo '             </tr>
                </thead>
                <tbody>'
                     .$html.
                '</tbody>
            </table> 
    </div>';


Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();

