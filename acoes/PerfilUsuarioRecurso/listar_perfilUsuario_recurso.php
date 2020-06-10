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
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuarioINT.php';

    require_once __DIR__ . '/../../classes/Recurso/Recurso.php';
    require_once __DIR__ . '/../../classes/Recurso/RecursoRN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $alert = "";
    $select_perfil = '';
    $alert = '';


    /* PERFIL USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();

    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();

    $arrPerfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    //print_r($arrUsuarios);

    foreach ($arrPerfis as $perfil){

        foreach ($perfil->getListaRecursos() as $recurso){
            $objRecurso->setIdRecurso($recurso);
            $objRecurso = $objRecursoRN->consultar($objRecurso);
            $strRecursos .= $objRecurso->getNome().",";
        }
        if($strRecursos == ''){
            $strRecursos = ' - ';
        }
        $strRecursos = substr($strRecursos,0,-1);

        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($perfil->getPerfil()).'</th>';
        $html .=    '<td>'.Pagina::formatar_html($strRecursos).'</td>';


        if(Sessao::getInstance()->verificar_permissao('editar_perfilUsuario_recurso')) {
            $html .= '  <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_perfilUsuario_recurso&idPerfilUsuario=' . $perfil->getIdPerfilUsuario()) . '"><i class="fas fa-edit "></i></a></td>';
        }
        if(Sessao::getInstance()->verificar_permissao('remover_perfilUsuario_recurso')) {
            $html .= '  <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_perfilUsuario_recurso&idPerfilUsuario=' . $perfil->getIdPerfilUsuario()) . '"><i class="fas fa-trash-alt"></a></td>';
        }
        $html .= ' </tr>';
    }
    
       
} catch (Throwable $ex) {
     Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar ");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();
echo $alert;
echo '

  <div class="container-fluid">
    <h1 class="mt-4">Perfil Usuário + Recurso</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>
            <li class="breadcrumb-item active">Cadastrar Perfil Usuário + Recurso</a></li>
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_perfilUsuario_recurso').'">Listar Perfil Usuário + Recurso</li>
        </ol>
    </div>
    <div class="conteudo_grande">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">USUÁRIO</th>
                        <th scope="col">PERFIL</th>';
if(Sessao::getInstance()->verificar_permissao('editar_perfilUsuario_recurso')) {echo '<th scope="col"></th>';}
if(Sessao::getInstance()->verificar_permissao('remover_perfilUsuario_recurso')) {echo '<th scope="col"></th>';}
                   
echo '              </tr>
                </thead>
                <tbody>'
                    .$html.
                '</tbody>
            </table>
    </div>';


Pagina::getInstance()->fechar_corpo();
