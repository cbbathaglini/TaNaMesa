<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class UsuarioSQL
{
    /*public function listar(Usuario $objUsuario){
       try {
           $arr = [];

           $query = $this->db->collection($this->name);
           //foreach ($arr_datas as $data){
           $query = $query->where('cpf','=', $arr_datas['cpf']);
           $query = $query->where('senha','=', $arr_datas['senha']);
           $query = $query->documents()->rows();

           if(!empty($query)){
               foreach ($query as $item){
                   $arr[]= $item->data();
               }
           }

           return $arr;
       }catch (Throwable $e){
           die('aq');
       }
   }*/

    public function cadastrar(Usuario $objUsuario, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_usuario (CPF,senha) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objUsuario->getCPF());
            $arrayBind[] = array('s',$objUsuario->getSenha());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objUsuario->setIdUsuario($objBanco->obterUltimoID());
            return $objUsuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando usuário no UsuarioBD.",$ex);
        }

    }

    public function alterar(Usuario $objUsuario, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_usuario SET '
                . ' CPF = ?,'
                . ' senha = ?'
                . '  where idUsuario = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objUsuario->getCPF());
            $arrayBind[] = array('s',$objUsuario->getSenha());
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objUsuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando usuário no UsuarioBD.",$ex);
        }

    }

    public function listar(Usuario $objUsuario,$numLimite = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_usuario";
            $WHERE = '';
            $AND = '';

            $arrayBind = array();
            if($objUsuario->getCPF() != null){
                $WHERE .= $AND." CPF = ?";
                $AND = ' and ';

                $arrayBind[] = array('s',$objUsuario->getCPF());
            }

            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }

            $LIMIT = '';
            if($numLimite != null){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
            }

            $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT,$arrayBind);

            $array_usuario = array();
            if(count($arr) > 0) {
                foreach ($arr as $reg) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($reg['idUsuario']);
                    $objUsuario->setCPF($reg['CPF']);
                    $objUsuario->setSenha($reg['senha']);

                    $array_usuario[] = $objUsuario;
                }
            }

            return $array_usuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando usuário no UsuarioBD.",$ex);
        }

    }

    public function consultar(Usuario $objUsuario, Banco $objBanco) {

        try{
            $SELECT = 'SELECT * FROM tb_usuario WHERE idUsuario = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            //print_r($arr);
            $usuario = new Usuario();
            $usuario->setIdUsuario($arr[0]['idUsuario']);
            $usuario->setCPF($arr[0]['CPF']);
            $usuario->setSenha($arr[0]['senha']);

            return $usuario;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando usuário no UsuarioBD.",$ex);
        }

    }

    public function remover(Usuario $objUsuario, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_usuario WHERE idUsuario = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo usuário no UsuarioBD.",$ex);
        }
    }


    public function validar_cadastro(Usuario $objUsuario, Firestore $objBanco) {

        try{


            die();
            $SELECT = 'SELECT idUsuario,CPF,senha FROM tb_usuario WHERE CPF = ? AND senha = ? ';

            $arrayBind = array();
            $arrayBind[] = array('s',$objUsuario->getCPF());
            $arrayBind[] = array('s',$objUsuario->getSenha());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $array_usuario = array();
            foreach ($arr as $reg){
                $objUsuario = new Usuario();
                $objUsuario->setIdUsuario($reg['idUsuario']);
                $objUsuario->setCPF($reg['CPF']);
                $objUsuario->setSenha($reg['senha']);

                $array_usuario[] = $objUsuario;
            }
            return $array_usuario;


        } catch (Throwable $ex) {

            throw new Excecao("Erro validando cadastro do usuário no UsuarioBD.",$ex);
        }

    }
}