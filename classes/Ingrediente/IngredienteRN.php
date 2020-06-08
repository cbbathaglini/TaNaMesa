<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/IngredienteBD.php';

class IngredienteRN
{

    private function validarIngrediente(Ingrediente $objIngrediente,Excecao $objExcecao){
        $strIngrediente = trim($objIngrediente->getIngrediente());

        if ($strIngrediente == '') {
            $objExcecao->adicionar_validacao('O ingrediente não foi informado',null,'alert-danger');
        }else{
            if (strlen($strIngrediente) > 100) {
                $objExcecao->adicionar_validacao('O ingrediente possui mais que 100 caracteres.',null,'alert-danger');
            }


        }
        return $objIngrediente->setIngrediente($strIngrediente);

    }


    private function validarIdIngrediente(Ingrediente $objIngrediente,Excecao $objExcecao){

        if($objIngrediente->getIdIngrediente() == null ) {
            $objExcecao->adicionar_validacao('O identificador do ingrediente não foi informado', 'idSNRecurso', 'alert-danger');
        }

    }

    /*
    private function validar_ja_existe_ingrediente(Ingrediente $objIngrediente,Excecao $objExcecao){
        $objIngredienteRN = new IngredienteRN();
        $tamRecurso = count($objIngredienteRN->listar($objIngrediente,1));
        if($tamRecurso > 0){
            $objExcecao->adicionar_validacao('O ingrediente já existe',null,'alert-danger');
        }
    }

    private function validar_existe_prato_com_o_ingrediente(Ingrediente $objIngrediente,Excecao $objExcecao){
        $objIngredienteRN = new IngredienteRN();
        if($objIngredienteRN->existe_usuario_com_o_ingrediente($objIngrediente)){
            $objExcecao->adicionar_validacao('Existe ao menos um prato associado a este ingrediente. Logo, ele não pode ser excluído',null,'alert-danger');
        }
    }
    */


    public function cadastrar(Ingrediente $objIngrediente) {
        try {
            $objExcecao = new Excecao();
            $this->validarIngrediente($objIngrediente,$objExcecao);
            //$this->validar_ja_existe_ingrediente($objIngrediente,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objIngredienteBD = new IngredienteBD();
            $objIngrediente = $objIngredienteBD->cadastrar($objIngrediente);
            return $objIngrediente;
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando o ingrediente.', $e);
        }
    }

    public function alterar(Ingrediente $objIngrediente) {
        try {
            $objExcecao = new Excecao();


            $this->validarIngrediente($objIngrediente,$objExcecao);
            //$this->validar_ja_existe_ingrediente($objIngrediente,$objExcecao);
            $this->validarIdIngrediente($objIngrediente,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objIngredienteBD = new IngredienteBD();
            $objIngrediente = $objIngredienteBD->alterar($objIngrediente);

            return $objIngrediente;
        } catch (Throwable $e) {
            throw new Excecao('Erro alterando o ingrediente.', $e);
        }
    }

    public function consultar(Ingrediente $objIngrediente) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objIngredienteBD = new IngredienteBD();
            $ingrediente =  $objIngredienteBD->consultar($objIngrediente,$objBanco);

            return $ingrediente;
        } catch (Throwable $e) {
            throw new Excecao('Erro consultando o ingrediente.',$e);
        }
    }

    public function remover(Ingrediente $objIngrediente) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validar_existe_usuario_com_o_ingrediente($objIngrediente,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objIngredienteBD = new IngredienteBD();
            $arr =  $objIngredienteBD->remover($objIngrediente,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o ingrediente.', $e);
        }
    }

    public function listar(Ingrediente $objIngrediente,$numLimite=null) {
        try {
            $objExcecao = new Excecao();
            $objExcecao->lancar_validacoes();
            $objIngredienteBD = new IngredienteBD();

            $arr = $objIngredienteBD->listar($objIngrediente,$numLimite);
            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando o ingrediente.',$e);
        }
    }

    public function existe_prato_com_o_ingrediente(Ingrediente $objIngrediente) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objIngredienteBD = new IngredienteBD();

            $arr = $objIngredienteBD->existe_prato_com_o_ingrediente($objIngrediente,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se existe um prato com o ingrediente RN.',$e);
        }
    }
}