<?php
require_once __DIR__.'/../../classes/Banco/BancoFirebase.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class UsuarioBD {
    protected $database;
    protected $dbname = 'app';
    protected $child = 'users';

    public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
        $firebase = (new Factory)->withServiceAccount($acc)->createDatabase();
        $this->database = $firebase;
    }
    public function consultar(Usuario $objUsuario){
        try {

            $filho = $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objUsuario->getIdUsuario())->getValue();
            if(!is_null($filho)) {
                $usuario = new Usuario();
                $usuario->setidUsuario($filho['idUsuario']);
                $usuario->setSenha($filho['senha']);
                $usuario->setCPF($filho['CPF']);
                $usuario->setNome($filho['nome']);
                $usuario->setListaPerfis($filho['lista_perfis']);

                return $usuario;
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os usuários no BD.", $ex);
        }

    }
    public function alterar(Usuario $objUsuario){
        try {

            $arr =  array( 'idUsuario' => $objUsuario->getIdUsuario(),
                'CPF' =>  $objUsuario->getCPF(),
                'senha' =>  $objUsuario->getSenha(),
                'nome' =>  $objUsuario->getNome(),
                'lista_perfis' =>  $objUsuario->getListaPerfis());


            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objUsuario->getIdUsuario())->set($arr);

            return $objUsuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando os usuários no BD.", $ex);
        }

    }
    public function cadastrar(Usuario $objUsuario) {
        try {
            if (empty($objUsuario) || !isset($objUsuario)) { return FALSE; }

            $ultimoId = $this->getLastId();
            $objUsuario->setidUsuario($ultimoId+1);
            $arr =  array( 'idUsuario' => $objUsuario->getIdUsuario(),
                'CPF' =>  $objUsuario->getCPF(),
                'senha' =>  $objUsuario->getSenha(),
                'nome' =>  $objUsuario->getNome(),
                'lista_perfis' =>  $objUsuario->getListaPerfis());

            $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objUsuario->getIdUsuario())->set($arr);

            return $objUsuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando os usuários no BD.", $ex);
        }
    }
    public function listar(Usuario $objUsuario)
    {
        try {
            if (empty($objUsuario) || !isset($objUsuario)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();

            $arrUsuarios = array();
            foreach ($arr as $id) {
                if (!is_null($id)) {
                    $usuario = new Usuario();
                    $usuario->setidUsuario($id['idUsuario']);
                    $usuario->setSenha($id['senha']);
                    $usuario->setCPF($id['CPF']);
                    $usuario->setNome($id['nome']);
                    $usuario->setListaPerfis($id['lista_perfis']);


                    $arrUsuarios[] = $usuario;
                }
            }
            return $arrUsuarios;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os usuários no BD.", $ex);
        }
    }

    public function logar(Usuario $objUsuario)
    {
        try {
            if (empty($objUsuario) || !isset($objUsuario)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();

            $arrUsuarios = array();
            foreach ($arr as $id) {
                if (!is_null($id)) {

                    if( ($objUsuario->getCPF() != null && $objUsuario->getCPF() ==$id['CPF'] )
                        && ($objUsuario->getSenha() != null && $objUsuario->getSenha() ==$id['senha']) ){

                        $usuario = new Usuario();
                        $usuario->setidUsuario($id['idUsuario']);
                        $usuario->setSenha($id['senha']);
                        $usuario->setCPF($id['CPF']);
                        $usuario->setNome($id['nome']);
                        $usuario->setListaPerfis($id['lista_perfis']);
                        return  $usuario;
                    }
                }
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os usuários no BD.", $ex);
        }
    }

    public function procurar(Usuario $objUsuario)
    {
        try {
            if (empty($objUsuario) || !isset($objUsuario)) {
                return FALSE;
            }

            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();

            $arrUsuarios = array();
            foreach ($arr as $id) {
                if (!is_null($id)) {
                    $usuario = new Usuario();
                    $usuario->setidUsuario($id['idUsuario']);
                    $usuario->setSenha($id['senha']);
                    $usuario->setCPF($id['CPF']);
                    $usuario->setNome($id['nome']);
                    $usuario->setListaPerfis($id['lista_perfis']);

                    if($objUsuario->getNome() != null && $objUsuario->getNome() ==$id['nome'] ){
                        $usuario->setNome($id['nome']);
                    }

                    if($objUsuario->getIdUsuario() != null && $objUsuario->getIdUsuario() ==$id['idUsuario'] ){
                        $usuario->setidUsuario($id['idUsuario']);
                    }

                    if($objUsuario->getCPF() != null && $objUsuario->getCPF() ==$id['CPF'] ){
                        $usuario->setCPF($id['CPF']);
                    }

                    if($objUsuario->getSenha() != null && $objUsuario->getSenha() ==$id['senha'] ){
                        $usuario->setSenha($id['senha']);
                    }


                    $arrUsuarios[] = $usuario;
                }
            }
            return $arrUsuarios;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os usuários no BD.", $ex);
        }
    }
    public function getLastId() {
        try {
            $arr = $this->database->getReference($this->dbname)->getChild($this->child)->getValue();
            $maior = -1;

            foreach ($arr as $id){
                if($maior < $id['idUsuario']){
                    $maior = $id['idUsuario'];
                }
            }
            return $maior;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pegando o último id dos usuários no BD.", $ex);
        }
    }
    public function remover(Usuario $objUsuario) {
        try{
            if (empty($objUsuario) || !isset($objUsuario)) { return FALSE; }
            if ($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objUsuario->getIdUsuario())){
                //print_r($this->database->getReference($this->dbname)->getChild($this->child)->getChild($objPrato->getIdPrato())->getValue());
                $this->database->getReference($this->dbname)->getChild($this->child)->getChild($objUsuario->getIdUsuario())->remove();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o usuário no BD.", $ex);
        }
    }
}
?>