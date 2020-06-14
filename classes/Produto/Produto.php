<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Produto
{
    private $idProduto;
    private $caminho_img_sistWEB;
    private $categoriaProduto;
    private $preco;
    private $nome;
    private $index_nome;

    private $lista_ingredientes;
    private $informacoes;

    /**
     * @return mixed
     */
    public function getCaminhoImgSistWEB()
    {
        return $this->caminho_img_sistWEB;
    }

    /**
     * @param mixed $caminho_img_sistWEB
     */
    public function setCaminhoImgSistWEB($caminho_img_sistWEB)
    {
        $this->caminho_img_sistWEB = $caminho_img_sistWEB;
    }




    /**
     * @return mixed
     */
    public function getListaIngredientes()
    {
        return $this->lista_ingredientes;
    }

    /**
     * @return mixed
     */
    public function getIdProduto()
    {
        return $this->idProduto;
    }

    /**
     * @param mixed $idProduto
     */
    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;
    }

    /**
     * @return mixed
     */
    public function getCategoriaProduto()
    {
        return $this->categoriaProduto;
    }

    /**
     * @param mixed $categoriaProduto
     */
    public function setCategoriaProduto($categoriaProduto)
    {
        $this->categoriaProduto = $categoriaProduto;
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