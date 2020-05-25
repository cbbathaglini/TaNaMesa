<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe do banco da mesa
 */
require_once __DIR__ . '/../Banco/Banco.php';

require_once __DIR__ .'/../Situacao/Situacao.php';

class MesaBD
{
    public function cadastrar(Mesa $objMesa, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_mesa (situacao,numero, numLugares) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objMesa->getSituacao());
            $arrayBind[] = array('i',$objMesa->getNumero());
            $arrayBind[] = array('i',$objMesa->getNumLugares());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objMesa->setIdMesa($objBanco->obterUltimoID());
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando mesa em MesaBD.",$ex);
        }

    }

    public function alterar(Mesa $objMesa, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_mesa SET '
                . ' situacao = ?,'
                . ' numero = ?,'
                . ' numLugares = ?'
                . '  where idMesa = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objMesa->getSituacao());
            $arrayBind[] = array('i',$objMesa->getNumero());
            $arrayBind[] = array('i',$objMesa->getNumLugares());

            $arrayBind[] = array('i',$objMesa->getIdMesa());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objMesa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando mesa em MesaBD.",$ex);
        }

    }

    public function listar(Mesa $objMesa,$numLimite = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_mesa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if($objMesa->getNumLugares() != null){
                $WHERE .= $AND." numLugares = ?";
                $AND = ' and ';

                $arrayBind[] = array('i',$objMesa->getNumLugares());
            }

            if($objMesa->getNumero() != null){
                $WHERE .= $AND." numero = ?";
                $AND = ' and ';

                $arrayBind[] = array('i',$objMesa->getNumero());
            }

            if($objMesa->getSituacao() != null){
                $WHERE .= $AND." situacao = ?";
                $AND = ' and ';

                $arrayBind[] = array('s',$objMesa->getSituacao());
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

            $array_mesas = array();
            if(count($arr) > 0) {
                foreach ($arr as $reg) {
                    $mesa = new Mesa();
                    $mesa->setIdMesa($reg['idMesa']);
                    $mesa->setSituacao($reg['situacao']);
                    $mesa->setNumLugares($reg['numLugares']);
                    $mesa->setNumero($reg['numero']);

                    $array_mesas[] = $mesa;
                }
            }
            return $array_mesas;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando mesa em MesaBD.",$ex);
        }

    }

    public function consultar(Mesa $objMesa, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_mesa WHERE idMesa = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objMesa->getIdMesa());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            if(count($arr) > 0) {
                $mesa = new Mesa();
                $mesa->setIdMesa($arr[0]['idMesa']);
                $mesa->setSituacao($arr[0]['situacao']);
                $mesa->setNumLugares($arr[0]['numLugares']);
                $mesa->setNumero($arr[0]['numero']);
            }

            return $mesa;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando mesa em MesaBD.",$ex);
        }

    }

    public function remover(Mesa $objMesa, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_mesa WHERE idMesa = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objMesa->getIdMesa());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo mesa em MesaBD.",$ex);
        }
    }

}