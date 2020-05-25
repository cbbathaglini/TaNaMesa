<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
class Rel_usuario_perfilUsuario{
    private $idRelUsuarioPerfilUsuario;
    private $idUsuario;
    private $idPerfilUsuario;

    private $objsRelacionamentos;
    
    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getObjsRelacionamentos()
    {
        return $this->objsRelacionamentos;
    }

    /**
     * @param mixed $objsRelacionamentos
     */
    public function setObjsRelacionamentos($objsRelacionamentos)
    {
        $this->objsRelacionamentos = $objsRelacionamentos;
    }



    /**
     * @return mixed
     */
    public function getIdRelUsuarioPerfilUsuario()
    {
        return $this->idRelUsuarioPerfilUsuario;
    }

    /**
     * @param mixed $idRelUsuarioPerfilUsuario
     */
    public function setIdRelUsuarioPerfilUsuario($idRelUsuarioPerfilUsuario)
    {
        $this->idRelUsuarioPerfilUsuario = $idRelUsuarioPerfilUsuario;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return mixed
     */
    public function getIdPerfilUsuario()
    {
        return $this->idPerfilUsuario;
    }

    /**
     * @param mixed $idPerfilUsuario
     */
    public function setIdPerfilUsuario($idPerfilUsuario)
    {
        $this->idPerfilUsuario = $idPerfilUsuario;
    }


}