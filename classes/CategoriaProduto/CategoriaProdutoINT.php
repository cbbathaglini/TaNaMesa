<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class CategoriaProdutoINT
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CategoriaProdutoINT();
        }
        return self::$instance;
    }

    static function montar_select_categorias_produtos(&$select_categorias, $objCategoriaProduto,$objCategoriaProdutoRN,$disabled = null, $onchange = null){

        $disabled = '';
        $onchange ='';

        if($onchange){
            $onchange = ' onchange="this.form.submit()"';
        }
        if($disabled){
            $disabled = ' disabled ';
        }

        $arr_categorias = $objCategoriaProdutoRN->listar($objCategoriaProduto);

        $select_categorias = '<select ' . $disabled . ' class="form-control" '.$onchange
            . ' data-live-search="true" name="sel_categoria_produto">'
            . '<option data-tokens="" value="-1">Selecione uma categoria de prato</option>';

        foreach ($arr_categorias as $u) {
            $selected = '';
            if ($u->getDescricao() == $objCategoriaProduto->getDescricao()) {
                $selected = 'selected';
            }

            $select_categorias .= '<option ' . $selected . '  value="' . Pagina::formatar_html($u->getIdCategoriaProduto()) .
                '" data-tokens="' .  Pagina::formatar_html($u->getDescricao()) . '">' . Pagina::formatar_html($u->getDescricao()) . '</option>';
        }
        $select_categorias .= '</select>';
    }
}