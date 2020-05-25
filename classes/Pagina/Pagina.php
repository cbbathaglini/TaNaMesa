<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Sessao/Sessao.php';
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
        if(Configuracao::getInstance()->getValor('producao')){
            $strVersao =Configuracao::getInstance()->getValor('versao');
        }else{
           $strVersao = rand(); 
        }

        echo '<link rel="stylesheet" type="text/css" href="css/'.$strArquivo.'.css?'.$strVersao.'">';
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
                print_r($log);
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
                        <link rel="icon" type="text/css" href="docs/img/coronavirus.png"><!--<i class="fas fa-virus"></i>-->
                        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                        <!-- Font Awesome --><!-- NÃO REMOVER SENÃO NÃO APARECEM OS ÍCONES -->
                        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

                        <!-- HTML5Shiv -->
                        <!--[if lt IE 9]>
                          <script src="js/html5shiv.min.js"></script>

                        <link rel="stylesheet" href="css/fontawesome.css">
                        <![endif]-->

                        <!-- Bootstrap CSS -->
                        <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->

                        <script src="js/jquery-3.3.1.slim.min.js"></script>
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
                        
                        <style>
                        
                       
                        
                        /* Barra de rolagem */
                        ::-webkit-scrollbar {width:9px;height:auto;background: #fff;border-bottom:none;}
                        ::-webkit-scrollbar-button:vertical {height:2px;display:block;} 
                        ::-webkit-scrollbar-thumb:vertical {background-color: #3a5261; -webkit-border-radius: 1px;}
                        ::-webkit-scrollbar-button:horizontal {height:2px;display:block;}
                        ::-webkit-scrollbar-thumb:horizontal {background-color: #3a5261; -webkit-border-radius: 1px;}
                         
                        .fas{
                            color:#3a5261;
                        }
                        .btn-primary{
                            background-color:#3a5261;
                            border:none;
                        }
                        
                        .btn-primary:hover{
                            background-color:#DBDFE2;
                            color: #3a5261;
                            transition: .5s;
                        }
                        
                        .btn-secondary{
                            background: none;
                            border-radius: 0px;
                            border: none;
                            color:#3a5261;
                        }
                        
                        .btn-secondary:hover,.btn-secondary:active{
                            border-bottom: 1px solid #3a5261;
                            background: none;
                            color:#3a5261;
                            /*color: white;
                            background-color:#3a5261;*/
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
                                background: #3a5261;
                        }  

                        </style>
                                                
                        <!-- google fonts -->
                        <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">
                        ';
    }


    public static function fechar_head()
    {
        echo '</head>';
    }

    public function montar_menu_topo() {
            //echo '<a href="controlador.php?action=principal">TELA INICIAL</a>';
            echo'<header >
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
                  

          </header>';

    }

    public static function  abrir_body(){
        echo '<body>';
    }

    public static function fechar_body(){
        echo '    </body>
              </html>';
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
