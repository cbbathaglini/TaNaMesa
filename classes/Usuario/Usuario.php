<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
class Usuario{
    private $idUsuario;
    private $nome;
    private $CPF;
    private $senha;

    private $lista_perfis;
    private $lista_recursos;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getListaPerfis()
    {
        return $this->lista_perfis;
    }

    /**
     * @param mixed $lista_perfis
     */
    public function setListaPerfis($lista_perfis): void
    {
        $this->lista_perfis = $lista_perfis;
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
    public function setNome($nome): void
    {
        $this->nome = $nome;
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