<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Sessao/Sessao.php';
require_once __DIR__ . '/../Banco/Configuracao.php';
require_once __DIR__ . '/../Log/Log.php';
require_once __DIR__ . '/../Log/LogRN.php';
require_once __DIR__ .'/../../utils/Alert.php';

class Pagina {

    private $array_validacoes;
    private static $instance;
    
    public static  function getInstance(){
        if(self::$instance == null){
            self::$instance= new Pagina();
        }
        return self::$instance;
    }
    
    function __construct() {
        $this->array_validacoes = array();
    }

    
    
    public function adicionar_javascript($strArquivo){
        $strVersao ='';
        if(Configuracao::getInstance()->getValor('producao')){
            $strVersao =Configuracao::getInstance()->getValor('versao');
        }else{
           $strVersao = rand(); 
        }
        
        echo '<script type="text/javascript" src="js/'.$strArquivo.'.js?'.$strVersao.'"></script>';
    }
    
    public function adicionar_css($strArquivo){
        $strVersao ='';
        try {
            if (Configuracao::getInstance()->getValor('producao')) {
                $strVersao = Configuracao::getInstance()->getValor('versao');
            } else {
                $strVersao = rand();
            }

            echo '<link rel="stylesheet" type="text/css" href="css/' . $strArquivo . '.css?' . $strVersao . '">';
        }catch (Throwable $e){
            die($e);
        }
    }
    
    public function processar_excecao($e) {
        if ($e instanceof Excecao && $e->possui_validacoes()) {
            $this->array_validacoes = $e->get_validacoes();
        } else {

            try {
                
                $log = new Log();
                $log->setIdUsuario(Sessao::getInstance()->getIdUsuario());
                $log->setTexto($e->__toString()."\n".$e->getTraceAsString());
                date_default_timezone_set('America/Sao_Paulo');
                $log->setDataHora(date("Y-m-d H:i:s"));
                //print_r($log);
                $logRN = new LogRN();
                $logRN->cadastrar($log);
                //die("aqui");
                
            } catch (Throwable $ex) {      
            }
            die($e);
            header('Location: controlador.php?action=erro');
            //die('pagina->processarexcecao ' . $e);
        }
    }


