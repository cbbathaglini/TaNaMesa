<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */


class PerfilUsuario{
    private $idPerfilUsuario;
    private $perfil;
    private $index_perfil;
    private $lista_recursos;
    
    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getListaRecursos()
    {
        return $this->lista_recursos;
    }

    /**
     * @param mixed $lista_recursos
     */
    public function setListaRecursos($lista_recursos): void
    {
        $this->lista_recursos = $lista_recursos;
    }


    function getIdPerfilUsuario() {
        return $this->idPerfilUsuario;
    }

    function getPerfil() {
        return $this->perfil;
    }

    function getIndex_perfil() {
        return $this->index_perfil;
    }

    function setIdPerfilUsuario($idPerfilUsuario) {
        $this->idPerfilUsuario = $idPerfilUsuario;
    }

    function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    function setIndex_perfil($index_perfil) {
        $this->index_perfil = $index_perfil;
    }


}