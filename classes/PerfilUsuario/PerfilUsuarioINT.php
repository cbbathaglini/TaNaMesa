<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
class PerfilUsuarioINT
{
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Interf();
        }
        return self::$instance;
    }

    static function montar_select_multiplos_perfis(&$select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,&$perfis_selecionados) {

        /* PERFIS DO USUÁRIO */
        $arr_perfis = $objPerfilUsuarioRN->listar(new PerfilUsuario());

        $select_perfilUsu = '<select  class="form-control selectpicker" multiple data-live-search="true"   name="sel_perfil[]">'
            . '<option value="-1" >Selecione um ou mais perfis</option>';

        foreach ($arr_perfis as $todos_perfis) {
            $selected = ' ';
            if ($perfis_selecionados != '') {
                $perfis = explode(";", $perfis_selecionados);
                foreach ($perfis as $p) {
                    if ($todos_perfis->getIdPerfilUsuario() == $p) {
                        $selected = ' selected ';
                    }
                }
                $select_perfilUsu .= '<option ' . $selected . '  '
                    . 'value="' .  Pagina::formatar_html($todos_perfis->getIdPerfilUsuario()) . '">'
                    .  Pagina::formatar_html($todos_perfis->getPerfil()) . '</option>';
            } else {
                $select_perfilUsu .= '<option  '
                    . 'value="' .  Pagina::formatar_html($todos_perfis->getIdPerfilUsuario()) . '">'
                    .  Pagina::formatar_html($todos_perfis->getPerfil())  . '</option>';
            }
        }
        $select_perfilUsu .= '</select>';
    }


    static function montar_select_perfil(&$select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,$disabled=null, $onchange=null) {


        $disabled = '';
        $onchange ='';

        if($onchange){
            $onchange = ' onchange="this.form.submit()"';
        }
        if($disabled){
            $disabled = ' disabled ';
        }

        $arr_perfis = $objPerfilUsuarioRN->listar(new PerfilUsuario());
        if (isset($_GET['idPerfilUsuario'])) {
            $disabled = ' disabled ';
        }
        $select_perfilUsu = '<select ' . $disabled . '  class="form-control selectpicker"  
    data-live-search="true"   name="sel_perfil">'
            . '<option value="0" ></option>';

        foreach ($arr_perfis as $pu) {
            $selected = ' ';
            if ($pu->getIdPerfilUsuario() == $objPerfilUsuario->getIdPerfilUsuario()) {
                $selected = 'selected';
            }

            $select_perfilUsu .= '<option ' . $selected . '  value="' . $pu->getIdPerfilUsuario() . '">' . $pu->getPerfil() . '</option>';
        }
        $select_perfilUsu .= '</select>';
    }
}