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
Pagina::getInstance()->adicionar_css("precadastros");
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
            if(Sessao::getInstance()->verificar_permissao('cadastrar_usuario_recurso')) {
                echo '<div class="col-md-6">
                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_usuario_recurso') . '">CADASTRAR USUÁRIO+RECURSO</a>          
                      </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_usuario_recurso')) {
                    echo '  <div class="col-md-6">
                                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario_recurso') . '">LISTAR USUÁRIO+RECURSO</a>          
                            </div>';
                }
echo'        </div>';

echo'       <div class="row">';
                if(Sessao::getInstance()->verificar_permissao('gerar_QRCode')) {
                    echo '<div class="col-md-12">
                                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=gerar_QRCode') . '">GERAR QRCode</a>          
                                      </div>';
                }
echo'        </div>';

echo'       <div class="row">';
if(Sessao::getInstance()->verificar_permissao('cadastrar_ingrediente')) {
        echo '<div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_ingrediente') . '">CADASTRAR INGREDIENTE</a>          
              </div>';
}
if(Sessao::getInstance()->verificar_permissao('listar_ingrediente')) {
        echo '  <div class="col-md-6">
                     <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_ingrediente') . '">LISTAR INGREDIENTE</a>          
                </div>';
}
echo'        </div>';

echo'       <div class="row">';
        if(Sessao::getInstance()->verificar_permissao('cadastrar_prato')) {
            echo '<div class="col-md-6">
                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_prato') . '">CADASTRAR PRATO</a>          
                      </div>';
        }
        if(Sessao::getInstance()->verificar_permissao('listar_prato')) {
            echo '  <div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_prato') . '">LISTAR PRATO</a>          
                        </div>';
        }
echo'        </div>';


echo'    </div>';

Pagina::fechar_body();


