<?php

session_start();

require_once __DIR__.'/../classes/Pagina/Pagina.php';

require_once __DIR__.'/../classes/Sessao/Sessao.php';


/*
require_once __DIR__ . '/../classes/Usuario/Usuario.php';
require_once __DIR__ . '/../classes/Usuario/UsuarioRN.php';

/*
require_once __DIR__ . '/../classes/Recurso/Recurso.php';
require_once __DIR__ . '/../classes/Recurso/RecursoRN.php';

require_once __DIR__ . '/../classes/Prato/Prato.php';
require_once __DIR__ . '/../classes/Prato/PratoRN.php';

require_once __DIR__ . '/../classes/PerfilUsuario/PerfilUsuario.php';
require_once __DIR__ . '/../classes/PerfilUsuario/PerfilUsuarioRN.php';

require_once __DIR__ . '/../utils/Utils.php';
$objUtils = new Utils();

$objUsuario = new Usuario();
$objUsuarioRN = new UsuarioRN();

$objRecurso = new Recurso();
$objRecursoRN = new RecursoRN();

*/

/*$objUsuario->setSenha('123456');
$objUsuario->setCPF('86251791004');
$objUsuarioRN->logar($objUsuario);*/
/*
$objPrato = new Prato();
$objPratoRN = new PratoRN();
$objPrato->setIdPrato(2);
$objPrato->setPreco('30.9');
$objPrato->setNome('ffffff');
$objPrato->setIndexNome('Franffffffgo');
$objPrato->setCategoriaPrato('ffff');

//$arr  =$objPratoRN->listar($objPrato);
//print_r($arr);
$objPratoRN->alterar($objPrato);
*/
//var_dump($firebase);

//$fs = new Firestore('usuarios');
/*
$objUsuario = new Usuario();
$objUsuarioRN = new UsuarioRN();

$objUsuario->setIdUsuario(0);
$objUsuario->setNome('Carine');
$objUsuario->setCPF('86251791004');
$objUsuario->setSenha('123456');
$objUsuario  = $objUsuarioRN->alterar($objUsuario);
print_r($objUsuario);
die();
*/
/*
$objUsuario->setIdUsuario(0);
$objUsuario = $objUsuarioRN->consultar($objUsuario);

$objUsuario->setListaPerfis(array(0 => 0));
$objUsuario =  $objUsuarioRN->alterar($objUsuario);
print_r($objUsuario);*/
//$objUsuario
/*
$objRecurso = new Recurso();
$objRecursoRN = new RecursoRN();
$arr_ids =  $objRecursoRN->listar_ids($objRecurso);

$objPerfilUsuario = new PerfilUsuario();
$objPerfilUsuarioRN = new PerfilUsuarioRN();
$objPerfilUsuario->setIdPerfilUsuario(0);
$objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
$objPerfilUsuario->setListaRecursos($arr_ids);
$objPerfilUsuario = $objPerfilUsuarioRN->alterar($objPerfilUsuario);
print_r($objPerfilUsuario);
die();*/
/*


print_r($objRecurso);

die();
/*
$objUsuario->setIdUsuario(4);
//$objUsuarioRN->remover($objUsuario);

$objUsuario = $objUsuarioRN->consultar($objUsuario);


$arr_recursos = explode(",",$objUsuario->getListaRecursos());

$objRecurso->setLink('cadastrar_recurso');
$arr = $objRecursoRN->listar($objRecurso);
$arr_recursos[] = $arr[0]->getIdRecurso();


$objRecurso->setLink('editar_recurso');
$arr = $objRecursoRN->listar($objRecurso);
$arr_recursos[] = $arr[0]->getIdRecurso();


$objRecurso->setLink('listar_recurso');
$arr = $objRecursoRN->listar($objRecurso);
$arr_recursos[] = $arr[0]->getIdRecurso();

print_r($arr_recursos);

$objUsuario->setListaRecursos($arr_recursos);
$objUsuario = $objUsuarioRN->alterar($objUsuario);
print_r($objUsuario);

die();

//$arr_datas = array( "cpf" => '86251791004', 'senha' => '123456');
//print_r($arr_datas);

//$fs->getMultipleWhere($arr_datas);



//$fs = new Firestore('usuarios');
//$fs = new Firestore('usuarios');


//print_r($fs->getDocument('PV8Ge1yzuBftQaUnJDQA'));

//print_r($fs->getWhere('cpf','=','86251791004'));
//print_r($fs->newDocument(3,['cpf' => '11111111111','senha'=> '111111']));

//print_r($fs->newCollection('food', 'meet'));
//print_r($fs->dropDocument('meet'));

//print_r($fs->dropCollection('food'));

//$fs->newCollection('log','1');

//print_r($fs->list());

//print_r($fs->update('3',['cpf' => '21287690887','senha' => "111111"]));


*/



try {

    //Sessao::getInstance()->logar('86251791004', '123456');
    if (isset($_POST['btn_logar'], $_POST['txtCPF'], $_POST['txtSenha'])) {
        Sessao::getInstance()->logar($_POST['txtCPF'], $_POST['txtSenha']);
    }
}catch (Throwable $e){
    die($e);
}


    session_destroy();
    Pagina::abrir_head("Login - Tá Na Mesa");
    Pagina::getInstance()->adicionar_css("style_login");
    Pagina::fechar_head();
    Pagina::abrir_body();
    //Pagina::getInstance()->mostrar_excecoes();
    //Pagina::getInstance()->adicionar_javascript();



echo '<div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <i class="fas fa-user fa-4x icon_user"></i>
            <!--<i class="fas fa-utensils icon_user"></i>-->
            <!-- Login Form -->
            <form method="post">
                <input type="text" id="login" class="fadeIn second" name="txtCPF" placeholder="CPF">
                <input type="text" id="password" class="fadeIn third" name="txtSenha" placeholder="senha">
                <input type="submit" class="fadeIn fourth" value="Login" name="btn_logar">
            </form>

        </div>
    </div>';
   


    /*<main>
      <div class="form-box" style="margin-top: 10px;">
          <section class="section-default">
              <form method="POST">
              <h1 id="title-login">LOGIN</h1>
              <input type="text" name="txtCPF" id="idCPF" class="txtbox" placeholder="CPF"><br><br>
              <input type="password" name="txtSenha" class="txtbox" placeholder="Senha"><br><br>
              <button type="submit" name="btn_logar" class="btn">ENVIAR</button><br><br>
              </form>
          </section>
        </div>
    </main>*/

   // Pagina::getInstance()->fechar_corpo();
