<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class UsuarioINT
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UsuarioINT();
        }
        return self::$instance;
    }

    static function montar_select_usuario(&$select_usuario, $objUsuarioRN, &$objUsuario,$disabled=null,$onchange=null) {

        $disabled = '';
        $onchange ='';

        if($onchange){
            $onchange = ' onchange="this.form.submit()"';
        }
        if($disabled){
            $disabled = ' disabled ';
        }

        $arr_usuarios = $objUsuarioRN->listar($objUsuario);

        $select_usuario = '<select ' . $disabled . ' class="form-control" '.$onchange
            . 'id="idSel_usuarios" data-live-search="true" name="sel_usuario">'
            . '<option data-tokens="" value="-1">Selecione um usuário</option>';

        foreach ($arr_usuarios as $u) {
            //if($u->getListaPerfis()[0] != 0) {
                $selected = '';
                if ($u->getIdUsuario() == $objUsuario->getIdUsuario()) {
                    $selected = 'selected';
                }

                $select_usuario .= '<option ' . $selected . '  value="' . Pagina::formatar_html($u->getIdUsuario()) .
                    '" data-tokens="' . Pagina::formatar_html($u->getCPF()) . '"> Funcionário de CPF ' . Pagina::formatar_html($u->getCPF()) . '</option>';
           // }
        }
        $select_usuario .= '</select>';
    }

    static function montar_select_usuario_funcionario(&$select_usuario, $objUsuarioRN, &$objUsuario,$disabled=null,$onchange=null) {

        $disabled = '';
        $onchange ='';

        if($onchange){
            $onchange = ' onchange="this.form.submit()"';
        }
        if($disabled){
            $disabled = ' disabled ';
        }

        $arr_usuarios = $objUsuarioRN->listar($objUsuario);

        $select_usuario = '<select ' . $disabled . ' class="form-control" '.$onchange
            . 'id="idSel_usuarios" data-live-search="true" name="sel_usuario">'
            . '<option data-tokens="" value="-1">Selecione um usuário</option>';

        foreach ($arr_usuarios as $u) {
            //if($u->getListaPerfis()[0] != 0) {
            $selected = '';
            if ($u->getIdUsuario() == $objUsuario->getIdUsuario()) {
                $selected = 'selected';
            }

            $select_usuario .= '<option ' . $selected . '  value="' . Pagina::formatar_html($u->getIdUsuario()) .
                '" data-tokens="' . Pagina::formatar_html($u->getCPF()) . '"> Funcionário de CPF ' . Pagina::formatar_html($u->getCPF()) . '</option>';
            // }
        }
        $select_usuario .= '</select>';
    }
}