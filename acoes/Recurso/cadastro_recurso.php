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
            if(isset($_POST['btn_salvar'])) {
                $objRecurso->setNome($_POST['txtNome']);
                $objRecurso->setLink($_POST['txtLink']);
                $objRecurso->setSNMenu(strtolower($_POST['txtSN']));
                $objRecurso->setIndexRecurso(strtoupper($objUtils->tirarAcentos($_POST['txtNome'])));


                $objRecurso = $objRecursoRN->cadastrar($objRecurso);
                $alert .= Alert::alert_success("O recurso -" . $objRecurso->getNome() . "- foi cadastrado");
            }
        break;
        
        case 'editar_recurso':
            if(!isset($_POST['btn_salvar'])){ //enquanto não enviou o formulário com as alterações
                $objRecurso->setIdRecurso($_GET['idRecurso']);
                $objRecurso = $objRecursoRN->consultar($objRecurso);
            }
            
             if(isset($_POST['btn_salvar'])){ //se enviou o formulário com as alterações
                $objRecurso->setIdRecurso($_GET['idRecurso']);
                $objRecurso->setNome($_POST['txtNome']);
                 $objRecurso->setLink($_POST['txtLink']);
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
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();

echo $alert.'
 <div class="container-fluid">
   <div class="container-fluid">
    <h1 class="mt-4">Recurso</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>';
                 echo '     <li class="breadcrumb-item active">Cadastrar Recurso</li>';
                    if (Sessao::getInstance()->verificar_permissao('listar_recurso')) {
                        echo '    <li class="breadcrumb-item"><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_recurso') . '">Listar Recurso</a></li>';
                    }
      echo  '</ol>
    </div>';


   echo '

<DIV class="conteudo_grande">
<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_nome">Informe  o nome:</label>
            <input type="text" class="form-control" id="idNomeRecurso" placeholder="Nome" 
                   onblur="validaNome()" name="txtNome"  value="'.Pagina::formatar_html($objRecurso->getNome()).'">
         </div>
         <div class="col-md-4 mb-3">
            <label for="label_nome">Informe o link:</label>
            <input type="text" class="form-control"  placeholder="link" 
                 name="txtLink"  value="'.Pagina::formatar_html($objRecurso->getLink()).'">
        </div>
        
        <div class="col-md-4 mb-3">
            <label for="label_s_n_menu">Digite S/N para o menu:</label>
            <input type="text" class="form-control" id="idSNRecurso" placeholder="S/N" 
                   onblur="validaSNmenu()" name="txtSN"  value="'.Pagina::formatar_html($objRecurso->getSNMenu()).'">
        </div>
    </div>
        
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <button class="btn btn-primary" type="submit" style="margin-top: 0px;width: 30%;margin-left: 35%;" name="btn_salvar">Salvar</button>
        </div>
    </div>  
    
</form>
</DIV>';

Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();


