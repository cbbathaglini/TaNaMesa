<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
class Usuario{
    private $idUsuario;
    private $CPF;
    private $senha;

    private $objPerfis;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getObjPerfis()
    {
        return $this->objPerfis;
    }

    /**
     * @param mixed $objPerfis
     */
    public function setObjPerfis($objPerfis)
    {
        $this->objPerfis = $objPerfis;
    }


    function getIdUsuario() {
        return $this->idUsuario;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return mixed
     */
    public function getCPF()
    {
        return $this->CPF;
    }

    /**
     * @param mixed $CPF
     */
    public function setCPF($CPF)
    {
        $this->CPF = $CPF;
    }


    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

}