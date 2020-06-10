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

    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuario.php';
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuarioRN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $alert = "";
    $select_usuario = '';
    $select_perfilUsu = '';
    $select_usuario_perfilUsu = '';
    $perfis_selecionados ='';


    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();

    /* PERFIL USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();


    UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,true);

    $arr_perfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);

    switch ($_GET['action']) {
       
        case 'cadastrar_usuario_perfilUsuario':
            if (isset($_POST['salvar_upr'])) {

                $objUsuario->setIdUsuario($_POST['sel_usuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);

                foreach ($arr_perfis as $perfil){
                    if(!is_null($_POST['id'.$perfil->getIdPerfilUsuario()])){
                        $arr[] = intval($_POST['id'.$perfil->getIdPerfilUsuario()]);
                    }
                }

                $arr = array_unique($arr);
                $objUsuario->setListaPerfis($arr);

                $objUsuario = $objUsuarioRN->alterar($objUsuario);
                $alert = Alert::alert_success("Foi CADASTRADA a relação do usuário com o perfil");

            }
            break;

        case 'editar_usuario_perfilUsuario':

           /* if (!isset($_POST['salvar_upr'])) { //enquanto não enviou o formulário com as alterações
               
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,null);

                
                $objRel_usuario_perfilUsuario->setIdUsuario($_GET['idUsuario']);
                $arr_rel = $objRel_usuario_perfilUsuario_RN->listar($objRel_usuario_perfilUsuario);
                
                foreach ($arr_rel as $relacionamento){
                    $perfis_selecionados .= $relacionamento->getIdPerfilUsuario()."; ";
                }

                PerfilUsuarioINT::montar_select_multiplos_perfis($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,$perfis_selecionados);

            }

            if (isset($_POST['salvar_upr'])) { //se enviou o formulário com as alterações
                if (isset($_POST['sel_perfil'])) {
                    
                    $perfis_selecionados_anteriormente = array();
                    $objUsuario->setIdUsuario($_GET['idUsuario']);
                    $objUsuario = $objUsuarioRN->consultar($objUsuario);
                    
                    $objRel_usuario_perfilUsuario->setIdUsuario($_GET['idUsuario']);
                    $arr_rel = $objRel_usuario_perfilUsuario_RN->listar($objRel_usuario_perfilUsuario);
                
                    foreach ($arr_rel as $relacionamento){
                         $perfis_selecionados_anteriormente[]= $relacionamento->getIdPerfilUsuario();
                    }
                    
                    $result = array_diff($perfis_selecionados_anteriormente, $_POST['sel_perfil']);
                                    
                    foreach ($result as $r) {
                        $objRel_usuario_perfilUsuario->setIdPerfilUsuario($r);
                        $objRel_usuario_perfilUsuario->setIdUsuario($_GET['idUsuario']);
                        $objRel_usuario_perfilUsuario_RN->remover($objRel_usuario_perfilUsuario);
                    }
                    
                    $perfis_selecionados = '';
                    for ($i = 0; $i < count($_POST['sel_perfil']); $i++) {
                        $objRel_usuario_perfilUsuario->setIdPerfilUsuario($_POST['sel_perfil'][$i]);
                        $objRel_usuario_perfilUsuario->setIdUsuario($_GET['idUsuario']);
                        
                        $arrUP = $objRel_usuario_perfilUsuario_RN->validar_cadastro($objRel_usuario_perfilUsuario);
                        if (empty($arrUP)) {
                            $objRel_usuario_perfilUsuario_RN->cadastrar($objRel_usuario_perfilUsuario);
                            $alert .= Alert::alert_success("Foi ALTERADA a relação do usuário com o perfil");
                        } else {
                            $alert .= Alert::alert_danger("Não foi ALTERADA a relação do usuário com o perfil");  
                        }
                        $perfis_selecionados .= $_POST['sel_perfil'][$i] . ";";
                    }
                
                }

                UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,null);
                PerfilUsuarioINT::montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,$perfis_selecionados);

            }*/


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_usuario_perfilUsuario.php');
    }

    UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,null);
    $cont = 0;
    $checks ='<div class="form-row">';
    foreach ($arr_perfis as $perfil){
             $checked = '';
            if (!is_null($_POST['id' . $perfil->getIdPerfilUsuario()])) {
                $checked = ' checked ';
            }

            /**if(in_array($recurso->getIdRecurso(),$objPerfilUsuario->getListaRecursos())){
             * $checked = ' checked ';
             * }**/

            $checks .= '
                    <div class="col-3">
                        <div class="form-check">
                          <input class="form-check-input" ' . $checked . ' type="checkbox" name="id' . $perfil->getIdPerfilUsuario() . '" value="' . $perfil->getIdPerfilUsuario() . '" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">' .
                PerfilUsuarioRN::mostrarDescricaoTipoUsuario($perfil->getIndex_perfil())
                . '</label>
                       </div>
                    </div>
                ';
            $cont++;
            if ($cont == 4) {
                $cont = 0;
                $checks .= '</div>';
                $checks .= '<div class="form-row">';
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
    <h1 class="mt-4">Usuário + Perfil Usuário</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_usuario_perfilUsuario').'">Cadastrar Usuário + Perfil Usuário</a></li>
            <li class="breadcrumb-item active">Listar Usuário + Perfil Usuário</li>
        </ol>
    </div>
<div class="conteudo_grande"   style="margin-top: -40px;">
        <div class="formulario">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="label_usuarios">Selecione o usuário:</label>'.
                        $select_usuario
                    .'</div>
                </div>
                '.$checks.'

                <button class="btn btn-primary" type="submit" name="salvar_upr">Salvar</button> 
            </form>
        </div>  
    </div>';

Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();