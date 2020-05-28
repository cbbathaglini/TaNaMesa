<?php 
session_start();
require_once __DIR__.'/../classes/Pagina/Pagina.php';
require_once __DIR__.'/../classes/Sessao/Sessao.php';

try {
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
    Pagina::getInstance()->mostrar_excecoes();
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

    Pagina::getInstance()->fechar_corpo();
