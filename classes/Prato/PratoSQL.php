<?php


class PratoSQL
{
    public function cadastrar(Prato $objPrato, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_prato (nome,index_nome,informacoes,preco,categoriaPrato) VALUES (?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPrato->getNome());
            $arrayBind[] = array('s',$objPrato->getIndexNome());
            $arrayBind[] = array('s',$objPrato->getInformacoes());
            $arrayBind[] = array('d',$objPrato->getPreco());
            $arrayBind[] = array('s',$objPrato->getCategoriaPrato());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPrato->setIdPrato($objBanco->obterUltimoID());
            return $objPrato;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando prato no BD.",$ex);
        }

    }

    public function alterar(Prato $objPrato, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_prato SET '
                . ' nome = ?,'
                . ' index_nome = ?,'
                . ' informacoes = ?,'
                . ' preco = ?,'
                . ' categoriaPrato = ?'
                . '  where idPrato = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objPrato->getNome());
            $arrayBind[] = array('s',$objPrato->getIndexNome());
            $arrayBind[] = array('s',$objPrato->getInformacoes());
            $arrayBind[] = array('d',$objPrato->getPreco());
            $arrayBind[] = array('s',$objPrato->getCategoriaPrato());

            $arrayBind[] = array('i',$objPrato->getIdPrato());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objPrato;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando prato no BD.",$ex);
        }

    }

    public function listar(Prato $objPrato,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_prato";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if($objPrato->getIdPrato() != null){
                $WHERE .= $AND." idPrato = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objPrato->getIdPrato());
            }

            if($objPrato->getCategoriaPrato() != null){
                $WHERE .= $AND." categoriaPrato = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objPrato->getCategoriaPrato());
            }

            if($objPrato->getInformacoes() != null){
                $WHERE .= $AND." informacoes = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objPrato->getInformacoes());
            }

            if($objPrato->getIndexNome() != null){
                $WHERE .= $AND." index_nome = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objPrato->getIndexNome());
            }

            if($objPrato->getPreco() != null){
                $WHERE .= $AND." preco = ?";
                $AND = ' and ';
                $arrayBind[] = array('d',$objPrato->getPreco());
            }

            if($objPrato->getNome() != null){
                $WHERE .= $AND." nome = ?";
                $AND = ' and ';

                $arrayBind[] = array('s',$objPrato->getNome());
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


            $array_prato = array();
            if(count($arr) > 0) {
                foreach ($arr as $reg) {
                    $prato = new Prato();
                    $prato->setIdPrato($reg['idPrato']);
                    $prato->setNome($reg['nome']);
                    $prato->setIndexNome($reg['index_nome']);
                    $prato->setCategoriaPrato($reg['categoriaPrato']);
                    $prato->setPreco($reg['preco']);
                    $prato->setInformacoes($reg['informacoes']);

                    $array_prato[] = $prato;
                }
            }
            return $array_prato;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando prato no BD.",$ex);
        }

    }

    public function consultar(Prato $objPrato, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_prato WHERE idPrato = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPrato->getIdPrato());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            $prato = new Prato();
            $prato->setIdPrato($arr[0]['idPrato']);
            $prato->setNome($arr[0]['nome']);
            $prato->setIndexNome($arr[0]['index_nome']);
            $prato->setCategoriaPrato($arr[0]['categoriaPrato']);
            $prato->setPreco($arr[0]['preco']);
            $prato->setInformacoes($arr[0]['informacoes']);

            return $prato;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando prato no BD.",$ex);
        }

    }

    public function remover(Prato $objPrato, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_prato WHERE idPrato = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPrato->getIdPrato());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo prato no BD.",$ex);
        }
    }
}