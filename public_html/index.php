<?php 
session_start();
require_once __DIR__.'/../classes/Pagina/Pagina.php';
require_once __DIR__.'/../classes/Sessao/Sessao.php';
try {
//Sessao::getInstance()->logar('00274715','12345678');
    if (isset($_POST['btn_logar'], $_POST['txtCPF'], $_POST['txtSenha'])) {
        Sessao::getInstance()->logar($_POST['txtCPF'], $_POST['txtSenha']);
    }
}catch (Throwable $e){
    die($e);
}

session_destroy();
?>

<?php

    Pagina::abrir_head("Login");
    Pagina::getInstance()->adicionar_css("style");
    //Pagina::getInstance()->adicionar_javascript();

    ?>
    <img src="img/header.png" class="HeaderImg">
    </head>
    <BODY>
   


    <main>
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
    </main>

<?php
    Pagina::getInstance()->mostrar_excecoes();
    Pagina::getInstance()->fechar_corpo();
