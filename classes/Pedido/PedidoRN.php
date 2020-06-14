<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da pedido
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PedidoBD.php';

class PedidoRN
{

    public function cadastrar(Pedido $objPedido){
        try{

            $objExcecao = new Excecao();

            //$this->validarJaExisteNumeroMesa($objPedido, $objExcecao);

            $objExcecao->lancar_validacoes();

            $objPedidoBD = new PedidoBD();
            $objPedido = $objPedidoBD->cadastrar($objPedido);

            return $objPedido;
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando o pedido no PedidoRN.', $e);
        }
    }

    public function alterar(Pedido $objPedido) {

        try{

            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();

            $objPedidoBD = new PedidoBD();
            $objPedido  = $objPedidoBD->alterar($objPedido);


            return $objPedido;
        } catch (Throwable $e) {
            throw new Excecao('Erro alterando o pedido no PedidoRN.', $e);
        }
    }

    public function consultar(Pedido $objPedido) {

        try{
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objPedidoBD = new PedidoBD();
            $arr =  $objPedidoBD->consultar($objPedido);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro consultando o pedido no PedidoRN.',$e);
        }
    }

    public function remover(Pedido $objPedido) {

        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objPedidoBD = new PedidoBD();

            $arr =  $objPedidoBD->remover($objPedido);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro removendo o pedido no PedidoRN.', $e);
        }
    }

    public function listar(Pedido $objPedido) {

        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objPedidoBD = new PedidoBD();

            $arr =  $objPedidoBD->listar($objPedido);


            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando os pedidos no PedidoRN.',$e);
        }
    }

}