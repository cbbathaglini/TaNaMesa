<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once  __DIR__.'/../Situacao/Situacao.php';
class CategoriaPrato
{
    public static $CP_PEIXE = 'P';
    public static $CP_CARNE = 'C';
    public static $CP_FRANGO = 'F';
    public static $CP_MASSA = 'M';
    public static $CP_PIZZA = 'Z';

    public static function listarValoresCategoriaPrato(){
        try {

            $arrObjTStaMesa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_PEIXE);
            $objSituacao->setStrDescricao('Peixe');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_CARNE);
            $objSituacao->setStrDescricao('Carne');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_FRANGO);
            $objSituacao->setStrDescricao('Frango');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_MASSA);
            $objSituacao->setStrDescricao('Massa');
            $arrObjTStaMesa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$CP_PIZZA);
            $objSituacao->setStrDescricao('Pizza');
            $arrObjTStaMesa[] = $objSituacao;

            return $arrObjTStaMesa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando categorias dos pratos',$e);
        }
    }

    public static function mostrarDescricaoCategoriaPrato($caractere){
        foreach (self::listarValoresCategoriaPrato() as $sta){
            if($sta->getStrTipo() == $caractere){
                return $sta->getStrDescricao();
            }
        }
        return null;
    }
}