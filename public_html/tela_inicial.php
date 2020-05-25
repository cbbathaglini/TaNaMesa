<?php
session_start();
    require_once '../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../classes/Usuario/Usuario.php';
    require_once __DIR__.'/../classes/Usuario/UsuarioRN.php';


Sessao::getInstance()->validar();

$objUsuario = new Usuario();
$objUsuarioRN = new UsuarioRN();
$objUsuario->setIdUsuario(Sessao::getInstance()->getCPF());
$objUsuario = $objUsuarioRN->consultar($objUsuario);

Pagina::abrir_head("TÁ NA MESA");
Pagina::getInstance()->montar_menu_topo();
//Pagina::getInstance()->adicionar_css();
Pagina::fechar_head();

Pagina::abrir_body();


echo
    '<div class="conjunto_itens">
        <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_mesa')) {
                echo '   <div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_mesa').'">CADASTRO MESA</a>          
                        </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_mesa')) {
                echo '<div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_mesa').'">LISTAR MESA</a>          
                        </div>';
            }
    echo'</div>';

echo'    <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_perfil_usuario')) {
                echo '       <div class="col-md-6">
                                <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_perfil_usuario').'">CADASTRAR PERFIL USUÁRIO</a>          
                            </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_perfil_usuario')) {
                echo '       <div class="col-md-6">
                            <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_perfil_usuario') . '">LISTAR PERFIL USUÁRIO</a>          
                        </div>';
            }
echo'</div>';

echo'        <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_recurso')) {
                echo '            <div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_recurso') . '">CADASTRAR RECURSO</a>          
                        </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_recurso')) {
                echo '            <div class="col-md-6">
                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_recurso') . '">LISTAR RECURSO</a>          
                    </div>';
            }
echo'        </div>';

echo'         <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_usuario')) {
                echo '             <div class="col-md-6">
                     <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_usuario') . '">CADASTRAR USUÁRIO</a>          
                </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_usuario')) {
                echo '<div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario') . '">LISTAR USUÁRIO</a>          
                        </div>';
            }
echo'         </div>';
        
echo'         <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_usuario_perfilUsuario')) {
                echo '<div class="col-md-6">
                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_usuario_perfilUsuario') . '">CADASTRAR USUÁRIO+PERFIL</a>          
                        </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_usuario_perfilUsuario')) {
                echo ' <div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario_perfilUsuario') . '">LISTAR USUÁRIO+PERFIL</a>          
                        </div>';
            }
echo' </div>';

echo'       <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_perfilUsuario_recurso')) {
                echo '<div class="col-md-6">
                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_perfilUsuario_recurso') . '">CADASTRAR PERFIL USUÁRIO+RECURSO</a>          
                      </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_perfilUsuario_recurso')) {
                    echo '  <div class="col-md-6">
                                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_perfilUsuario_recurso') . '">LISTAR PERFIL USUÁRIO+RECURSO</a>          
                            </div>';
                }
echo'        </div>';
echo'    </div>';

Pagina::fechar_body();