    public static function abrir_head($titulo) {
        echo '<html>
                    <head>
                        <meta charset="utf-8">
                        <title>' . $titulo . '</title>
                        <!-- google fonts -->
                        <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">
                        <meta charset="utf-8" />
                        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
                 
                        <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
                        <script src="js/all.min.js" crossorigin="anonymous"></script>
                       
                                                  
                        <link rel="icon" type="text/css" href="##">
                        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


                        <script src="js/jquery.min.js"></script>
                        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
                        <!-- Font Awesome --><!-- NÃO REMOVER SENÃO NÃO APARECEM OS ÍCONES -->
                        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

                        <link rel="stylesheet" href="css/styles.css">
                         <link rel="stylesheet" href="css/precadastros.css">

                       
                        <!--<script src="css/bootstrap-combined.min.css"></script>-->
                        
                        <!-- HTML5Shiv -->
                        <!--[if lt IE 9]>
                          <script src="js/html5shiv.min.js"></script>

                        <link rel="stylesheet" href="css/fontawesome.css">
                        <![endif]-->

                        <!-- Bootstrap CSS -->
                        <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->

                        <!--<script src="js/jquery-3.3.1.slim.min.js"></script>-->
                       
                        <script src="js/popper.min.js"></script>
                        <script src="js/bootstrap.min.js"></script>
                        
                        
                        <!-- Bootstrap CSS -->
                        <link rel="stylesheet" href="css/bootstrap.min.css">

                        <!-- Latest compiled and minified CSS -->
                        <link rel="stylesheet" href="css/bootstrap-select.min.css">

                        <!-- Latest compiled and minified JavaScript -->
                        <script src="js/bootstrap-select.min.js"></script>

                        <!-- Latest compiled and minified JavaScript -->
                        <script src="js/datetime-copy-paste.js"></script>


                        <!-- Estilo customizado -->
                        <!--<link rel="stylesheet" type="text/css" href="css/style.css">-->
                        
                        <style>
                        
                       
                        
                        /* Barra de rolagem */
                        /*::-webkit-scrollbar {width:9px;height:auto;background: #fff;border-bottom:none;}
                        ::-webkit-scrollbar-button:vertical {height:2px;display:block;} 
                        ::-webkit-scrollbar-thumb:vertical {background-color: #56baed; -webkit-border-radius: 1px;}
                        ::-webkit-scrollbar-button:horizontal {height:2px;display:block;}
                        ::-webkit-scrollbar-thumb:horizontal {background-color: #56baed; -webkit-border-radius: 1px;}*/
                         
                        .fas{
                            color:#56baed;
                        }
                        .btn-primary{
                            background-color:#56baed;
                            border:none;
                        }
                        
                        .btn-primary:hover{
                            background-color:#DBDFE2;
                            color: #56baed;
                            transition: .5s;
                        }
                        
                        .btn-secondary{
                            background: none;
                            border-radius: 0px;
                            border: none;
                            color:#56baed;
                        }
                        
                        .btn-secondary:hover,.btn-secondary:active{
                            border-bottom: 1px solid #56baed;
                            background: none;
                            color:#56baed;
                            /*color: white;
                            background-color:#56baed;*/
                        }

                        
                       
                        html,body{
                                height: 100%;
                                
                                overflow-x: hidden; 
                                /*white-space: nowrap;*/
                        
                        }

                        /*body{
                                background: 
                                            linear-gradient(50deg,#dcdcdc, #fff);
                                background-attachment: fixed; 
                                font-family: Helvetica,Arial, sans-serif;
                        }*/
                         .divisor{
                                width: 1px;
                                margin: 12px 15px;
                                background: #56baed;
                        }  

                        </style>
                                                
                        
                        ';
    }

