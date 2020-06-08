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
    require_once __DIR__ . '/../../classes/Usuario/UsuarioINT.php';

    require_once __DIR__ . '/../../classes/Recurso/Recurso.php';
    require_once __DIR__ . '/../../classes/Recurso/RecursoRN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $alert = "";
    $select_usuario = '';
    $perfis_selecionados ='';


    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();

    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();

    if($_GET['action'] == 'editar_usuario_recurso'){
        $objUsuario->setIdUsuario($_GET['idUsuario']);
        $objUsuario = $objUsuarioRN->consultar($objUsuario);

        $str_recursos_usuario = $objUsuario->getListaRecursos();

        if(strlen($str_recursos_usuario)>0){
            $arr_recursos_usuario = explode(",",$str_recursos_usuario);
        }
    }


    UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,true);
    $arr_recursos = $objRecursoRN->listar($objRecurso);






    switch ($_GET['action']) {
       
        case 'cadastrar_usuario_recurso':

            $cont = 0;
            $checks ='<div class="form-row">';
            foreach ($arr_recursos as $recurso){
                $checked ='';
                if(!is_null($_POST['id'.$recurso->getIdRecurso()])){
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

            if (isset($_POST['salvar_upr'])) {

                    $objUsuario->setIdUsuario($_POST['sel_usuario']);
                    $objUsuario = $objUsuarioRN->consultar($objUsuario);
                    $str_recursos_usuario = $objUsuario->getListaRecursos();

                    if(strlen($str_recursos_usuario)>0){
                        $arr_recursos_usuario = explode(",",$str_recursos_usuario);
                    }

                    foreach ($arr_recursos as $recurso){
                        if(!is_null($_POST['id'.$recurso->getIdRecurso()])){
                            $arr_recursos_usuario[] = $_POST['id'.$recurso->getIdRecurso()];
                        }
                    }

                    $objUsuario->setListaRecursos($arr_recursos_usuario);

                    $objUsuario = $objUsuarioRN->alterar($objUsuario);
                    $alert = Alert::alert_success("Foi CADASTRADA a relação do usuário com o perfil");


                UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,null);
            }
            break;

        case 'editar_usuario_recurso':

            $objUsuario->setIdUsuario($_GET['idUsuario']);
            $objUsuario = $objUsuarioRN->consultar($objUsuario);
            $str_recursos_usuario = $objUsuario->getListaRecursos();
            $arr_recursos_usuario = explode(",",$str_recursos_usuario);
            UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,null);

            $cont = 0;
            $checks ='<div class="form-row">';
            foreach ($arr_recursos as $recurso){
                $checked ='';
                if(!is_null($_POST['id'.$recurso->getIdRecurso()])){
                    $checked = ' checked ';
                }

                if(in_array($recurso->getIdRecurso(),$arr_recursos_usuario)){
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

            if (isset($_POST['salvar_upr'])) {
                $str_recursos_usuario = $objUsuario->getListaRecursos();

                if (strlen($str_recursos_usuario) > 0) {
                    $arr_recursos_usuario = explode(",", $str_recursos_usuario);
                }

                foreach ($arr_recursos as $recurso) {
                    if (!is_null($_POST['id' . $recurso->getIdRecurso()])) {
                        $arr_recursos_usuario[] = $_POST['id' . $recurso->getIdRecurso()];
                    }
                }

                $objUsuario->setListaRecursos($arr_recursos_usuario);

                $objUsuario = $objUsuarioRN->alterar($objUsuario);
                $alert = Alert::alert_success("Foi ALTERADA a relação do usuário com o perfil");
            }

            UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,null);


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_usuario_perfilUsuario.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar relacionamento usuário com seus perfis");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
//Pagina::montar_topo_listar('CADASTRAR RELACIONAMENTO DO USUÁRIO COM O SEU PERFIL',null,null, 'listar_usuario_perfilUsuario', 'USUÁRIO + PERFIL');
Pagina::getInstance()->mostrar_excecoes();
echo $alert.
    '<div class="conteudo_grande"   style="margin-top: -40px;">
        <div class="formulario">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="label_usuarios">Selecione o usuário:</label>'.
                        $select_usuario
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


Pagina::getInstance()->fechar_corpo();
