<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class CategoriaProduto
{
    private $idCategoriaProduto;
    private $descricao;
    private $caractere;

    /**
     * @return mixed
     */
    public function getIdCategoriaProduto()
    {
        return $this->idCategoriaProduto;
    }

    /**
     * @param mixed $idCategoriaProduto
     */
    public function setIdCategoriaProduto($idCategoriaProduto)
    {
        $this->idCategoriaProduto = $idCategoriaProduto;
    }

    /**
     * @return mixed
     */
    public function getCaractere()
    {
        return $this->caractere;
    }

    /**
     * @param mixed $caractere
     */
    public function setCaractere($caractere)
    {
        $this->caractere = $caractere;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }




}