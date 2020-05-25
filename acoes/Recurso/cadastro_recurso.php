<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Recurso/Recurso.php';
    require_once __DIR__ . '/../../classes/Recurso/RecursoRN.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    Sessao::getInstance()->validar();
    $objUtils = new Utils();
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();
    $alert = '';

    switch($_GET['action']){
        case 'cadastrar_recurso':
            if(isset($_POST['salvar_recurso'])){
                $objRecurso->setNome($_POST['txtNome']);
                $objRecurso->setSNMenu( strtolower($_POST['txtSN']));
                $objRecurso->setIndexRecurso(strtoupper($objUtils->tirarAcentos($_POST['txtNome'])));

                $objRecurso  = $objRecursoRN->cadastrar($objRecurso);
                $alert.= Alert::alert_success("O recurso -".$objRecurso->getNome()."- foi cadastrado");

                
            }else{
                $objRecurso->setIdRecurso('');
                $objRecurso->setNome('');
                $objRecurso->setSNMenu('');
                $objRecurso->setIndexRecurso('');
            }
        break;
        
        case 'editar_recurso':
            if(!isset($_POST['salvar_recurso'])){ //enquanto não enviou o formulário com as alterações
                $objRecurso->setIdRecurso($_GET['idRecurso']);
                $objRecurso = $objRecursoRN->consultar($objRecurso);
            }
            
             if(isset($_POST['salvar_recurso'])){ //se enviou o formulário com as alterações
                $objRecurso->setIdRecurso($_GET['idRecurso']);
                $objRecurso->setNome($_POST['txtNome']);
                $objRecurso->setSNMenu( strtolower($_POST['txtSN']));
                $objRecurso->setIndexRecurso(strtoupper($objUtils->tirarAcentos($_POST['txtNome'])));
                $objRecursoRN->alterar($objRecurso);
                $alert .= Alert::alert_success("O recurso foi alterado");

             
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_recurso.php');  
    }
   
} catch (Throwable $ex) {
      Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Cadastrar Recurso");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("recurso");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
//Pagina::montar_topo_listar("CADASTRAR RECURSO",null,null,"listar_recurso","LISTAR RECURSOS");
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'

<DIV class="conteudo_grande">
<form method="POST">
    <div class="form-row">
        <div class="col-md-5 mb-3">
            <label for="label_nome">Digite o nome:</label>
            <input type="text" class="form-control" id="idNomeRecurso" placeholder="Nome" 
                   onblur="validaNome()" name="txtNome"  value="'.Pagina::formatar_html($objRecurso->getNome()).'">
            <div id ="feedback_nome"></div>

        </div>
        
        <div class="col-md-5 mb-3">
            <label for="label_s_n_menu">Digite S/N para o menu:</label>
            <input type="text" class="form-control" id="idSNRecurso" placeholder="S/N" 
                   onblur="validaSNmenu()" name="txtSN"  value="'.Pagina::formatar_html($objRecurso->getSNMenu()).'">
            <div id ="feedback_s_n_menu"></div>

        </div>
        
        <div class="col-md-2 mb-3">
            <button class="btn btn-primary" type="submit" style="margin-top: 31px;width: 100%;margin-left: 0px;" name="salvar_recurso">Salvar</button>
        </div>
    </div>  
    
</form>
</DIV>';



Pagina::getInstance()->fechar_corpo();

