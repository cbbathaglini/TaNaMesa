<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/ProdutoBD.php';
class ProdutoRN
{
    private function validarNome(Produto $objProduto, Excecao $objExcecao){
        $strNome = trim($objProduto->getNome());

        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome do produto não foi informado',null,'alert-danger');
        }else{
            if (strlen($strNome) > 100) {
                $objExcecao->adicionar_validacao('O nome do produto possui mais que 100 caracteres.',null,'alert-danger');
            }


        }
        return $objProduto->setNome($strNome);

    }


    private function validarInformacoes(Produto $objProduto, Excecao $objExcecao){
        $strInformacoes = trim($objProduto->getInformacoes());

        if (strlen($strInformacoes) > 300) {
            $objExcecao->adicionar_validacao('As informações do produto possuem mais que 300 caracteres',null,'alert-danger');
        }

        return $objProduto->setInformacoes($strInformacoes);
    }

    private function validarCategoriaproduto(Produto $objProduto, Excecao $objExcecao){

        if($objProduto->getCategoriaproduto() == null){
            $objExcecao->adicionar_validacao('A categoria do produto não foi informado',null,'alert-danger');
        }else{
            if(Categoriaproduto::mostrarDescricaoCategoriaproduto($objProduto->getCategoriaproduto()) == null){
                $objExcecao->adicionar_validacao('A categoria do produto é inválida',null,'alert-danger');
            }
        }

    }

    private function validarIdproduto(Produto $objProduto, Excecao $objExcecao){

        if($objProduto->getIdproduto() == null){
            $objExcecao->adicionar_validacao('O identificador do produto não foi informado',null,'alert-danger');
        }

    }

    private function validarPreco(Produto $objProduto, Excecao $objExcecao){

        if($objProduto->getPreco() == null){
            $objExcecao->adicionar_validacao('O preço do produto não foi informado',null,'alert-danger');
        }else{
            if($objProduto->getPreco() < 0){
                $objExcecao->adicionar_validacao('O preço do produto não pode ser negativo',null,'alert-danger');
            }
        }

    }


    private function validar_ja_existe_produto(Produto $objProduto, Excecao $objExcecao){
        $objProdutoRN= new ProdutoRN();
        $tamproduto = count($objProdutoRN->listar($objProduto,1));
        if($tamproduto > 0){
            $objExcecao->adicionar_validacao('O produto já existe',null,'alert-danger');
        }
    }

    private function validar_existe_pedido_com_o_produto(Produto $objProduto, Excecao $objExcecao){
        $objProdutoRN= new ProdutoRN();
        if($objProdutoRN->existe_pedido_com_o_produto($objProduto)){
            $objExcecao->adicionar_validacao('Existe ao menos um pedido associado a este produto. Logo, ele não pode ser excluído',null,'alert-danger');
        }
    }


    public function cadastrar(Produto $objProduto) {
        try {
            $objExcecao = new Excecao();

            //$this->validarNome($objProduto,$objExcecao);
            //$this->validarCategoriaproduto($objProduto,$objExcecao);
            //$this->validarInformacoes($objProduto,$objExcecao);
            ///$this->validarPreco($objProduto,$objExcecao);
            //$this->validar_ja_existe_produto($objProduto,$objExcecao);

            //$objExcecao->lancar_validacoes();
            $objProdutoBD = new ProdutoBD();
            $objProduto = $objProdutoBD->cadastrar($objProduto);

            return $objProduto;
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando o produto.', $e);
        }
    }

    public function alterar(Produto $objProduto) {
        try {
            $objExcecao = new Excecao();

            //$this->validarNome($objProduto,$objExcecao);
           // $this->validarCategoriaproduto($objProduto,$objExcecao);
           //$this->validarInformacoes($objProduto,$objExcecao);
            //$this->validarPreco($objProduto,$objExcecao);
            //$this->validar_ja_existe_produto($objProduto,$objExcecao);
            //$this->validarIdproduto($objProduto,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objProdutoBD = new ProdutoBD();
            $objProduto = $objProdutoBD->alterar($objProduto);

            return $objProduto;
        } catch (Throwable $e) {
            throw new Excecao('Erro alterando o produto.', $e);
        }
    }

    public function consultar(Produto $objProduto) {

        try {
            $objExcecao = new Excecao();
            $objExcecao->lancar_validacoes();

            $objProdutoBD = new ProdutoBD();
            $arr =  $objProdutoBD->consultar($objProduto);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro consultando o produto.',$e);
        }
    }

    public function remover(Produto $objProduto) {
        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objProdutoBD = new ProdutoBD();
            $arr =  $objProdutoBD->remover($objProduto);
            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro removendo o produto.', $e);
        }
    }

    public function listar(Produto $objProduto, $numLimite=null) {
        try {
            $objExcecao = new Excecao();
            $objExcecao->lancar_validacoes();
            $objProdutoBD = new ProdutoBD();

            $arr = $objProdutoBD->listar($objProduto,$numLimite);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando o produto.',$e);
        }
    }


}