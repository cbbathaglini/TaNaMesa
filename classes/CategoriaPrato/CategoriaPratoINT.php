<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class CategoriaPratoINT
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CategoriaPratoINT();
        }
        return self::$instance;
    }

    static function montar_select_categorias_prato(&$select_categorias, $caractere,$disabled=null,$onchange=null) {

        $disabled = '';
        $onchange ='';

        if($onchange){
            $onchange = ' onchange="this.form.submit()"';
        }
        if($disabled){
            $disabled = ' disabled ';
        }

        $arr_categorias = CategoriaPrato::listarValoresCategoriaPrato();

        $select_categorias = '<select ' . $disabled . ' class="form-control selectpicker" '.$onchange
            . ' data-live-search="true" name="sel_categoria_prato">'
            . '<option data-tokens="" value="-1">Selecione uma categoria de prato</option>';

        foreach ($arr_categorias as $u) {
            $selected = '';
            if ($u->getStrTipo() == $caractere) {
                $selected = 'selected';
            }

            $select_categorias .= '<option ' . $selected . '  value="' . Pagina::formatar_html($u->getStrTipo()) .
                '" data-tokens="' .  Pagina::formatar_html($u->getStrDescricao()) . '">' . Pagina::formatar_html($u->getStrDescricao()) . '</option>';
        }
        $select_categorias .= '</select>';
    }
}