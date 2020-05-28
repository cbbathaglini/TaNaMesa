<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once '../classes/Sessao/Sessao.php';

    require_once '../classes/Pagina/Pagina.php';
    require_once '../classes/Excecao/Excecao.php';

    require_once '../classes/Recurso/Recurso.php';
    require_once '../classes/Recurso/RecursoRN.php';

    require_once '../classes/PerfilUsuario/PerfilUsuario.php';
    require_once '../classes/PerfilUsuario/PerfilUsuarioRN.php';

    require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
    require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';

    $html = '';

     Sessao::getInstance()->validar();

    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();
    
    /* PERFIL USUÁRIO + RECURSO */
    $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
    $objRel_perfilUsuario_recurso_RN = new Rel_perfilUsuario_recurso_RN();

    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();


    switch ($_GET['action']){
        case 'remover_perfilUsuario_recurso':
            try{
                /*$objRel_perfilUsuario_recurso->S($_GET['idProtocolo']);
                $objProtocoloRN->remover($objProtocolo);*/
                $alert .= Alert::alert_success("fazer remoção");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    /***************** FAZER LISTAR MELHOR ************************/

    $arr_perfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    
    $arrPR = $objRel_perfilUsuario_recurso_RN->listar($objRel_perfilUsuario_recurso);

    $recursos = '';$indices_recursos='';$arr_perfisPercorridos = array();
    foreach ($arr_perfis as $p){
        $recursos ='';$indices_recursos='';
        foreach ($arrPR as $PERFIL_RECURSO){ 
           if( $PERFIL_RECURSO->getIdPerfilUsuario() == $p->getIdPerfilUsuario()){

               $objPerfilUsuario->setIdPerfilUsuario($PERFIL_RECURSO->getIdPerfilUsuario());
               $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);               


               $objRecurso->setIdRecurso($PERFIL_RECURSO->getIdRecurso());
               $objRecurso = $objRecursoRN->consultar($objRecurso);

               
                $recursos .= $objRecurso->getNome().' - '.$objRecurso->getSNMenu() .";  ";
                $indices_recursos .=$objRecurso->getIdRecurso().";";
               
               
           }
        }
        
        if(!in_array($objPerfilUsuario->getIdPerfilUsuario(),$arr_perfisPercorridos)){ // se o array de perfis que já foram percorridos  não contiver um perfil, o adiciona
         $arr_perfisPercorridos[] = $objPerfilUsuario->getIdPerfilUsuario();
        
         $indices_recursos = substr($indices_recursos, 0, -1);
            $html.='<tr>
                <th scope="row">'.Pagina::formatar_html($objPerfilUsuario->getPerfil()).'</th> 
                    <td>'.Pagina::formatar_html($recursos).'</td>';

            //echo 'controlador.php?action=editar_perfilUsuario_recurso&idRecurso='.Pagina::formatar_html($indices_recursos).'&idPerfilUsuario='.Pagina::formatar_html($objPerfilUsuario->getIdPerfilUsuario());
            if(Sessao::getInstance()->verificar_permissao('editar_perfilUsuario_recurso')){
                $html.= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_perfilUsuario_recurso&idRecurso='.Pagina::formatar_html($indices_recursos).'&idPerfilUsuario='.Pagina::formatar_html($objPerfilUsuario->getIdPerfilUsuario())).'"><i class="fas fa-edit "></i></a></td>';
            }
            if(Sessao::getInstance()->verificar_permissao('remover_perfilUsuario_recurso')){
                   $html.= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_perfilUsuario_recurso&idRecurso='.Pagina::formatar_html($indices_recursos).'&idPerfilUsuario='.Pagina::formatar_html($objPerfilUsuario->getIdPerfilUsuario())).'"><i class="fas fa-trash-alt"></i></a></td>';
            }
            $html .='</tr>';
        }

           
        
    }
    
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Relacionamento do Perfil com os Recursos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();

echo '
    <div class="conteudo_listar">
    <div class="conteudo_tabela">
    <table class="table table-hover">
      <thead>
        <tr>
            <th scope="col">PERFIL</th>
            <th scope="col">RECURSOS</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
      </thead>
      <tbody>'
            .$html.
      '</tbody>
    </table>
    </div>
</div>';


Pagina::getInstance()->fechar_corpo();
