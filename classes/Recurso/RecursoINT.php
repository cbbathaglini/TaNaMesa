<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class RecursoINT
{

    static function montar_select_multiplo_recurso(&$select_recurso, $objRecursoRN, &$objRecurso, &$recursos_selecionados) {


        $arr_recursos = $objRecursoRN->listar(new Recurso());

        $select_recurso = '<select  class="form-control selectpicker" 
            multiple data-live-search="true"   name="sel_recursos[]">'
            . '<option value="0" ></option>';

        foreach ($arr_recursos as $recurso) {
            $selected = ' ';
            if ($recursos_selecionados != '') {
                $rec = explode(";", $recursos_selecionados);
                foreach ($rec as $r) {
                    if ($recurso->getIdRecurso() == $r) {
                        $selected = ' selected ';
                    }
                }
                $select_recurso .= '<option ' . $selected . '  value="' . $recurso->getIdRecurso() . '">' . $recurso->getNome() . '</option>';
            } else {
                $select_recurso .= '<option  value="' . $recurso->getIdRecurso() . '">' . $recurso->getNome() . ' - Menu: ' . $recurso->getSNMenu() . '</option>';
            }
        }
        $select_recurso .= '</select>';
    }


}