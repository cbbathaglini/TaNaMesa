<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
class Rel_perfilUsuario_recurso{
    private $id_rel_perfilUsuario_recurso;
    private $idPerfilUsuario;
    private $idRecurso;
    
    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getIdRelPerfilUsuarioRecurso()
    {
        return $this->id_rel_perfilUsuario_recurso;
    }

    /**
     * @param mixed $id_rel_perfilUsuario_recurso
     */
    public function setIdRelPerfilUsuarioRecurso($id_rel_perfilUsuario_recurso)
    {
        $this->id_rel_perfilUsuario_recurso = $id_rel_perfilUsuario_recurso;
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

    /**
     * @return mixed
     */
    public function getIdRecurso()
    {
        return $this->idRecurso;
    }

    /**
     * @param mixed $idRecurso
     */
    public function setIdRecurso($idRecurso)
    {
        $this->idRecurso = $idRecurso;
    }


}