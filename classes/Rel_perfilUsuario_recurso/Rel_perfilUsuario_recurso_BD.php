<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class Rel_perfilUsuario_recurso_BD{
    

    public function cadastrar(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {
        try{
           
            $INSERT = 'INSERT INTO tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdPerfilUsuario());
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRecurso());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRel_perfilUsuario_recurso->setIdRelPerfilUsuarioRecurso($objBanco->obterUltimoID());
            return $objRel_perfilUsuario_recurso;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrandoo o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }
        
    }
    
    public function alterar(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_perfil_usuario_has_tb_recurso SET '
                    . ' idPerfilUsuario = ?,'
                    . ' idRecurso = ?'
                . '  where idPerfilUsuarioRecurso = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdPerfilUsuario());
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRecurso());
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRel_perfilUsuario_recurso());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objRel_perfilUsuario_recurso;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterandoo o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }
       
    }
    
     public function listar(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, $numLimite=null,Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_perfil_usuario_has_tb_recurso";

             $WHERE = '';
             $AND = '';
             $arrayBind = array();
             if($objRel_perfilUsuario_recurso->getIdRecurso() != null){
                 $WHERE .= $AND." idRecurso = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRecurso());
             }

             if($objRel_perfilUsuario_recurso->getIdPerfilUsuario() != null){
                 $WHERE .= $AND." idPerfilUsuario = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdPerfilUsuario());
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
                $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
                $objRel_perfilUsuario_recurso->setIdRelPerfilUsuarioRecurso($reg['idPerfilUsuarioRecurso']);
                $objRel_perfilUsuario_recurso->setIdPerfilUsuario($reg['idPerfilUsuario']);
                $objRel_perfilUsuario_recurso->setIdRecurso($reg['idRecurso']);

                $array_usuario[] = $objRel_perfilUsuario_recurso;
            }
            return $array_usuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }
       
    }
    
    public function listar_recursos(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT DISTINCT * FROM tb_perfil_usuario_has_tb_recurso WHERE idPerfilUsuario = ?";

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdPerfilUsuario());
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $array_usuario = array();
            foreach ($arr as $reg){
                $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
                $objRel_perfilUsuario_recurso->setIdRelPerfilUsuarioRecurso($reg['idPerfilUsuarioRecurso']);
                $objRel_perfilUsuario_recurso->setIdPerfilUsuario($reg['idPerfilUsuario']);
                $objRel_perfilUsuario_recurso->setIdRecurso($reg['idRecurso']);

                $array_usuario[] = $objRel_perfilUsuario_recurso;
            }
            return $array_usuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }
       
    }
    
    public function consultar(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idPerfilUsuarioRecurso,idPerfilUsuario,idRecurso FROM tb_perfil_usuario_has_tb_recurso WHERE idPerfilUsuarioRecurso = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getId_rel_usuario_perfilUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $perfilUsu_recurso= new Rel_perfilUsuario_recurso();
            $perfilUsu_recurso->setIdRelPerfilUsuarioRecurso($arr[0]['idPerfilUsuarioRecurso']);
            $perfilUsu_recurso->setIdPerfilUsuario($arr[0]['idPerfilUsuario']);
            $perfilUsu_recurso->setIdRecurso($arr[0]['idRecurso']);

            return $perfilUsu_recurso;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultandoo o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }

    }
    
    public function remover(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) { 

        try{
            
            $DELETE = 'DELETE FROM tb_perfil_usuario_has_tb_recurso WHERE idPerfilUsuario = ?  AND idRecurso = ?';
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdPerfilUsuario());
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRecurso());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }
    }
    
    
    
    
    public function validar_cadastro(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_perfil_usuario_has_tb_recurso WHERE idPerfilUsuario = ? AND idRecurso = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdPerfilUsuario());
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRecurso());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            
            $array = array();
            foreach ($arr as $reg){
                $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
                $objRel_perfilUsuario_recurso->setIdRelPerfilUsuarioRecurso($reg['idPerfilUsuarioRecurso']);
                $objRel_perfilUsuario_recurso->setIdPerfilUsuario($reg['idPerfilUsuario']);
                $objRel_perfilUsuario_recurso->setIdRecurso($reg['idRecurso']);

                $array[] = $objRel_perfilUsuario_recurso;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o relacionamento do usuário com o seu perfil no BD.",$ex);
        }

    }
    
    
   
}
