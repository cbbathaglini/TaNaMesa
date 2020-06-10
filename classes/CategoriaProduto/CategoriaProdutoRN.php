<?php
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CategoriaProdutoBD.php';

class CategoriaProdutoRN
{
    /*public static $CP_PEIXE = 'P';
    public static $CP_CARNE = 'C';
    public static $CP_FRANGO = 'F';
    public static $CP_MASSA = 'M';
    public static $CP_PIZZA = 'Z';

    public static function listarValoresCategoriaPrato(){
        try {

            $arrObjTStaMesa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_PEIXE);
            $objSituacao->setStrDescricao('Peixe');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_CARNE);
            $objSituacao->setStrDescricao('Carne');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_FRANGO);
            $objSituacao->setStrDescricao('Frango');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_MASSA);
            $objSituacao->setStrDescricao('Massa');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_PIZZA);
            $objSituacao->setStrDescricao('Pizza');
            $arrObjTStaMesa[] = $objSituacao;

            return $arrObjTStaMesa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando categorias dos produtos',$e);
        }
    }

    public static function mostrarDescricaoCategoriaProduto($caractere){
        foreach (self::listarValoresCategoriaPrato() as $sta){
            if($sta->getStrTipo() == $caractere){
                return $sta->getStrDescricao();
            }
        }
        return null;
    } */

    public function cadastrar(CategoriaProduto $objCategoriaProduto){
        try{

            $objExcecao = new Excecao();

            //$this->validarJaExisteNumeroMesa($objCategoriaProduto, $objExcecao);

            $objExcecao->lancar_validacoes();

            $objCategoriaProdutoBD = new CategoriaProdutoBD();
            $objCategoriaProduto = $objCategoriaProdutoBD->cadastrar($objCategoriaProduto);

            return $objCategoriaProduto;
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando a categoria do produto em CategoriaProdutoRN.', $e);
        }
    }

    public function alterar(CategoriaProduto $objCategoriaProduto) {

        try{

            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();

            $objCategoriaProdutoBD = new CategoriaProdutoBD();
            $objCategoriaProduto  = $objCategoriaProdutoBD->alterar($objCategoriaProduto);


            return $objCategoriaProduto;
        } catch (Throwable $e) {
            throw new Excecao('Erro alterando a categoria do produto em CategoriaProdutoRN.', $e);
        }
    }

    public function consultar(CategoriaProduto $objCategoriaProduto) {

        try{
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objCategoriaProdutoBD = new CategoriaProdutoBD();
            $arr =  $objCategoriaProdutoBD->consultar($objCategoriaProduto);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro consultando a categoria do produto em CategoriaProdutoRN.',$e);
        }
    }

    public function remover(CategoriaProduto $objCategoriaProduto) {

        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objCategoriaProdutoBD = new CategoriaProdutoBD();

            $arr =  $objCategoriaProdutoBD->remover($objCategoriaProduto);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro removendo a categoria do produto em CategoriaProdutoRN.', $e);
        }
    }

    public function listar(CategoriaProduto $objCategoriaProduto) {

        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objCategoriaProdutoBD = new CategoriaProdutoBD();

            $arr =  $objCategoriaProdutoBD->listar($objCategoriaProduto);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando as categorias dos produtos em CategoriaProdutoRN.',$e);
        }
    }
}