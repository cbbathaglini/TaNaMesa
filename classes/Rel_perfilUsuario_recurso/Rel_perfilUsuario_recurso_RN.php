<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do usuário do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/Rel_perfilUsuario_recurso_BD.php';

class Rel_perfilUsuario_recurso_RN{

    private function validarJaExisteRelacionamento(Rel_perfilUsuario_recurso $relPerfilRecurso,Excecao $objExcecao){

        $objRel_perfilUsuario_recurso_RN = new Rel_perfilUsuario_recurso_RN();
        $numPerfilUsuarioRecurso = count($objRel_perfilUsuario_recurso_RN->listar($relPerfilRecurso,1));
        if($numPerfilUsuarioRecurso > 0){
            $objExcecao->adicionar_validacao('O perfil de usuário já tem esse recurso associado a ele',null,'alert-danger');
        }

    }

    public function cadastrar(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarJaExisteRelacionamento($relPerfilRecurso, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            $relPerfilRecurso = $objRel_perfilUsuario_recurso_BD->cadastrar($relPerfilRecurso,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $relPerfilRecurso;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o relacionamento do perfil do usuário com o seu recurso.', $e);
        }
    }

    public function alterar(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            
                        
            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            $relPerfilRecurso = $objRel_perfilUsuario_recurso_BD->alterar($relPerfilRecurso,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $relPerfilRecurso;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o relacionamento do perfil do usuário com o seu recurso.', $e);
        }
    }

    public function consultar(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            $arr =  $objRel_perfilUsuario_recurso_BD->consultar($relPerfilRecurso,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o relacionamento do perfil do usuário com o seu recurso.',$e);
        }
    }

    public function remover(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            $arr =  $objRel_perfilUsuario_recurso_BD->remover($relPerfilRecurso,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o relacionamento do perfil do usuário com o seu recurso.', $e);
        }
    }

    public function listar(Rel_perfilUsuario_recurso $relPerfilRecurso,$numLimite=null) {
        $objBanco = new Banco();
        try {
                $objExcecao = new Excecao();
                $objBanco->abrirConexao();
                $objBanco->abrirTransacao();

                $objExcecao->lancar_validacoes();
                $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();

                $arr = $objRel_perfilUsuario_recurso_BD->listar($relPerfilRecurso,$numLimite,$objBanco);

                $objBanco->confirmarTransacao();
                $objBanco->fecharConexao();

                return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o relacionamento do perfil do usuário com o seu recurso.',$e);
        }
    }
    
    public function listar_recursos(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            
            $arr = $objRel_perfilUsuario_recurso_BD->listar_recursos($relPerfilRecurso,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o relacionamento do perfil do usuário com o seu recurso.',$e);
        }
    }

}

