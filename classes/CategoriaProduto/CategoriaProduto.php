<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class CategoriaProduto
{
    private $idCategoriaProduto;
    private $strDescricao;
    private $caractere;
    private $strCategoria;
    private $strCategoriaEnglish;
    private $strURLImagem;

    /**
     * @return mixed
     */
    public function getStrCategoriaEnglish()
    {
        return $this->strCategoriaEnglish;
    }

    /**
     * @param mixed $strCategoriaEnglish
     */
    public function setStrCategoriaEnglish($strCategoriaEnglish)
    {
        $this->strCategoriaEnglish = $strCategoriaEnglish;
    }



    /**
     * @return mixed
     */
    public function getStrDescricao()
    {
        return $this->strDescricao;
    }

    /**
     * @param mixed $strDescricao
     */
    public function setStrDescricao($strDescricao)
    {
        $this->strDescricao = $strDescricao;
    }

    /**
     * @return mixed
     */
    public function getStrCategoria()
    {
        return $this->strCategoria;
    }

    /**
     * @param mixed $strCategoria
     */
    public function setStrCategoria($strCategoria)
    {
        $this->strCategoria = $strCategoria;
    }

    /**
     * @return mixed
     */
    public function getStrURLImagem()
    {
        return $this->strURLImagem;
    }

    /**
     * @param mixed $strURLImagem
     */
    public function setStrURLImagem($strURLImagem)
    {
        $this->strURLImagem = $strURLImagem;
    }



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