<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PratoBD.php';
class PratoRN
{
    private function validarNome(Prato $objPrato,Excecao $objExcecao){
        $strNome = trim($objPrato->getNome());

        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome do prato não foi informado',null,'alert-danger');
        }else{
            if (strlen($strNome) > 100) {
                $objExcecao->adicionar_validacao('O nome do prato possui mais que 100 caracteres.',null,'alert-danger');
            }


        }
        return $objPrato->setNome($strNome);

    }


    private function validarInformacoes(Prato $objPrato,Excecao $objExcecao){
        $strInformacoes = trim($objPrato->getInformacoes());

        if (strlen($strInformacoes) > 300) {
            $objExcecao->adicionar_validacao('As informações do prato possuem mais que 300 caracteres',null,'alert-danger');
        }

        return $objPrato->setInformacoes($strInformacoes);
    }

    private function validarCategoriaPrato(Prato $objPrato,Excecao $objExcecao){

        if($objPrato->getCategoriaPrato() == null){
            $objExcecao->adicionar_validacao('A categoria do prato não foi informado',null,'alert-danger');
        }else{
            if(CategoriaPrato::mostrarDescricaoCategoriaPrato($objPrato->getCategoriaPrato()) == null){
                $objExcecao->adicionar_validacao('A categoria do prato é inválida',null,'alert-danger');
            }
        }

    }

    private function validarIdPrato(Prato $objPrato,Excecao $objExcecao){

        if($objPrato->getIdPrato() == null){
            $objExcecao->adicionar_validacao('O identificador do prato não foi informado',null,'alert-danger');
        }

    }

    private function validarPreco(Prato $objPrato,Excecao $objExcecao){

        if($objPrato->getPreco() == null){
            $objExcecao->adicionar_validacao('O preço do prato não foi informado',null,'alert-danger');
        }else{
            if($objPrato->getPreco() < 0){
                $objExcecao->adicionar_validacao('O preço do prato não pode ser negativo',null,'alert-danger');
            }
        }

    }


    private function validar_ja_existe_prato(Prato $objPrato,Excecao $objExcecao){
        $objPratoRN= new PratoRN();
        $tamPrato = count($objPratoRN->listar($objPrato,1));
        if($tamPrato > 0){
            $objExcecao->adicionar_validacao('O prato já existe',null,'alert-danger');
        }
    }

    private function validar_existe_pedido_com_o_prato(Prato $objPrato,Excecao $objExcecao){
        $objPratoRN= new PratoRN();
        if($objPratoRN->existe_pedido_com_o_prato($objPrato)){
            $objExcecao->adicionar_validacao('Existe ao menos um pedido associado a este prato. Logo, ele não pode ser excluído',null,'alert-danger');
        }
    }


    public function cadastrar(Prato $objPrato) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarNome($objPrato,$objExcecao);
            $this->validarCategoriaPrato($objPrato,$objExcecao);
            $this->validarInformacoes($objPrato,$objExcecao);
            $this->validarPreco($objPrato,$objExcecao);
            $this->validar_ja_existe_prato($objPrato,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objPratoBD = new PratoBD();
            $objPrato = $objPratoBD->cadastrar($objPrato,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objPrato;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o prato.', $e);
        }
    }

    public function alterar(Prato $objPrato) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarNome($objPrato,$objExcecao);
            $this->validarCategoriaPrato($objPrato,$objExcecao);
            $this->validarInformacoes($objPrato,$objExcecao);
            $this->validarPreco($objPrato,$objExcecao);
            $this->validar_ja_existe_prato($objPrato,$objExcecao);
            $this->validarIdPrato($objPrato,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objPratoBD = new PratoBD();
            $objPrato = $objPratoBD->alterar($objPrato,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objPrato;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o prato.', $e);
        }
    }

    public function consultar(Prato $objPrato) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();

            $objPratoBD = new PratoBD();
            $arr =  $objPratoBD->consultar($objPrato,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();

            throw new Excecao('Erro consultando o prato.',$e);
        }
    }

    public function remover(Prato $objPrato) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validar_existe_usuario_com_o_recurso($objPrato,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objPratoBD = new PratoBD();
            $arr =  $objPratoBD->remover($objPrato,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o prato.', $e);
        }
    }

    public function listar(Prato $objPrato,$numLimite=null) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPratoBD = new PratoBD();

            $arr = $objPratoBD->listar($objPrato,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o prato.',$e);
        }
    }

    public function existe_pedido_com_o_prato(Prato $objPrato) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPratoBD = new PratoBD();

            $arr = $objPratoBD->existe_usuario_com_o_recurso($objPrato,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se existe um pedido com esse prato RN.',$e);
        }
    }
}