    public static function abrir_lateral() {
        echo ' <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Início</div>
                            <a class="nav-link" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Tela Inicial </a
                            >';
             if($_SESSION['TANAMESA']['PERFIL'] == PerfilUsuarioRN::$PU_ADMINISTRADOR) {
                 echo '   <div class="sb-sidenav-menu-heading">'.PerfilUsuarioRN::mostrarDescricaoTipoUsuario(PerfilUsuarioRN::$PU_ADMINISTRADOR).'</div>';
             }else if($_SESSION['TANAMESA']['PERFIL'] == PerfilUsuarioRN::$PU_GARCOM) {
                 echo '   <div class="sb-sidenav-menu-heading">'.PerfilUsuarioRN::mostrarDescricaoTipoUsuario(PerfilUsuarioRN::$PU_GARCOM).'</div>';
             }else if($_SESSION['TANAMESA']['PERFIL'] == PerfilUsuarioRN::$PU_GERENTE) {
                 echo '   <div class="sb-sidenav-menu-heading">'.PerfilUsuarioRN::mostrarDescricaoTipoUsuario(PerfilUsuarioRN::$PU_GERENTE).'</div>';
             }

        if(Sessao::getInstance()->verificar_permissao('cadastrar_usuario') || Sessao::getInstance()->verificar_permissao('listar_usuario')) {
            echo '       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
                                ><div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Usuário
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>';

            echo ' <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                                <nav class="sb-sidenav-menu-nested nav">';
            if (Sessao::getInstance()->verificar_permissao('cadastrar_usuario')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_usuario') . '"> Cadastrar Usuário</a>';
            }
            if (Sessao::getInstance()->verificar_permissao('listar_usuario')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario') . '">Listar Usuários</a>';
            }

            echo '
                                            </nav>  
                                        </div>';
        }

        if(Sessao::getInstance()->verificar_permissao('cadastrar_mesa') || Sessao::getInstance()->verificar_permissao('listar_mesa')) {
            echo '  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts1" >
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                        Mesa
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>';

            echo ' <div class="collapse" id="collapseLayouts1" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                                <nav class="sb-sidenav-menu-nested nav">';
            if (Sessao::getInstance()->verificar_permissao('cadastrar_mesa')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_mesa') . '"> Cadastrar Mesa</a>';
            }
            if (Sessao::getInstance()->verificar_permissao('listar_mesa')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_mesa') . '">Listar Mesas</a>';
            }

            echo '
                                            </nav>  
                                        </div>';
        }


        if(Sessao::getInstance()->verificar_permissao('cadastrar_perfil_usuario') || Sessao::getInstance()->verificar_permissao('listar_perfil_usuario')) {
            echo '  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts3" >
                                <div class="sb-nav-link-icon"><i class="fas fa-female"></i><i class="fas fa-male"></i></div>
                                        Perfil Usuário
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>';

            echo ' <div class="collapse" id="collapseLayouts3" aria-labelledby="heading3" data-parent="#sidenavAccordion">
                                                <nav class="sb-sidenav-menu-nested nav">';
            if (Sessao::getInstance()->verificar_permissao('cadastrar_perfil_usuario')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_perfil_usuario') . '"> Cadastrar Perfil Usuário</a>';
            }
            if (Sessao::getInstance()->verificar_permissao('listar_perfil_usuario')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_perfil_usuario') . '">Listar Perfil Usuário</a>';
            }

            echo '
                                            </nav>  
                                        </div>';
        }


        if(Sessao::getInstance()->verificar_permissao('cadastrar_recurso') || Sessao::getInstance()->verificar_permissao('listar_recurso')) {
            echo '  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts4" aria-expanded="false" aria-controls="collapseLayouts4" >
                                <div class="sb-nav-link-icon"><i class="fas fa-sitemap"></i></div>
                                        Recursos
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>';

            echo ' <div class="collapse" id="collapseLayouts4" aria-labelledby="heading4" data-parent="#sidenavAccordion">
                                                <nav class="sb-sidenav-menu-nested nav">';
            if (Sessao::getInstance()->verificar_permissao('cadastrar_recurso')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_recurso') . '"> Cadastrar Recurso</a>';
            }
            if (Sessao::getInstance()->verificar_permissao('listar_recurso')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_recurso') . '">Listar Recurso</a>';
            }

            echo '
                                            </nav>  
                                        </div>';
        }

        if(Sessao::getInstance()->verificar_permissao('cadastrar_usuario_perfilUsuario') || Sessao::getInstance()->verificar_permissao('listar_usuario_perfilUsuario')) {
            echo '  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts5" aria-expanded="false" aria-controls="collapseLayouts5" >
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i><i class="fas fa-female"></i></div>
                                        Usuário + Perfil
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>';

            echo ' <div class="collapse" id="collapseLayouts5" aria-labelledby="heading5" data-parent="#sidenavAccordion">
                                                <nav class="sb-sidenav-menu-nested nav">';
            if (Sessao::getInstance()->verificar_permissao('cadastrar_usuario_perfilUsuario')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_usuario_perfilUsuario') . '"> Cadastrar Relação do Usuário com seu perfil</a>';
            }
            if (Sessao::getInstance()->verificar_permissao('listar_usuario_perfilUsuario')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario_perfilUsuario') . '">Listar Relação do Usuário com seu perfil</a>';
            }

            echo '
                                            </nav>  
                                        </div>';
        }

        if(Sessao::getInstance()->verificar_permissao('cadastrar_perfilUsuario_recurso') || Sessao::getInstance()->verificar_permissao('listar_perfilUsuario_recurso')) {
            echo '  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts6" aria-expanded="false" aria-controls="collapseLayouts6" >
                                <div class="sb-nav-link-icon"><i class="fas fa-female"></i><i class="fas fa-sitemap"></i></div>
                                        Perfil Usuário + Recurso
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>';

            echo ' <div class="collapse" id="collapseLayouts6" aria-labelledby="heading6" data-parent="#sidenavAccordion">
                                                <nav class="sb-sidenav-menu-nested nav">';
            if (Sessao::getInstance()->verificar_permissao('cadastrar_perfilUsuario_recurso')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_perfilUsuario_recurso') . '"> Cadastrar Relação do Perfil do Usuário com seus Recursos</a>';
            }
            if (Sessao::getInstance()->verificar_permissao('listar_perfilUsuario_recurso')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_perfilUsuario_recurso') . '">Listar Relação do Perfil do Usuário com seus Recursos</a>';
            }

            echo '
                                            </nav>  
                                        </div>';
        }

        if(Sessao::getInstance()->verificar_permissao('cadastrar_categoria_produto') || Sessao::getInstance()->verificar_permissao('listar_categoria_produto')) {
            echo '  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts7" aria-expanded="false" aria-controls="collapseLayouts7" >
                                <div class="sb-nav-link-icon"><i class="fas fa-wine-glass-alt"></i></div>
                                        Categoria Produto
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>';

            echo ' <div class="collapse" id="collapseLayouts7" aria-labelledby="heading" data-parent="#sidenavAccordion">
                                                <nav class="sb-sidenav-menu-nested nav">';
            if (Sessao::getInstance()->verificar_permissao('cadastrar_categoria_produto')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_categoria_produto') . '"> Cadastrar Categoria do Produto</a>';
            }
            if (Sessao::getInstance()->verificar_permissao('listar_categoria_produto')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_categoria_produto') . '">Listar Categoria do Produto</a>';
            }

            echo '
                                            </nav>  
                                        </div>';
        }

        if(Sessao::getInstance()->verificar_permissao('cadastrar_produto') || Sessao::getInstance()->verificar_permissao('listar_produto')) {
            echo '  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts8" aria-expanded="false" aria-controls="collapseLayouts8" >
                                <div class="sb-nav-link-icon"><i class="fas fa-hamburger"></i></div>
                                         Produto
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>';

            echo ' <div class="collapse" id="collapseLayouts8" aria-labelledby="heading8" data-parent="#sidenavAccordion">
                                                <nav class="sb-sidenav-menu-nested nav">';
            if (Sessao::getInstance()->verificar_permissao('cadastrar_produto')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_produto') . '"> Cadastrar Produto</a>';
            }
            if (Sessao::getInstance()->verificar_permissao('listar_produto')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_produto') . '">Listar Produto</a>';
            }

            echo '
                                            </nav>  
                                        </div>';
        }

        if(Sessao::getInstance()->verificar_permissao('realizar_pedido') || Sessao::getInstance()->verificar_permissao('listar_pedido')) {
            echo '  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePedido" aria-expanded="false" aria-controls="collapsePedido" >
                                <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                                         Pedido
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>';

            echo ' <div class="collapse" id="collapsePedido" aria-labelledby="headingPedido" data-parent="#sidenavAccordion">
                                                <nav class="sb-sidenav-menu-nested nav">';
            if (Sessao::getInstance()->verificar_permissao('realizar_pedido')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_pedido') . '"> Realizar Pedido</a>';
            }
            if (Sessao::getInstance()->verificar_permissao('listar_pedido')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_pedido') . '">Listar Pedido</a>';
            }

            echo '
                                            </nav>  
                                        </div>';
        }
                                
                               /* echo '<div class="collapse" id="collapsePages" aria-labelledby="heading3" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth"
                                        >Perfil Usuário
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                                       
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">';
                                            if(Sessao::getInstance()->verificar_permissao('cadastrar_perfil_usuario')) {
                                                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_perfil_usuario') . '"> Cadastrar Perfil Usuário</a>';
                                            }

                                        //<a class="nav-link" href="register.html">Register</a>
                                        //<a class="nav-link" href="password.html">Forgot Password</a>

                                        echo '</nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError"
                                        >Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                                    ></a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.html">401 Page</a>
                                        <a class="nav-link" href="404.html">404 Page</a>
                                        <a class="nav-link" href="500.html">500 Page</a></nav>
                                    </div>
                                </nav>
                            </div>'; */



                      /* echo '   <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                                ><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Mesa
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                            ></a>
                        
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseMesa" aria-expanded="false" aria-controls="pagesCollapseAuth"
                                        >Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                                    ></a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="login.html">Login</a><a class="nav-link" href="register.html">Register</a><a class="nav-link" href="password.html">Forgot Password</a></nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseMeasdas" aria-expanded="false" aria-controls="pagesCollapseError"
                                        >Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                                    ></a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="401.html">401 Page</a><a class="nav-link" href="404.html">404 Page</a><a class="nav-link" href="500.html">500 Page</a></nav>
                                    </div>
                                </nav>
                            </div>';*/
               // }


                echo '   <div class="sb-sidenav-menu-heading">Gráficos</div>
                            <a class="nav-link" href="charts.html"
                                ><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Pedidos</a
                            >
                        </div>
                    </div>';

        echo '      <div class="sb-sidenav-footer">
                        <div class="small">Logado como:</div>
                        '.Sessao::getInstance()->getCPF().'
                    </div>
                </nav>
            </div>
            ';
                echo '  <div id="layoutSidenav_content">
                <main>';
    }

