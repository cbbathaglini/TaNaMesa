<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do recurso 
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/RecursoBD.php';

class RecursoRN{
    

    private function validarNome(Recurso $recurso,Excecao $objExcecao){
        $strNome = trim($recurso->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome não foi informado','idNomeRecurso','alert-danger');
        }else{
            if (strlen($strNome) > 100) {
                $objExcecao->adicionar_validacao('O nome possui mais que 100 caracteres.','idNomeRecurso','alert-danger');
            }
            
            
        }
        return $recurso->setNome($strNome);

    }
    

    private function validar_s_n_menu(Recurso $recurso,Excecao $objExcecao){
        $str_s_n = trim($recurso->getSNMenu());
        
        if ($str_s_n == '') {
            $objExcecao->adicionar_validacao('O s_n do menu não foi informado','idSNRecurso','alert-danger');
        }else{
            if($str_s_n != 's' && $str_s_n != 'n'){
                $objExcecao->adicionar_validacao('O s_n do menu não é nem \'s\' nem \'n\'','idSNRecurso','alert-danger');
            }
            if (strlen($str_s_n) > 1) {
                $objExcecao->adicionar_validacao('O s_n do menu possui mais que 1 caracteres','idSNRecurso','alert-danger');
            }
            if (is_numeric($str_s_n)) {
                $objExcecao->adicionar_validacao('O s_n do menu é não pode ser um número','idSNRecurso','alert-danger');
            }
           
        }
        
        return $recurso->setSNMenu($str_s_n);

    }

    private function validar_ja_existe_recurso(Recurso $recurso,Excecao $objExcecao){
        $objRecursoRN= new RecursoRN();
        $tamRecurso = count($objRecursoRN->listar($recurso,1));
        if($tamRecurso > 0){
            $objExcecao->adicionar_validacao('O recurso já existe',null,'alert-danger');
        }
    }

    private function validar_existe_usuario_com_o_recurso(Recurso $recurso,Excecao $objExcecao){
        $objRecursoRN= new RecursoRN();
        if($objRecursoRN->existe_usuario_com_o_recurso($recurso)){
            $objExcecao->adicionar_validacao('Existe ao menos um usuário associado a este recurso. Logo, ele não pode ser excluído',null,'alert-danger');
        }
    }

    private function validarIdRecurso(Recurso $recurso,Excecao $objExcecao){
        if($recurso->getIdRecurso() == null && $recurso->getIdRecurso() < 0){
            $objExcecao->adicionar_validacao('O identificador do recurso não foi informado',null,'alert-danger');
        }
    }


    public function cadastrar(Recurso $recurso) {
        try {
            $objExcecao = new Excecao();
            
            $this->validarNome($recurso,$objExcecao);
            $this->validar_s_n_menu($recurso,$objExcecao);
           // $this->validar_ja_existe_recurso($recurso,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $recurso = $objRecursoBD->cadastrar($recurso);

            return $recurso;
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando o recurso.', $e);
        }
    }

    public function alterar(Recurso $recurso) {
        try {
            $objExcecao = new Excecao();

            $this->validarNome($recurso,$objExcecao);
            $this->validar_s_n_menu($recurso,$objExcecao);
            $this->validar_ja_existe_recurso($recurso,$objExcecao);
            $this->validarIdRecurso($recurso,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $recurso = $objRecursoBD->alterar($recurso);

             return $recurso;
         } catch (Throwable $e) {
            throw new Excecao('Erro alterando o recurso.', $e);
        }
    }

    public function consultar(Recurso $recurso) {
        try {
            $objExcecao = new Excecao();

            $this->validarIdRecurso($recurso,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $arr =  $objRecursoBD->consultar($recurso);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro consultando o recurso.',$e);
        }
    }

    public function remover(Recurso $recurso) {
        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $arr =  $objRecursoBD->remover($recurso);

             return $arr;
         } catch (Throwable $e) {

            throw new Excecao('Erro removendo o recurso.', $e);
        }
    }

    public function listar_ids(Recurso $recurso,$numLimite=null) {
        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            
            $arr = $objRecursoBD->listar_ids($recurso,$numLimite);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando o recurso.',$e);
        }
    }

    public function listar(Recurso $recurso,$numLimite=null) {
        try {
            $objExcecao = new Excecao();

            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();

            $arr = $objRecursoBD->listar($recurso,$numLimite);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando o recurso.',$e);
        }
    }

    public function existe_usuario_com_o_recurso(Recurso $recurso) {
        try {
            $objExcecao = new Excecao();
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();

            $arr = $objRecursoBD->existe_usuario_com_o_recurso($recurso);

            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro verificando se existe um usuário com o recurso RN.',$e);
        }
    }


}

