<?php


class Historico
{
    private $dataHistorico;
    private $idMesa;
    private $objProdutos;

    /**
     * @return mixed
     */
    public function getDataHistorico()
    {
        return $this->dataHistorico;
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
     * @param mixed $dataHistorico
     */
    public function setDataHistorico($dataHistorico)
    {
        $this->dataHistorico = $dataHistorico;
    }

    /**
     * @return mixed
     */
    public function getObjProdutos()
    {
        return $this->objProdutos;
    }

    /**
     * @param mixed $objProdutos
     */
    public function setObjProdutos($objProdutos)
    {
        $this->objProdutos = $objProdutos;
    }




}