    public static function fechar_lateral(){

        echo  ' </main>';
    }


    public static function fechar_head()
    {
        echo '</head>';
    }

    public function montar_menu_topo() {

        echo '<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">TaNaMesa <img width="40px" height="40px;" src="imgs/logo.PNG" /> </a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
               
                    <!--<input class="form-control" type="text" value="" disabled aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>-->
                </div>
            </form> 
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0" >
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <!--<a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>-->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=sair').'">Logout</a>
                    </div>
                   
                </li>
            </ul>
           
        </nav>';

            //echo '<a href="controlador.php?action=principal">TELA INICIAL</a>';
           /* echo'<header >
            <!--<a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'" ></a> -->
            
           <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">

                <a class="navbar-brand" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Tela Inicial<i class="fas fa-virus"></i></a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-center" id="navbarsExample11">
                    <ul class="navbar-nav">
                        <!--<li class="nav-item active">
                            <a class="nav-link" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=ca').'">Cadastro Amostra</a>
                        </li>-->
                        <!--<li class="nav-item">
                            <a class="nav-link" href="#">Preparo e Armazenamento</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Extração</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">RTPCR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Laudo</a>
                        </li>
                         <li class="nav-item divisor"></li> -->
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Usuário logado:  '.Sessao::getInstance()->getCPF().'
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                  <a class="dropdown-item" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=sair').'">Logoff</a>
                                </div>
                              </div>
                            
                            <!--<div class="dropdown">
                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Usuário logado:  '.Sessao::getInstance()->getCPF().'
                                </button>
                                 <div class="dropdown-menu">
                                  <a class="dropdown-item" href=>Logoff</a>
                                </div>
                              </div>-->
                          
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
                  

          </header>';*/

    }

    public static function  abrir_body(){
        echo '<body class="sb-nav-fixed">';
    }

    public static function fechar_body(){

        echo ' 
                 <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                <script src="js/scripts.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
                <script src="js/chart-area-demo.js"></script>
                <script src="js/chart-bar-demo.js"></script>
                <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
                <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
                <script src="assets/demo/datatables-demo.js"></script>  
                </body>';
    }
    public static function footer(){
        echo '<footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; TaNaMesa IHC 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>';
    }

    public static function fechar_html(){
        echo ' </html>';
    }

    public function mostrar_excecoes() {
        if (count($this->array_validacoes)) {
            $alert = '';
            $msg = '';
            
            foreach ($this->array_validacoes as $validacao) {
                $msg .= $validacao[0];
                $alert .= Alert::alert_msg($validacao[0],$validacao[2]);
            }
            echo $alert;
        }

    }


    public static function formatar_html($strValor){
        return htmlentities($strValor,ENT_QUOTES);
    }

}
