<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da mesa
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/MesaBD.php';
require_once  __DIR__.'/../Situacao/Situacao.php';

class MesaRN
{

    public static $STA_OCUPADA = 'O';
    public static $STA_LIBERADA = 'L';

    public static function listarValoresSituacaoMesa(){
        try {

            $arrObjTStaMesa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_OCUPADA);
            $objSituacao->setStrDescricao('OCUPADA');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_LIBERADA);
            $objSituacao->setStrDescricao('LIBERADA');
            $arrObjTStaMesa[] = $objSituacao;

            return $arrObjTStaMesa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando situações da mesa',$e);
        }
    }

    public static function mostrarDescricaoSituacaoMesa($caractere){
        foreach (self::listarValoresSituacaoMesa() as $sta){
            if($sta->getStrTipo() == $caractere){
                return $sta->getStrDescricao();
            }
        }
        return null;
    }

    private function validarSituacaoMesa(Mesa $objMesa, Excecao $objExcecao){
        if(self::mostrarDescricaoSituacaoMesa($objMesa->getSituacao()) == null){
            $objExcecao->adicionar_validacao("Situação informada para a mesa é inválida",null,"alert-danger");
        }
    }

    private function validarNumero(Mesa $objMesa, Excecao $objExcecao){
        if($objMesa->getNumero() != null){

            if($objMesa->getNumero() == ''){
                $objExcecao->adicionar_validacao("O número da mesa não foi informado",null,"alert-danger");
            }

            if($objMesa->getNumero() <= 0){
                $objExcecao->adicionar_validacao("O número da mesa deve ser maior que 0",null,"alert-danger");
            }

            if($objMesa->getNumero() > 9999){
                $objExcecao->adicionar_validacao("O número da mesa deve ser menor que 9999",null,"alert-danger");
            }
        }else{
            $objExcecao->adicionar_validacao("O número da mesa não foi informado",null,"alert-danger");
        }
    }

    private function validarNumeroLugares(Mesa $objMesa, Excecao $objExcecao){
        if($objMesa->getNumLugares() != null){

            if($objMesa->getNumLugares() <= 0){
                $objExcecao->adicionar_validacao("O número de lugares na mesa deve ser maior que 0",null,"alert-danger");
            }

            if($objMesa->getNumLugares() > 100){
                $objExcecao->adicionar_validacao("O número de lugares na mesa deve ser menor que 100",null,"alert-danger");
            }
        }
    }

    private function validarJaExisteNumeroMesa(Mesa $objMesa, Excecao $objExcecao){
        $objMesaRN = new MesaRN();
        $numMesas = count($objMesaRN->listar($objMesa,1) > 0);
        if($numMesas < 0){
            $objExcecao->adicionar_validacao("O número da mesa já pertence a outra mesa",null,"alert-danger");
        }

    }

    public function cadastrar(Mesa $objMesa){
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarSituacaoMesa($objMesa, $objExcecao);
            $this->validarNumero($objMesa, $objExcecao);
            $this->validarNumeroLugares($objMesa, $objExcecao);
            $this->validarJaExisteNumeroMesa($objMesa, $objExcecao);

            $objExcecao->lancar_validacoes();

            $objMesaBD = new MesaBD();
            $objMesa = $objMesaBD->cadastrar($objMesa,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objMesa;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a mesa na MesaRN.', $e);
        }
    }

    public function alterar(Mesa $objMesa) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarSituacaoMesa($objMesa, $objExcecao);
            $this->validarNumero($objMesa, $objExcecao);
            $this->validarNumeroLugares($objMesa, $objExcecao);
            $objExcecao->lancar_validacoes();

            $objMesaBD = new MesaBD();
            $objMesa  = $objMesaBD->alterar($objMesa,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objMesa;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando a mesa na MesaRN.', $e);
        }
    }

    public function consultar(Mesa $objMesa) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objMesaBD = new MesaBD();
            $arr =  $objMesaBD->consultar($objMesa,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a mesa na MesaRN.',$e);
        }
    }

    public function remover(Mesa $objMesa) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objMesaBD = new MesaBD();

            $arr =  $objMesaBD->remover($objMesa,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo a mesa na MesaRN.', $e);
        }
    }

    public function listar(Mesa $objMesa,$numLimite=null) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objMesaBD = new MesaBD();

            $arr =  $objMesaBD->listar($objMesa,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando as mesas na MesaRN.',$e);
        }
    }

}