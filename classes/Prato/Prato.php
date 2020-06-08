<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Prato
{
    private $idPrato;
    private $categoriaPrato;
    private $preco;
    private $nome;
    private $index_nome;
    private $lista_ingredientes;
    private $informacoes;

    /**
     * @return mixed
     */
    public function getListaIngredientes()
    {
        return $this->lista_ingredientes;
    }

    /**
     * @param mixed $lista_ingredientes
     */
    public function setListaIngredientes($lista_ingredientes): void
    {
        $this->lista_ingredientes = $lista_ingredientes;
    }


    /**
     * @return mixed
     */
    public function getIdPrato()
    {
        return $this->idPrato;
    }

    /**
     * @param mixed $idPrato
     */
    public function setIdPrato($idPrato)
    {
        $this->idPrato = $idPrato;
    }

    /**
     * @return mixed
     */
    public function getCategoriaPrato()
    {
        return $this->categoriaPrato;
    }

    /**
     * @param mixed $categoriaPrato
     */
    public function setCategoriaPrato($categoriaPrato)
    {
        $this->categoriaPrato = $categoriaPrato;
    }



    /**
     * @return mixed
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * @param mixed $preco
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getIndexNome()
    {
        return $this->index_nome;
    }

    /**
     * @param mixed $index_nome
     */
    public function setIndexNome($index_nome)
    {
        $this->index_nome = $index_nome;
    }

    /**
     * @return mixed
     */
    public function getInformacoes()
    {
        return $this->informacoes;
    }

    /**
     * @param mixed $informacoes
     */
    public function setInformacoes($informacoes)
    {
        $this->informacoes = $informacoes;
    }


}