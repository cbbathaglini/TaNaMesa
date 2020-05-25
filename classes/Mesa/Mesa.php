<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Mesa
{
    private $idMesa;
    private $numero;
    private $situacao;
    private $numLugares;

    /**
     * Mesa constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getNumLugares()
    {
        return $this->numLugares;
    }

    /**
     * @param mixed $numLugares
     */
    public function setNumLugares($numLugares)
    {
        $this->numLugares = $numLugares;
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
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param mixed $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }


}