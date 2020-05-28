<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Ingrediente
{
    private $idIngrediente;
    private $ingrediente;
    private $index_ingrediente;

    /**
     * @return mixed
     */
    public function getIdIngrediente()
    {
        return $this->idIngrediente;
    }

    /**
     * @param mixed $idIngrediente
     */
    public function setIdIngrediente($idIngrediente)
    {
        $this->idIngrediente = $idIngrediente;
    }

    /**
     * @return mixed
     */
    public function getIngrediente()
    {
        return $this->ingrediente;
    }

    /**
     * @param mixed $ingrediente
     */
    public function setIngrediente($ingrediente)
    {
        $this->ingrediente = $ingrediente;
    }

    /**
     * @return mixed
     */
    public function getIndexIngrediente()
    {
        return $this->index_ingrediente;
    }

    /**
     * @param mixed $index_ingrediente
     */
    public function setIndexIngrediente($index_ingrediente)
    {
        $this->index_ingrediente = $index_ingrediente;
    }


}