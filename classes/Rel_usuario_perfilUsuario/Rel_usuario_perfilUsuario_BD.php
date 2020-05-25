<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class Rel_usuario_perfilUsuario_BD{
    
     

    public function cadastrar(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {
        try{
           
            $INSERT = 'INSERT INTO tb_usuario_has_tb_perfil_usuario (idPerfilUsuario,idUsuario) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdPerfilUsuario());
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdUsuario());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRel_usuario_perfilUsuario->setIdRelUsuarioPerfilUsuario($objBanco->obterUltimoID());
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o relacionamento do usuário com o seu perfil no BD.",$ex);
        }
        
    }
    
    public function alterar(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_usuario_has_tb_perfil_usuario SET '
                    . ' idPerfilUsuario = ?,'
                    . ' idUsuario = ?'
                . '  where idUsuarioPerfilUsuario = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdPerfilUsuario());
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdUsuario());
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdRelUsuarioPerfilUsuario());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterandoo o relacionamento do usuário com o seu perfil no BD.",$ex);
        }
       
    }
    
     public function listar(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario,$numLimite=null, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_usuario_has_tb_perfil_usuario";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if($objRel_usuario_perfilUsuario->getIdUsuario() != null){
                $WHERE .= $AND." idUsuario = ?";
                $AND = ' and '; 
                $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdUsuario());
            }

             if($objRel_usuario_perfilUsuario->getIdPerfilUsuario() != null){
                 $WHERE .= $AND." idPerfilUsuario = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdPerfilUsuario());
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
            foreach ($arr as $reg){
                $objRel_usuario_perfilUsuario = new Rel_usuario_perfilUsuario();
                $objRel_usuario_perfilUsuario->setIdRelUsuarioPerfilUsuario($reg['idUsuarioPerfilUsuario']);
                $objRel_usuario_perfilUsuario->setIdPerfilUsuario($reg['idPerfilUsuario']);
                $objRel_usuario_perfilUsuario->setIdUsuario($reg['idUsuario']);

                $array_usuario[] = $objRel_usuario_perfilUsuario;
            }
            return $array_usuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento do usuário com o seu perfil no BD.",$ex);
        }
       
    }
    
    public function consultar(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idUsuarioPerfilUsuario,idPerfilUsuario,idUsuario FROM tb_usuario_has_tb_perfil_usuario WHERE idUsuarioPerfilUsuario = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdRelUsuarioPerfilUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $usuario_perfil = new Rel_usuario_perfilUsuario();
            $usuario_perfil->setIdRelUsuarioPerfilUsuario($arr[0]['idUsuarioPerfilUsuario']);
            $usuario_perfil->setIdPerfilUsuario($arr[0]['idPerfilUsuario']);
            $usuario_perfil->setIdUsuario($arr[0]['idUsuario']);

            return $usuario_perfil;
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando o relacionamento do usuário com o seu perfil no BD.",$ex);
        }

    }
    
    public function remover(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_usuario_has_tb_perfil_usuario WHERE idUsuario = ? AND idPerfilUsuario = ?';
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdUsuario());
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdPerfilUsuario());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento do usuário com o seu perfil no BD.",$ex);
        }
    }


    public function listar_usuario_com_perfil(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {
        try{

            $SELECT_USUARIOS = "SELECT * FROM tb_usuario";
            $arr_usuarios = $objBanco->consultarSQL($SELECT_USUARIOS,null);

            foreach ($arr_usuarios as $usuario){
                $SELECT = "SELECT * FROM tb_usuario_has_tb_perfil_usuario,tb_usuario,tb_perfil_usuario
                        where tb_usuario_has_tb_perfil_usuario.idUsuario = tb_usuario.idUsuario
                        and tb_usuario_has_tb_perfil_usuario.idPerfilUsuario = tb_perfil_usuario.idPerfilUsuario                                         
                        and tb_usuario.idUsuario = ?
                        ";
                $arrayBind = array();
                $arrayBind[] = array('i',$usuario['idUsuario']);
                $arr_perfis = $objBanco->consultarSQL($SELECT,$arrayBind);

                $objUsuario = new Usuario();
                $objUsuario->setIdUsuario($usuario['idUsuario']);
                $objUsuario->setCPF($usuario['CPF']);
                $objUsuario->setSenha($usuario['senha']);

                $arr_perfis_usuario = array();
                foreach ($arr_perfis as $perfil) {
                    $perfilUsu = new PerfilUsuario();
                    $perfilUsu->setIdPerfilUsuario($perfil['idPerfilUsuario']);
                    $perfilUsu->setPerfil($perfil['perfil']);
                    $perfilUsu->setIndex_perfil($perfil['index_perfil']);
                    $arr_perfis_usuario[] = $perfilUsu;
                }

                $objUsuario->setObjPerfis($arr_perfis_usuario);
                $array_usuario[] = $objUsuario;

            }

            return $array_usuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento do usuário com o seu perfil no BD.",$ex);
        }

    }
   

}
