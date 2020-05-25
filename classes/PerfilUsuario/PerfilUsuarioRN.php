<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do perfil do usuário
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PerfilUsuarioBD.php';

class PerfilUsuarioRN{
    

    private function validarPerfil(PerfilUsuario $perfilUsuario,Excecao $objExcecao){
        $strPerfilUsuario = trim($perfilUsuario->getPerfil());
        
        if ($strPerfilUsuario == '') {
            $objExcecao->adicionar_validacao('O perfil do usuário não foi informado','idPerfilUsuario');
        }else{
            if (strlen($strPerfilUsuario) > 100) {
                $objExcecao->adicionar_validacao('O perfil do usuário possui mais que 100 caracteres.','idPerfilUsuario');
            }

        }
        
        return $perfilUsuario->setPerfil($strPerfilUsuario);

    }


    private function validarRemocao(PerfilUsuario $perfilUsuario,Excecao $objExcecao){

        $perfilUsuarioRN = new PerfilUsuarioRN();
        if($perfilUsuarioRN->existe_usuario_com_perfil($perfilUsuario)){
            $objExcecao->adicionar_validacao("Não pode remover este perfil, pois tem usuário associado a ele",NULL,'alert-danger');
        }
    }

    private function validarJaExistePerfilUsuario(PerfilUsuario $perfilUsuario,Excecao $objExcecao){
        $objPerfilUsuarioRN = new PerfilUsuarioRN();
        $numPerfil = count($objPerfilUsuarioRN->listar($perfilUsuario,1));
        if($numPerfil > 0){
            $objExcecao->adicionar_validacao("O perfil de usuário informado já existe",NULL,'alert-danger');
        }
    }
     

    public function cadastrar(PerfilUsuario $perfilUsuario) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarJaExistePerfilUsuario($perfilUsuario,$objExcecao);
            $this->validarPerfil($perfilUsuario,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $perfilUsuario  = $objPerfilUsuarioBD->cadastrar($perfilUsuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $perfilUsuario;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o perfil do usuário.', $e);
        }
    }

    public function alterar(PerfilUsuario $perfilUsuario) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarJaExistePerfilUsuario($perfilUsuario,$objExcecao);
            $this->validarPerfil($perfilUsuario,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $perfilUsuario = $objPerfilUsuarioBD->alterar($perfilUsuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $perfilUsuario;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o perfil do usuário.', $e);
        }
    }

    public function consultar(PerfilUsuario $perfilUsuario) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $arr =  $objPerfilUsuarioBD->consultar($perfilUsuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o perfil do usuário.',$e);
        }
    }

    public function remover(PerfilUsuario $perfilUsuario) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();

            $this->validarRemocao($perfilUsuario, $objExcecao);
            $objExcecao->lancar_validacoes();

            $arr =  $objPerfilUsuarioBD->remover($perfilUsuario,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o perfil do usuário.', $e);
        }
    }

    public function listar(PerfilUsuario $perfilUsuario,$numLimite=null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            
            $arr = $objPerfilUsuarioBD->listar($perfilUsuario,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o perfil do usuário.',$e);
        }
    }


    public function existe_usuario_com_perfil(PerfilUsuario $perfilUsuario) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();

            $bool = $objPerfilUsuarioBD->existe_usuario_com_perfil($perfilUsuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $bool;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o perfil do usuário.',$e);
        }
    }


}

