<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try {
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


    /* PERFIL USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();

    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();


    $arr_recursos = $objRecursoRN->listar($objRecurso);
    switch ($_GET['action']) {
        case 'cadastrar_perfilUsuario_recurso':
            PerfilUsuarioINT::montar_select_perfil($select_perfil,$objPerfilUsuarioRN, $objPerfilUsuario,null, null);
            if (isset($_POST['salvar_upr'])) {

                    $objPerfilUsuario->setIdPerfilUsuario($_POST['sel_perfil']);
                    $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
                    $arr = $objPerfilUsuario->getListaRecursos();

                    foreach ($arr_recursos as $recurso){
                        if(!is_null($_POST['id'.$recurso->getIdRecurso()])){
                            $arr[] = intval($_POST['id'.$recurso->getIdRecurso()]);
                        }
                    }

                    $arr = array_unique($arr);

                    $objPerfilUsuario->setListaRecursos($arr);

                    $objPerfilUsuario = $objPerfilUsuarioRN->alterar($objPerfilUsuario);
                    $alert = Alert::alert_success("Foi CADASTRADA a relação do usuário com o perfil");

                PerfilUsuarioINT::montar_select_perfil($select_perfil,$objPerfilUsuarioRN, $objPerfilUsuario,null, null);
            }
            break;

        case 'editar_perfilUsuario_recurso':

            $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
            $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
            PerfilUsuarioINT::montar_select_perfil($select_perfil,$objPerfilUsuarioRN, $objPerfilUsuario,null, null);


            if (isset($_POST['salvar_upr'])) {
                $arr = $objPerfilUsuario->getListaRecursos();

                foreach ($arr_recursos as $recurso){
                    if(!is_null($_POST['id'.$recurso->getIdRecurso()])){
                        $arr[] = intval($_POST['id'.$recurso->getIdRecurso()]);
                    }
                }

                $arr = array_unique($arr);

                $objPerfilUsuario->setListaRecursos($arr);

                $objPerfilUsuario = $objPerfilUsuarioRN->alterar($objPerfilUsuario);
                $alert = Alert::alert_success("Foi ALTERADA a relação do usuário com o perfil");
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_usuario_perfilUsuario.php');
    }

    PerfilUsuarioINT::montar_select_perfil($select_perfil,$objPerfilUsuarioRN, $objPerfilUsuario,null, null);
    $cont = 0;
    $checks ='<div class="form-row">';
    foreach ($arr_recursos as $recurso){
        $checked ='';
        if(!is_null($_POST['id'.$recurso->getIdRecurso()])){
            $checked = ' checked ';
        }

        if(in_array($recurso->getIdRecurso(),$objPerfilUsuario->getListaRecursos())){
            $checked = ' checked ';
        }

        $checks .='
                    <div class="col-3">
                        <div class="form-check">
                          <input class="form-check-input" '.$checked.' type="checkbox" name="id'.$recurso->getIdRecurso().'" value="'.$recurso->getIdRecurso().'" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">'.
            $recurso->getNome()
            .'</label>
                       </div>
                    </div>
                ';
        $cont++;
        if($cont == 4){
            $cont = 0;
            $checks .= '</div>';
            $checks .='<div class="form-row">';
        }

    }
    $checks .= '</div>';

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar relacionamento usuário com seus perfis");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();
echo $alert.
    '
      <div class="container-fluid">
    <h1 class="mt-4">Perfil Usuário + Recurso</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>';
    if(Sessao::getInstance()->verificar_permissao('cadastrar_perfilUsuario_recurso')) {
        echo '    <li class="breadcrumb-item"><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_perfilUsuario_recurso') . '">Cadastrar Perfil Usuário + Recurso</a></li>';
    }
        echo '    <li class="breadcrumb-item active">Listar Perfil Usuário + Recurso</li>';
   echo '     </ol>
    </div>
        <div class="conteudo_grande"   style="margin-top: -40px;">
        <div class="formulario">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="label_usuarios">Selecione o perfil do usuário:</label>'.
                            $select_perfil
                    .'</div>
                </div>
                '.$checks.'
                <div class="form-row">
                     <div class="col-md-12">
                        <button class="btn btn-primary" type="submit" name="salvar_upr">Salvar</button> 
                    </div>
                </div>
            </form>
        </div>  
    </div>';


Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();