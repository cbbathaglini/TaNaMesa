<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class IngredienteBD
{
    public function cadastrar(Ingrediente $objIngrediente, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_ingrediente (index_ingrediente,ingrediente) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objIngrediente->getIndexIngrediente());
            $arrayBind[] = array('s',$objIngrediente->getIngrediente());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objIngrediente->setIdIngrediente($objBanco->obterUltimoID());
            return $objIngrediente;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o ingrediente paciente no BD.",$ex);
        }

    }

    public function alterar(Ingrediente $objIngrediente, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_ingrediente SET '
                . ' index_ingrediente = ?,'
                . ' ingrediente = ?'
                . '  where idIngrediente = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objIngrediente->getIndexIngrediente());
            $arrayBind[] = array('s',$objIngrediente->getIngrediente());

            $arrayBind[] = array('i',$objIngrediente->getIdIngrediente());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objIngrediente;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o ingrediente no BD.",$ex);
        }

    }

    public function listar(Ingrediente $objIngrediente,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_ingrediente";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if($objIngrediente->getIndexIngrediente() != null){
                $WHERE .= $AND." index_ingrediente = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objIngrediente->getIndexIngrediente());
            }

            if($objIngrediente->getIngrediente() != null){
                $WHERE .= $AND." ingrediente = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objIngrediente->getIngrediente());
            }

            if($objIngrediente->getIdIngrediente() != null){
                $WHERE .= $AND." idIngrediente = ?";
                $AND = ' and ';

                $arrayBind[] = array('i',$objIngrediente->getIdIngrediente());
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


            $array_ingrediente = array();
            if(count($arr) > 0) {
                foreach ($arr as $reg) {
                    $objIngrediente = new Ingrediente();
                    $objIngrediente->setIdIngrediente($reg['idIngrediente']);
                    $objIngrediente->setIngrediente($reg['ingrediente']);
                    $objIngrediente->setIndexIngrediente($reg['index_ingrediente']);

                    $array_ingrediente[] = $objIngrediente;
                }
            }
            return $array_ingrediente;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o ingrediente no BD.",$ex);
        }

    }

    public function consultar(Ingrediente $objIngrediente, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_ingrediente WHERE idIngrediente = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objIngrediente->getIdIngrediente());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $ingrediente = new Ingrediente();
            $ingrediente->setIdIngrediente($arr[0]['idIngrediente']);
            $ingrediente->setIngrediente($arr[0]['ingrediente']);
            $ingrediente->setIndexIngrediente($arr[0]['index_ingrediente']);

            return $ingrediente;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o ingrediente no BD.",$ex);
        }

    }

    public function remover(Ingrediente $objIngrediente, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_ingrediente WHERE idIngrediente = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objIngrediente->getIdIngrediente());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o ingrediente no BD.",$ex);
        }
    }
}