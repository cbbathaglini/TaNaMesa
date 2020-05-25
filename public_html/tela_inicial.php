<?php
//session_start();
//require_once '../classes/Sessao/Sessao.php';

   require_once __DIR__ . '/../classes/Pagina/Pagina.php';


    //require_once __DIR__.'/../classes/Usuario/Usuario.php';
    //require_once __DIR__.'/../classes/Usuario/UsuarioRN.php';


//Sessao::getInstance()->validar();

//$objUsuario = new Usuario();
//$objUsuarioRN = new UsuarioRN();
//$objUsuario->setIdUsuario(Sessao::getInstance()->getIdUsuario());
//$objUsuario = $objUsuarioRN->consultar($objUsuario);

Pagina::abrir_head("TÁ NA MESA");
//Pagina::getInstance()->adicionar_css();
Pagina::fechar_head();

Pagina::abrir_body();


echo
    '<div class="conjunto_itens">
        <div class="row">
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=cadastrar_mesa">CADASTRO MESA</a>          
            </div>
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=listar_mesa">LISTAR MESA</a>          
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=cadastrar_perfil_usuario">CADASTRAR PERFIL USUÁRIO</a>          
            </div>
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=listar_perfil_usuario">LISTAR PERFIL USUÁRIO</a>          
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=cadastrar_recurso">CADASTRAR RECURSO</a>          
            </div>
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=listar_recurso">LISTAR RECURSO</a>          
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=cadastrar_usuario">CADASTRAR USUÁRIO</a>          
            </div>
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=listar_usuario">LISTAR USUÁRIO</a>          
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=cadastrar_usuario_perfilUsuario">CADASTRAR USUÁRIO+PERFIL</a>          
            </div>
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=listar_usuario_perfilUsuario">LISTAR USUÁRIO+PERFIL</a>          
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=cadastrar_perfilUsuario_recurso">CADASTRAR PERFIL USUÁRIO+RECURSO</a>          
            </div>
            <div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="controlador.php?action=listar_perfilUsuario_recurso">LISTAR PERFIL USUÁRIO+RECURSO</a>          
            </div>
        </div>
    </div>';

Pagina::fechar_body();


