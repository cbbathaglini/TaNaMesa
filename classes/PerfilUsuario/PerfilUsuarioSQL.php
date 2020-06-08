<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class PerfilUsuarioSQL{

    public function cadastrar(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_perfil_usuario (perfil,index_perfil) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilUsuario->getPerfil());
            $arrayBind[] = array('s',$objPerfilUsuario->getIndex_perfil());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPerfilUsuario->setIdPerfilUsuario($objBanco->obterUltimoID());
            return $objPerfilUsuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando perfil do usuário no BD.",$ex);
        }

    }

    public function alterar(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_perfil_usuario SET '
                . ' perfil = ?,'
                . ' index_perfil = ?'
                . '  where idPerfilUsuario = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilUsuario->getPerfil());
            $arrayBind[] = array('s',$objPerfilUsuario->getIndex_perfil());
            $arrayBind[] = array('i',$objPerfilUsuario->getIdPerfilUsuario());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objPerfilUsuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando perfil do usuário no BD.",$ex);
        }

    }

    public function listar(PerfilUsuario $objPerfilUsuario,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_perfil_usuario";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if($objPerfilUsuario->getIndex_perfil() != null){
                $WHERE .= $AND." index_perfil = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objPerfilUsuario->getIndex_perfil());
            }

            if($objPerfilUsuario->getPerfil() != null){
                $WHERE .= $AND." perfil = ?";
                $AND = ' and ';

                $arrayBind[] = array('s',$objPerfilUsuario->getPerfil());
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

            $array_perfilUsu = array();
            if(count($arr) > 0) {
                foreach ($arr as $reg) {
                    $objPerfilUsuario = new PerfilUsuario();
                    $objPerfilUsuario->setIdPerfilUsuario($reg['idPerfilUsuario']);
                    $objPerfilUsuario->setPerfil($reg['perfil']);
                    $objPerfilUsuario->setIndex_perfil($reg['index_perfil']);

                    $array_perfilUsu[] = $objPerfilUsuario;
                }
            }

            return $array_perfilUsu;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando perfil do usuário no BD.",$ex);
        }

    }

    public function consultar(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idPerfilUsuario,perfil,index_perfil FROM tb_perfil_usuario WHERE idPerfilUsuario = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPerfilUsuario->getIdPerfilUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $perfilUsu = new PerfilUsuario();
            $perfilUsu->setIdPerfilUsuario($arr[0]['idPerfilUsuario']);
            $perfilUsu->setPerfil($arr[0]['perfil']);
            $perfilUsu->setIndex_perfil($arr[0]['index_perfil']);

            return $perfilUsu;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando perfil do usuário no BD.",$ex);
        }

    }

    public function remover(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_perfil_usuario WHERE idPerfilUsuario = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPerfilUsuario->getIdPerfilUsuario());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo perfil do usuário no BD.",$ex);
        }
    }


    public function pesquisar_index(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * from tb_perfil_usuario WHERE index_perfil = ?';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilUsuario->getIndex_perfil());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(empty($arr)){
                return $arr;
            }
            $arr_perfis_usuario = array();

            foreach ($arr as $reg){
                $objPerfilUsuario = new PerfilUsuario();
                $objPerfilUsuario->setIdPerfilUsuario($reg['idPerfilUsuario']);
                $objPerfilUsuario->setPerfil($reg['perfil']);
                $objPerfilUsuario->setIndex_perfil($reg['index_perfil']);
                $arr_perfis_usuario[] = $objPerfilUsuario;
            }
            return $arr_perfis_usuario;

        } catch (Throwable $ex) {
            throw new Excecao("Erro pesquisando o perfil do usuário no BD.",$ex);
        }
    }


    public function existe_usuario_com_perfil(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {
        try{

            $SELECT = "SELECT tb_perfil_usuario.idPerfilUsuario FROM tb_perfil_usuario,tb_usuario_has_tb_perfil_usuario
                        where tb_perfil_usuario.idPerfilUsuario = tb_usuario_has_tb_perfil_usuario.idPerfilUsuario_fk 
                        and tb_perfil_usuario.idPerfilUsuario = ?
                        LIMIT 1";

            $arrayBind = array();
            $arrayBind[] = array('i',$objPerfilUsuario->getIdPerfilUsuario());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0){
                return true;
            }
            return false;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando perfil do usuário no BD.",$ex);
        }

    }




}
