<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{

    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Prato/Prato.php';
    require_once __DIR__ . '/../../classes/Prato/PratoRN.php';
    require_once __DIR__ . '/../../classes/CategoriaPrato/CategoriaPrato.php';
    require_once __DIR__ . '/../../classes/CategoriaPrato/CategoriaPratoINT.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    Sessao::getInstance()->validar();

    $objUtils = new Utils();

    $objPrato = new Prato();
    $objPratoRN = new PratoRN();

    $alert = '';
    $select_categorias = '';
    $caractere = '';

    CategoriaPratoINT::montar_select_categorias_prato($select_categorias, $caractere,null,null);

    switch($_GET['action']){
        case 'cadastrar_prato':
            if(isset($_POST['btn_salvar_Prato'])){
                $objPrato->setPreco($_POST['numPreco']);
                $objPrato->setNome($_POST['txtNome']);
                $objPrato->setIndexNome(strtoupper($objUtils->tirarAcentos($_POST['txtNome'])));
                $objPrato->setInformacoes($_POST['txtInformacoes']);
                $objPrato->setCategoriaPrato($_POST['sel_categoria_prato']);
                $objPratoRN->cadastrar($objPrato);

                CategoriaPratoINT::montar_select_categorias_prato($select_categorias, $_POST['sel_categoria_prato'],null,null);
                $alert = Alert::alert_success("Prato ".$objPrato->getNome()." <strong>cadastrado</strong> com sucesso");
            }
            break;

        case 'editar_prato':
            if(!isset($_POST['btn_salvar_Prato'])){
                $objPrato->setIdPrato($_GET['idPrato']);
                $objPrato = $objPratoRN->consultar($objPrato);
                CategoriaPratoINT::montar_select_categorias_prato($select_categorias,$objPrato->getCategoriaPrato(),null,null);

            }

            if(isset($_POST['btn_salvar_Prato'])){
                $objPrato->setIdPrato($_GET['idPrato']);
                $objPrato->setPreco($_POST['numPreco']);
                $objPrato->setNome($_POST['txtNome']);
                $objPrato->setIndexNome(strtoupper($objUtils->tirarAcentos($_POST['txtNome'])));
                $objPrato->setInformacoes($_POST['txtInformacoes']);
                $objPrato->setCategoriaPrato($_POST['sel_categoria_prato']);
                $objPratoRN->alterar($objPrato);
                CategoriaPratoINT::montar_select_categorias_prato($select_categorias, $_POST['sel_categoria_prato'],null,null);
                $alert = Alert::alert_success("Prato ".$objPrato->getNome()."  <strong>alterado</strong> com sucesso");
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_prato.php');
    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Prato");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'
 
<div class="conteudo_grande" >
<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_numero_Prato">Informe o nome do prato:</label>
            <input type="text" class="form-control" placeholder="prato" 
                   onblur="" name="txtNome"  value="'.Pagina::formatar_html($objPrato->getNome()).'">
        </div>
        <div class="col-md-4 mb-3">
            <label for="label_numero_Prato">Selecione uma categoria de prato:</label>
            '.$select_categorias.'
        </div>
        <div class="col-md-4 mb-3">
            <label for="label_numLugares">Informe o preço do prato:</label>
            <input type="number" class="form-control" placeholder="R$" step="any"
                   name="numPreco"  value="'.Pagina::formatar_html($objPrato->getPreco()).'">
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 mb-3">
        <textarea name="txtInformacoes" rows="2" cols="100" class="form-control"
              rows="3">'.Pagina::formatar_html($objPrato->getInformacoes()).'</textarea>
        </div>
    </div>  
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <button class="btn btn-primary" type="submit" style="width: 30%; margin-left: 35%;" name="btn_salvar_Prato">SALVAR</button>
        </div>
    </div>
</form>
</div>';



Pagina::getInstance()->fechar_corpo();

