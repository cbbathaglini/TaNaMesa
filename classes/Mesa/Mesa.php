<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Mesa
{
    private $idMesa;
    private $disponivel;
    private $idFuncionario;
    private $boolPrecisaFunc;
    private $totalPedido;
    private $lista_produtos;
    private $esperandoPedido;
    private $idPedido;

    /**
     * Mesa constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getIdPedido()
    {
        return $this->idPedido;
    }

    /**
     * @param mixed $idPedido
     */
    public function setIdPedido($idPedido)
    {
        $this->idPedido = $idPedido;
    }




    /**
     * @return mixed
     */
    public function getIdMesa()
    {
        return $this->idMesa;
    }

    /**
     * @param mixed $idMesa
     */
    public function setIdMesa($idMesa)
    {
        $this->idMesa = $idMesa;
    }

    /**
     * @return mixed
     */
    public function getDisponivel()
    {
        return $this->disponivel;
    }

    /**
     * @param mixed $disponivel
     */
    public function setDisponivel($disponivel)
    {
        $this->disponivel = $disponivel;
    }

    /**
     * @return mixed
     */
    public function getIdFuncionario()
    {
        return $this->idFuncionario;
    }

    /**
     * @param mixed $idFuncionario
     */
    public function setIdFuncionario($idFuncionario)
    {
        $this->idFuncionario = $idFuncionario;
    }

    /**
     * @return mixed
     */
    public function getBoolPrecisaFunc()
    {
        return $this->boolPrecisaFunc;
    }

    /**
     * @param mixed $boolPrecisaFunc
     */
    public function setBoolPrecisaFunc($boolPrecisaFunc)
    {
        $this->boolPrecisaFunc = $boolPrecisaFunc;
    }

    /**
     * @return mixed
     */
    public function getTotalPedido()
    {
        return $this->totalPedido;
    }

    /**
     * @param mixed $totalPedido
     */
    public function setTotalPedido($totalPedido)
    {
        $this->totalPedido = $totalPedido;
    }

    /**
     * @return mixed
     */
    public function getListaProdutos()
    {
        return $this->lista_produtos;
    }

    /**
     * @param mixed $lista_produtos
     */
    public function setListaProdutos($lista_produtos)
    {
        $this->lista_produtos = $lista_produtos;
    }

    /**
     * @return mixed
     */
    public function getEsperandoPedido()
    {
        return $this->esperandoPedido;
    }

    /**
     * @param mixed $esperandoPedido
     */
    public function setEsperandoPedido($esperandoPedido)
    {
        $this->esperandoPedido = $esperandoPedido;
    }



}