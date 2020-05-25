<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do usuário do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/Rel_usuario_perfilUsuario_BD.php';

class Rel_usuario_perfilUsuario_RN{

    private function validarJaExisteRelacinamento(Rel_usuario_perfilUsuario $relUsuarioPerfil,Excecao $objExcecao){

        $objRel_usuario_perfilUsuarioRN = new Rel_usuario_perfilUsuario_RN();
        $numUsuarioPerfilUsuario = count($objRel_usuario_perfilUsuarioRN->listar($relUsuarioPerfil,1));
        if($numUsuarioPerfilUsuario > 0){
            $objExcecao->adicionar_validacao('O usuário já tem esse perfil associado a ele',null,'alert-danger');
        }

    }

    public function cadastrar(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            if($relUsuarioPerfil->getObjsRelacionamentos() != null){
                foreach ($relUsuarioPerfil->getObjsRelacionamentos() as $relacionamento){
                    $this->validarJaExisteRelacinamento($relacionamento,$objExcecao);
                    $objExcecao->lancar_validacoes();
                    $relUsuarioPerfil = $objRel_usuario_perfilUsuario_BD->cadastrar($relacionamento, $objBanco);
                }
            }else {
                $this->validarJaExisteRelacinamento($relUsuarioPerfil,$objExcecao);
                $relUsuarioPerfil = $objRel_usuario_perfilUsuario_BD->cadastrar($relUsuarioPerfil, $objBanco);
            }
            $objExcecao->lancar_validacoes();
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $relUsuarioPerfil;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o relacionamento do usuário com o seu perfil.', $e);
        }
    }

    public function alterar(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            $relUsuarioPerfil = $objRel_usuario_perfilUsuario_BD->alterar($relUsuarioPerfil,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $relUsuarioPerfil;
        } catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o relacionamento do usuário com o seu perfil.', $e);
        }
    }

    public function consultar(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            $arr =  $objRel_usuario_perfilUsuario_BD->consultar($relUsuarioPerfil,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o relacionamento do usuário com o seu perfil.',$e);
        }
    }

    public function remover(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            $arr =  $objRel_usuario_perfilUsuario_BD->remover($relUsuarioPerfil,$objBanco);

            $objBanco->fecharConexao();
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o relacionamento do usuário com o seu perfil.', $e);
        }
    }

    public function listar(Rel_usuario_perfilUsuario $relUsuarioPerfil,$numLimite=null) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            
            $arr = $objRel_usuario_perfilUsuario_BD->listar($relUsuarioPerfil,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o relacionamento do usuário com o seu perfil.',$e);
        }
    }

    public function listar_usuario_com_perfil(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();

            $arr = $objRel_usuario_perfilUsuario_BD->listar_usuario_com_perfil($relUsuarioPerfil,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o relacionamento do usuário com o seu perfil.',$e);
        }
    }

}

