<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try {
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Usuario/Usuario.php';
    require_once __DIR__.'/../../classes/Usuario/UsuarioRN.php';
    require_once __DIR__.'/../../utils/Utils.php';
    require_once __DIR__.'/../../utils/Alert.php';


    Sessao::getInstance()->validar();

    $utils = new Utils();
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    $alert = '';
    
    switch ($_GET['action']) {
        case 'cadastrar_usuario':
            if (isset($_POST['salvar_usuario'])) {
                $objUsuario->setCPF($_POST['txtCPF']);
                $objUsuario->setSenha($_POST['txtSenha']);
                $objUsuario = $objUsuarioRN->cadastrar($objUsuario);
                $alert = Alert::alert_success("O usuário -".$objUsuario->getCPF()."- foi <strong>cadastrado</strong> com sucesso");
            }
            break;

        case 'editar_usuario':
            if (!isset($_POST['salvar_usuario'])) { //enquanto não enviou o formulário com as alterações
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
            }

            if (isset($_POST['salvar_usuario'])) { //se enviou o formulário com as alterações
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario->setCPF($_POST['txtCPF']);
                $objUsuario->setSenha($_POST['txtSenha']);
                $objUsuario = $objUsuarioRN->alterar($objUsuario);
                $alert = Alert::alert_success("O usuário -".$objUsuario->getCPF()."- foi <strong>alterado</strong> com sucesso");

              
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_usuario.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Usuário");
Pagina::getInstance()->adicionar_javascript("usuario");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();


echo  $alert;
echo '
                <div class="container-fluid">
                    <h1 class="mt-4">Usuário</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Cadastrar Usuário</li>
                            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario').'">Listar Usuário</a></li>
                        </ol>
                    </div>
<div class="conteudo_grande">
    <form method="POST">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="label_matricula">Informe o CPF:</label>
                <input type="text" class="form-control" id="idCPF" placeholder="CPF" 
                       onblur="" name="txtCPF" required value="'. $objUsuario->getCPF() .'">
            </div>
            <div class="col-md-6 mb-3">
                <label for="label_senha">Digite a senha:</label>
                <input type="password" class="form-control" id="idSenha" placeholder="Senha" 
                       onblur="validaSenha()" name="txtSenha" required value="'. $objUsuario->getSenha() .'">
               
            </div>
        </div>  
        <button class="btn btn-primary" type="submit" name="salvar_usuario">Salvar</button>
    </form>
</div>';
Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();


