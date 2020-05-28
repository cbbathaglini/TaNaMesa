<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{

    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Ingrediente/Ingrediente.php';
    require_once __DIR__ . '/../../classes/Ingrediente/IngredienteRN.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    Sessao::getInstance()->validar();

    $objIngrediente = new Ingrediente();
    $objIngredienteRN = new IngredienteRN();

    $objUtils = new Utils();

    $alert = '';

    switch($_GET['action']){
        case 'cadastrar_ingrediente':
            if(isset($_POST['btn_salvar_ingrediente'])){
                $objIngrediente->setIngrediente($_POST['txtIngrediente']);
                $objIngrediente->setIndexIngrediente(strtoupper($objUtils->tirarAcentos($_POST['txtIngrediente'])));
                $objIngredienteRN->cadastrar($objIngrediente);

                $alert = Alert::alert_success("Ingrediente ".$objIngrediente->getIngrediente()." <strong>cadastrado</strong> com sucesso");
            }
            break;

        case 'editar_ingrediente':
            if(!isset($_POST['btn_salvar_ingrediente'])){
                $objIngrediente->setIdIngrediente($_GET['idIngrediente']);
                $objIngrediente = $objIngredienteRN->consultar($objIngrediente);

            }

            if(isset($_POST['btn_salvar_ingrediente'])){
                $objIngrediente->setIdIngrediente($_GET['idIngrediente']);
                $objIngrediente->setIngrediente($_POST['txtIngrediente']);
                $objIngrediente->setIndexIngrediente(strtoupper($objUtils->tirarAcentos($_POST['txtIngrediente'])));
                $objIngredienteRN->cadastrar($objIngrediente);

                $alert = Alert::alert_success("Ingrediente ".$objIngrediente->getIngrediente()." <strong>alterado</strong> com sucesso");
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_ingrediente.php');
    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Ingrediente");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'
 
<div class="conteudo_grande" >
<form method="POST">
    <div class="form-row">
        <div class="col-md-10 mb-3">
            <label for="label_numero_ingrediente">Digite o nome do ingrediente:</label>
            <input type="text" class="form-control" placeholder="ingrediente" 
                   onblur="" name="txtIngrediente"  value="'.Pagina::formatar_html($objIngrediente->getIngrediente()).'">
        </div>
        
        <div class="col-md-2 mb-3"> 
            <input class="btn btn-primary" style="margin-top: 31px; width: 100%;margin-left: 0px;" type="submit" name="btn_salvar_ingrediente" value="SALVAR"></input>
        </div>
    </div> 
</form>
</div>';



Pagina::getInstance()->fechar_corpo();

