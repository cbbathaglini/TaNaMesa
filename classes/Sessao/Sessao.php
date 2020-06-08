<?php

require_once __DIR__ . '/../Excecao/Excecao.php';


require_once __DIR__ . '/../Usuario/Usuario.php';
require_once __DIR__ . '/../Usuario/UsuarioRN.php';

require_once __DIR__ . '/../Recurso/Recurso.php';
require_once __DIR__ . '/../Recurso/RecursoRN.php';

require_once __DIR__ . '/../Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario.php';
require_once __DIR__ . '/../Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario_RN.php';

require_once __DIR__ . '/../Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
require_once __DIR__ . '/../Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';


class Sessao {

    private static $instance;
    private $bolAutorizar;


    public static function getInstance($bolAutorizar = true) {
        if (self::$instance == null) {
            self::$instance = new Sessao($bolAutorizar);
        }
        return self::$instance;
    }

    /**
     * Sessao constructor.
     * @param $bolAutorizar
     */
    public function __construct($bolAutorizar)
    {
        $this->bolAutorizar = $bolAutorizar;
    }


    public function logar($CPF, $senha) {

        try {

            unset($_SESSION['TANAMESA']);

            if ($CPF != null && $CPF != '' && $senha != '' && $senha != null) {

                $objUsuario = new Usuario();
                $objUsuarioRN = new UsuarioRN();

                $objUsuario->setCPF($CPF);
                $objUsuario->setSenha($senha);
                $usuario = $objUsuarioRN->logar($objUsuario);


                //$arr_valida = $objUsuarioRN->validar_cadastro($objUsuario);

                if (is_null($usuario)) {
                    $objExcecao = new Excecao();
                    $objExcecao->adicionar_validacao("Usuário não encontrado.");
                    die("Usuário não encontrado.");
                    //header('Location: controlador.php?action=usuario_naoEncontrado');
                    //die();
                }



                $arr_usuario = $objUsuarioRN->listar($objUsuario);
                /*
                    echo "<pre>";
                    print_r($arr_usuario);
                    echo "</pre>";
                */


                $arr_perfis = explode(",",$arr_usuario[0]->getListaPerfis());
                $arr_recursos = explode(",",$arr_usuario[0]->getListaRecursos());

                $objRecurso = new Recurso();
                $objRecursoRN = new RecursoRN();
                foreach ($arr_recursos as $recurso){
                    $objRecurso->setIdRecurso($recurso);
                    $objRecurso= $objRecursoRN->consultar($objRecurso);
                    $arrRecurso[] = $objRecurso->getLink();
                }

                if (empty($arr_perfis) && $arr_perfis == null) {
                    $objExcecao = new Excecao();
                    $objExcecao->adicionar_validacao("Usuário não tem permissões no sistema.");
                    die("Usuário não tem permissões no sistema.");
                }

                if (empty($arrRecurso) && $arrRecurso == null) {
                    $objExcecao = new Excecao();
                    $objExcecao->adicionar_validacao("Usuário não tem nenhum recurso no sistema.");
                }


                //print_r($arr_recursos);
                $_SESSION['TANAMESA'] = array();
                $_SESSION['TANAMESA']['ID_USUARIO'] = $arr_usuario[0]->getIdUsuario();
                $_SESSION['TANAMESA']['CPF'] = $arr_usuario[0]->getCPF();
                $_SESSION['TANAMESA']['RECURSOS'] = $arrRecurso;
                $_SESSION['TANAMESA']['CHAVE'] = hash('sha256', random_bytes(50));

                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=principal'));
                die();
            }
        } catch (Exception $ex) {
            if (!Configuracao::getInstance()->getValor("producao")) {
                echo "<pre>" . $ex . "</pre>";
            }

            die("erro na sessão");
        }
    }

    public function logoff() {
                
        session_destroy();
        
        
        
    }

    public function validar() {

        if (!isset($_SESSION['TANAMESA']['ID_USUARIO']) || $_SESSION['TANAMESA']['ID_USUARIO'] == null) {
            //LOGIN
            //header('Location: controlador.php?action=listar_perfilPaciente');
        }

        foreach ($_GET as $strChave => $strValor) {
            if (($strChave != 'action' && substr($strChave, 0, 2) != 'id' && $strChave != 'hash') || ($strChave == 'action' && !preg_match('/^[a-zA-Z0-9_]+/', $strValor)) || (substr($strChave, 0, 2) == 'id' && !is_numeric($strValor)) || ($strChave == 'hash' && (strlen($strValor) != 64 || !ctype_alnum($strValor)))
            ) {
                //die('url inválida:' . $strChave . "=" . $strValor);
                header('Location: controlador.php?action=login');
                die();
            }
        }

        if (!$this->verificar_link()) {
            $this->logoff();
            header('Location: controlador.php?action=login');
            die();
        }

        if (!$this->verificar_permissao($_GET['action'])) {
            throw new Exception("Acesso negado");
            die();
        }
    }

    public function getIdUsuario() {
      if(isset($_SESSION['TANAMESA']['ID_USUARIO'])) {
          return $_SESSION['TANAMESA']['ID_USUARIO'];
      }
      return null;
    }

    public function getCPF() {
        return $_SESSION['TANAMESA']['CPF'];
    }

    public function assinar_link($link) {
        //http://localhost/covid-system/public_html/controlador.php?action=editar_doenca&idDoenca=8

        $strPosParam = strpos($link, '?');
        if ($strPosParam !== FALSE) {
            $strParametros = substr($link, $strPosParam + 1);
            //throw new Exception("XXXX");
            $link = substr($link, 0, $strPosParam + 1) . $strParametros . '&hash=' . hash('sha256', $strParametros . $_SESSION['TANAMESA']['CHAVE']);
        }
        return $link;
    }

    public function verificar_link() {
        //http://localhost/covid-system/public_html/controlador.php?action=editar_doenca&idDoenca=8&hash=hhhhhh
        $link = $_SERVER['QUERY_STRING'];

        if (strlen($link)) {


            $strPosHash = strpos($link, '&hash=');
            if ($strPosHash !== FALSE) {
                $strParametros = substr($link, 0, $strPosHash);

                if (hash('sha256', $strParametros . $_SESSION['TANAMESA']['CHAVE']) == $_GET['hash']) {
                    return true;
                }
            }
        }
        return false;
    }

    public function verificar_permissao($strRecurso) {
        if(!$this->bolAutorizar){
            return true;
        }
        if (in_array($strRecurso, $_SESSION['TANAMESA']['RECURSOS'])) {
            return true;
        }
        return false;
    }

}
