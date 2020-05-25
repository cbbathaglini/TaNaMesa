<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Recurso{
    private $idRecurso;
    private $nome;
    private $index_recurso;
    private $s_n_menu;
    
    function __construct() {
        
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
    public function getIndexRecurso()
    {
        return $this->index_recurso;
    }

    /**
     * @param mixed $index_recurso
     */
    public function setIndexRecurso($index_recurso)
    {
        $this->index_recurso = $index_recurso;
    }

    /**
     * @return mixed
     */
    public function getSNMenu()
    {
        return $this->s_n_menu;
    }

    /**
     * @param mixed $s_n_menu
     */
    public function setSNMenu($s_n_menu)
    {
        $this->s_n_menu = $s_n_menu;
    }
    
}