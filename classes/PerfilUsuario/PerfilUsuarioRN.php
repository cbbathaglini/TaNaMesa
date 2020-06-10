<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do perfil do usuário
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PerfilUsuarioBD.php';
require_once  __DIR__.'/../Situacao/Situacao.php';
class PerfilUsuarioRN{

    public static $PU_ADMINISTRADOR = 'A';
    public static $PU_GARCOM = 'G';
    public static $PU_GERENTE = 'E';

    public static function listarValoresTipoUsuario(){
        try {

            $arrObjTStaMesa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$PU_ADMINISTRADOR);
            $objSituacao->setStrDescricao('ADMINISTRADOR');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$PU_GARCOM);
            $objSituacao->setStrDescricao('GARÇOM');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$PU_GERENTE);
            $objSituacao->setStrDescricao('GERENTE');
            $arrObjTStaMesa[] = $objSituacao;

            return $arrObjTStaMesa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando situações da mesa',$e);
        }
    }

    public static function mostrarDescricaoTipoUsuario($caractere){
        foreach (self::listarValoresTipoUsuario() as $sta){
            if($sta->getStrTipo() == $caractere){
                return $sta->getStrDescricao();
            }
        }
        return null;
    }


    private function validarPerfil(PerfilUsuario $perfilUsuario,Excecao $objExcecao){
        $strPerfilUsuario = trim($perfilUsuario->getPerfil());
        
        if ($strPerfilUsuario == '') {
            $objExcecao->adicionar_validacao('O perfil do usuário não foi informado',NULL,'alert-danger');
        }else{
            if (strlen($strPerfilUsuario) > 100) {
                $objExcecao->adicionar_validacao('O perfil do usuário possui mais que 100 caracteres.',NULL,'alert-danger');
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
        try {

            $objExcecao = new Excecao();

            $this->validarPerfil($perfilUsuario,$objExcecao); 
            $objExcecao->lancar_validacoes();

            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $perfilUsuario  = $objPerfilUsuarioBD->cadastrar($perfilUsuario);

            return $perfilUsuario;
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando o perfil do usuário.', $e);
        }
    }

    public function alterar(PerfilUsuario $perfilUsuario) {
        try {

            $objExcecao = new Excecao();

            $this->validarPerfil($perfilUsuario,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $perfilUsuario = $objPerfilUsuarioBD->alterar($perfilUsuario);

            return $perfilUsuario;
        } catch (Throwable $e) {
            throw new Excecao('Erro alterando o perfil do usuário.', $e);
        }
    }

    public function consultar(PerfilUsuario $perfilUsuario) {
        try {


            $objExcecao = new Excecao();
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $arr =  $objPerfilUsuarioBD->consultar($perfilUsuario);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro consultando o perfil do usuário.',$e);
        }
    }

    public function remover(PerfilUsuario $perfilUsuario) {
        try {

            $objExcecao = new Excecao();
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();

            $this->validarRemocao($perfilUsuario, $objExcecao);
            $objExcecao->lancar_validacoes();

            $arr =  $objPerfilUsuarioBD->remover($perfilUsuario);
            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro removendo o perfil do usuário.', $e);
        }
    }

    public function listar(PerfilUsuario $perfilUsuario,$numLimite=null) {
        try {

            $objExcecao = new Excecao();
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();

            $arr = $objPerfilUsuarioBD->listar($perfilUsuario,$numLimite);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando o perfil do usuário.',$e);
        }
    }


    public function existe_usuario_com_perfil(PerfilUsuario $perfilUsuario) {
        try {

            $objExcecao = new Excecao();
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();

            $bool = $objPerfilUsuarioBD->existe_usuario_com_perfil($perfilUsuario);

            return $bool;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando o perfil do usuário.',$e);
        }
    }


}

