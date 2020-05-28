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
    require_once __DIR__ . '/../../classes/Recurso/RecursoINT.php';

    require_once __DIR__ . '/../../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
    require_once __DIR__ . '/../../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $alert = "";
    $select_perfilUsu = '';
    $select_recurso = '';
    $select_perfilUsu_recurso = '';
    $recursos_selecionados = '';
    $disabled = '';

    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();

    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();

    /* PERFIL USUÁRIO + RECURSO */
    $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
    $objRel_perfilUsuario_recurso_RN = new Rel_perfilUsuario_recurso_RN();

    PerfilUsuarioINT::montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,null,null);
    RecursoINT::montar_select_multiplo_recurso($select_recurso, $objRecursoRN, $objRecurso, $recursos_selecionados);

    switch ($_GET['action']) {
        case 'cadastrar_perfilUsuario_recurso':

            if (isset($_POST['salvar_upr'])) {

                if (isset($_POST['sel_perfil'])) {
                    $objPerfilUsuario->setIdPerfilUsuario($_POST['sel_perfil']);
                    $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);

                    if (isset($_POST['sel_recursos'])) {
                        $i = 0;
                        for ($i = 0; $i < count($_POST['sel_recursos']); $i++) {
                            $recursos_selecionados .= $_POST['sel_recursos'][$i] . ";";
                            $objRel_perfilUsuario_recurso->setIdPerfilUsuario($objPerfilUsuario->getIdPerfilUsuario());
                            $objRel_perfilUsuario_recurso->setIdRecurso($_POST['sel_recursos'][$i]);
                            $objRel_perfilUsuario_recurso = $objRel_perfilUsuario_recurso_RN->cadastrar($objRel_perfilUsuario_recurso);
                        }
                        $alert .= Alert::alert_success("Relacionamento <strong>cadastrado</strong> com sucesso");
                    }
                    PerfilUsuarioINT::montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,null,null);
                    RecursoINT::montar_select_multiplo_recurso($select_recurso, $objRecursoRN, $objRecurso, $recursos_selecionados);
                }
            }
            break;

        case 'editar_perfilUsuario_recurso':

            $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
            $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
            PerfilUsuarioINT::montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,null,null);

            die();

            $recursos_selecionados = $_GET['idRecurso'];
            RecursoINT::montar_select_multiplo_recurso($select_recurso, $objRecursoRN, $objRecurso, $recursos_selecionados);


            if (isset($_POST['salvar_upr'])) { //se enviou o formulário com as alterações
                $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
                $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);


                $arr_pr = $objRel_perfilUsuario_recurso_RN->listar($objRel_perfilUsuario_recurso);
                if (isset($_POST['sel_recursos'])) {
                    $i = 0;

                    $recursos_selecionados_anterirormente = explode(";", $_GET['idRecurso']);
                    $result = array_diff($recursos_selecionados_anterirormente, $_POST['sel_recursos']);
                    //print_r($result);
                    foreach ($result as $r) {
                        $objRel_perfilUsuario_recurso->setIdPerfilUsuario($_GET['idPerfilUsuario']);
                        $objRel_perfilUsuario_recurso->setIdRecurso($r);
                        $objRel_perfilUsuario_recurso_RN->remover($objRel_perfilUsuario_recurso);
                    }

                    $recursos_selecionados = '';
                    for ($i = 0; $i < count($_POST['sel_recursos']); $i++) {
                        //echo $_POST['sel_perfis'][$i];
                        //print_r($_POST['sel_recursos']);

                        $objRel_perfilUsuario_recurso->setIdPerfilUsuario($objPerfilUsuario->getIdPerfilUsuario());
                        $objRel_perfilUsuario_recurso->setIdRecurso($_POST['sel_recursos'][$i]);
                        $objRel_perfilUsuario_recurso_RN->cadastrar($objRel_perfilUsuario_recurso);
                        $alert = Alert::alert_success("O relacionamento perfil usuário e seu recurso foi cadastrado");
                        $recursos_selecionados .= $_POST['sel_recursos'][$i] . ";";
                    }

                    montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario);
                    montar_select_recurso($select_recurso, $objRecursoRN, $objRecurso, $recursos_selecionados);
                }
            }
            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_perfilUsuario_recurso.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::getInstance()->abrir_head("Cadastrar relacionamento dos perfis de usuário com os seus recursos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();

    echo $alert.
        '<div class="conteudo_grande">
            <div class="formulario">
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="label_perfis">Selecione o perfil deste usuário:</label><br>'.
                            $select_perfilUsu
                        .'</div>

                        <div class="col-md-8">
                            <label for="label_recursos">Selecione os recursos deste usuário:</label><br>'.
                            $select_recurso
                        .'</div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="salvar_upr">Salvar</button> 
                </form>
            </div>  
        </div> '; 
        

Pagina::getInstance()->fechar_corpo();
