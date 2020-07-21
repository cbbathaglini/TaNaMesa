<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da mesa
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/HistoricoBD.php';

class HistoricoRN
{

    public function cadastrar(Historico $objHistorico){
        try{

            $objExcecao = new Excecao();

            //$this->validarJaExisteNumeroMesa($objHistorico, $objExcecao);

            $objExcecao->lancar_validacoes();

            $objHistoricoBD = new HistoricoBD();
            $objHistorico = $objHistoricoBD->cadastrar($objHistorico);

            return $objHistorico;
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando o histórico no HistóricoRN.', $e);
        }
    }

    public function alterar(Historico $objHistorico) {

        try{

            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();

            $objHistoricoBD = new HistoricoBD();
            $objHistorico  = $objHistoricoBD->alterar($objHistorico);


            return $objHistorico;
        } catch (Throwable $e) {
            throw new Excecao('Erro alterando o histórico no HistóricoRN.', $e);
        }
    }

    public function consultar(Historico $objHistorico) {

        try{
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objHistoricoBD = new HistoricoBD();
            $arr =  $objHistoricoBD->consultar($objHistorico);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro consultando o histórico no HistóricoRN.',$e);
        }
    }

    public function remover(Historico $objHistorico) {

        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objHistoricoBD = new HistoricoBD();

            $arr =  $objHistoricoBD->remover($objHistorico);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro removendo o histórico no HistóricoRN.', $e);
        }
    }

    public function listar(Historico $objHistorico) {

        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objHistoricoBD = new HistoricoBD();

            $arr =  $objHistoricoBD->listar($objHistorico);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando o histórico no HistóricoRN.',$e);
        }
    }

}