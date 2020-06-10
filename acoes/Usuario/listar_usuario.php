<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Usuario/Usuario.php';
    require_once __DIR__ . '/../../classes/Usuario/UsuarioRN.php';


    Sessao::getInstance()->validar();

    $objPagina = new Pagina();
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    $html = '';
    $alert = '';
    $arrUsuarios = $objUsuarioRN->listar($objUsuario);
    foreach ($arrUsuarios as $u) {
        $html .= '<tr>
                    <th scope="row">' . Pagina::formatar_html($u->getIdUsuario()) . '</th>
                    <td>' . Pagina::formatar_html($u->getCPF()) . '</td>
                    <td>' . Pagina::formatar_html(PerfilUsuarioRN::mostrarDescricaoTipoUsuario($u->getListaPerfis()[0])) . '</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_usuario')) {
            $html .= '   <td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_usuario&idUsuario=' . Pagina::formatar_html($u->getIdUsuario())) . '"><i class="fas fa-edit "></i></a></td>';
        }else{
            $html .= '   <td> - </td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_usuario')) {
            $html .= '   <td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_usuario&idUsuario=' . Pagina::formatar_html($u->getIdUsuario())) . '"><i class="fas fa-trash-alt"></i></a></td>';
        }else{
            $html .= '   <td> - </td>';
        }
        $html .= '</tr>';
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Usuários");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();
echo $alert;
echo '
     <div class="container-fluid">
    <h1 class="mt-4">Usuário</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_usuario').'">Cadastrar Usuário</a></li>
            <li class="breadcrumb-item active">Listar Usuário</li>
        </ol>
    </div>
    <div class="conteudo_listar">
        <div class="conteudo_tabela">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#ID</th>
                  <th scope="col">CPF</th>
                  <th scope="col">PERFIL</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                  
                </tr>
              </thead>
                 <tbody>'
                    . $html .
                 '</tbody>
            </table>
        </div>
    </div>';


Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();


