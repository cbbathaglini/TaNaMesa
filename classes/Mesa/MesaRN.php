<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da mesa
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/MesaBD.php';

class MesaRN
{

    public function cadastrar(Mesa $objMesa){
        try{

            $objExcecao = new Excecao();

            //$this->validarJaExisteNumeroMesa($objMesa, $objExcecao);

            $objExcecao->lancar_validacoes();

            $objMesaBD = new MesaBD();
            $objMesa = $objMesaBD->cadastrar($objMesa);

            return $objMesa;
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando a mesa na MesaRN.', $e);
        }
    }

    public function alterar(Mesa $objMesa) {

        try{

            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();

            $objMesaBD = new MesaBD();
            $objMesa  = $objMesaBD->alterar($objMesa);


            return $objMesa;
        } catch (Throwable $e) {
            throw new Excecao('Erro alterando a mesa na MesaRN.', $e);
        }
    }

    public function consultar(Mesa $objMesa) {

        try{
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objMesaBD = new MesaBD();
            $arr =  $objMesaBD->consultar($objMesa);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro consultando a mesa na MesaRN.',$e);
        }
    }

    public function remover(Mesa $objMesa) {

        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objMesaBD = new MesaBD();

            $arr =  $objMesaBD->remover($objMesa);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro removendo a mesa na MesaRN.', $e);
        }
    }

    public function listar(Mesa $objMesa) {

        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objMesaBD = new MesaBD();

            $arr =  $objMesaBD->listar($objMesa);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando as mesas na MesaRN.',$e);
        }
    }

}