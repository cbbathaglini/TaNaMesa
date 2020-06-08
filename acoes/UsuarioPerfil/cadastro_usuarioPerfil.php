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
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuarioINT.php';

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
    PerfilUsuarioINT::montar_select_multiplos_perfis($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,$perfis_selecionados);

    if(isset($_POST['sel_usuario'])) {
        $objUsuario->setIdUsuario($_POST['sel_usuario']);
        $objUsuario = $objUsuarioRN->consultar($objUsuario);
        UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,null);
    }
    switch ($_GET['action']) {
       
        case 'cadastrar_usuario_perfilUsuario':
            if (isset($_POST['salvar_upr'])) {
                if (isset($_POST['sel_perfil'])) {

                    $objUsuario->setIdUsuario($_POST['sel_usuario']);
                    $objUsuario = $objUsuarioRN->consultar($objUsuario);

                    $arr_perfis = explode(",",$objUsuario->getListaPerfis());
                    if(empty($arr_perfis[0])){
                        $arr_perfis = array();
                    }

                    if (isset($_POST['sel_perfil'])) {
                        $i = 0;
                        for ($i = 0; $i < count($_POST['sel_perfil']); $i++) {
                            $perfis_selecionados .= $_POST['sel_perfil'][$i] . ";";
                            $arr_perfis[] = $_POST['sel_perfil'][$i];

                        }
                        $objUsuario->setListaPerfis($arr_perfis);

                        $objUsuario = $objUsuarioRN->alterar($objUsuario);
                        $alert = Alert::alert_success("Foi CADASTRADA a relação do usuário com o perfil");

                    }
                }

                UsuarioINT::montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,null,null);
                PerfilUsuarioINT::montar_select_multiplos_perfis($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,$perfis_selecionados);
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
                    <div class="col-md-4">
                        <label for="label_usuarios">Selecione o usuário:</label>'.
                        $select_usuario
                    .'</div>

                    <div class="col-md-8">
                        <label for="label_perfis">Selecione o perfil deste usuário:</label><br>'.
                        $select_perfilUsu
                    .'</div>
                </div>
                <button class="btn btn-primary" type="submit" name="salvar_upr">Salvar</button> 
            </form>
        </div>  
    </div>'; 


Pagina::getInstance()->fechar_corpo();
