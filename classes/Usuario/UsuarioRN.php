<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do usuário do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/UsuarioBD.php';

class UsuarioRN{
    

   private function validarCPF(Usuario $usuario,Excecao $objExcecao){
        $strCPFUsuario = trim($usuario->getCPF());
       
        if ($strCPFUsuario == '') {
            $objExcecao->adicionar_validacao('O CPF não foi informado',null,'alert-danger');
        }else{
            if (strlen($strCPFUsuario) > 11) {
                $objExcecao->adicionar_validacao('O CPF informado possui mais que 11 caracteres.',null,'alert-danger');
            }
        }
        
        return $usuario->setCPF($strCPFUsuario);

    }
    
     private function validarSenha(Usuario $usuario,Excecao $objExcecao){
        $strSenhaUsuario = trim($usuario->getSenha());
       
        if ($strSenhaUsuario == '') {
            $objExcecao->adicionar_validacao('A senha não foi informada',null,'alert-danger');
        }else{
            if (strlen($strSenhaUsuario) > 10) {
                $objExcecao->adicionar_validacao('A senha possui mais que 10 caracteres.',null,'alert-danger');
            }
            
            //validacoes de senha
        }
        
        return $usuario->setSenha($strSenhaUsuario);

    }

    private function validarJaExisteUsuario(Usuario $usuario,Excecao $objExcecao){

       $objUsuarioRN = new UsuarioRN();
       $numUsuario = count($objUsuarioRN->listar($usuario,1));
       if($numUsuario > 0){
           $objExcecao->adicionar_validacao('O usuário já existe',null,'alert-danger');
       }

    }


     

    public function cadastrar(Usuario $usuario) {
        try {
            $objExcecao = new Excecao();

            $this->validarCPF($usuario,$objExcecao);
            $this->validarSenha($usuario,$objExcecao);
            //$this->validarJaExisteUsuario($usuario,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $objUsuario = $objUsuarioBD->cadastrar($usuario);

            return $objUsuario;
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando o usuário.', $e);
        }
    }

    public function alterar(Usuario $usuario) {
         try {
            $objExcecao = new Excecao();

            $this->validarCPF($usuario,$objExcecao);
            $this->validarSenha($usuario,$objExcecao);
            //$this->validarJaExisteUsuario($usuario,$objExcecao);
                        
            $objExcecao->lancar_validacoes();

            $objUsuarioBD = new UsuarioBD();
            $objUsuario = $objUsuarioBD->alterar($usuario);

             return $objUsuario;
        } catch (Throwable $e) {
            throw new Excecao('Erro alterando o usuário.', $e);
        }
    }

    public function consultar(Usuario $usuario) {
        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr =  $objUsuarioBD->consultar($usuario);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro consultando o usuário.',$e);
        }
    }

    public function remover(Usuario $usuario) {
        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr =  $objUsuarioBD->remover($usuario);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro removendo o usuário.', $e);
        }
    }

    public function listar(Usuario $usuario,$numLimite = null) {
        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            
            $arr = $objUsuarioBD->listar($usuario,$numLimite);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando o usuário.',$e);
        }
    }


    public function logar(Usuario $usuario) {
        try {
            $objExcecao = new Excecao();

            $this->validarCPF($usuario,$objExcecao);
            $this->validarSenha($usuario,$objExcecao);

            $objUsuarioBD = new UsuarioBD();

            $arr = $objUsuarioBD->logar($usuario);
            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro validando cadastro do usuário.', $e);
        }
    }
}

