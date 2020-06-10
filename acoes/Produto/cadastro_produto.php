<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{

    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Produto/Produto.php';
    require_once __DIR__ . '/../../classes/Produto/ProdutoRN.php';

    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProduto.php';
    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProdutoRN.php';
    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProdutoINT.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    Sessao::getInstance()->validar();

    $objUtils = new Utils();

    $objProduto = new Produto();
    $objProdutoRN = new ProdutoRN();

    $objCategoriaProduto = new CategoriaProduto();
    $objCategoriaProdutoRN = new CategoriaProdutoRN();

    $alert = '';
    $select_categorias = '';
    $caractere = '';

    CategoriaProdutoINT::montar_select_categorias_produtos($select_categorias, $objCategoriaProduto,$objCategoriaProdutoRN,null,null);

    switch($_GET['action']){
        case 'cadastrar_produto':
            if(isset($_POST['btn_salvar_produto'])){
                $objProduto->setPreco($_POST['numPreco']);
                $objProduto->setNome($_POST['txtNome']);
                $objProduto->setIndexNome(strtoupper($objUtils->tirarAcentos($_POST['txtNome'])));
                $objProduto->setCategoriaProduto($_POST['sel_categoria_produto']);

                $objProdutoRN->cadastrar($objProduto);

                $alert = Alert::alert_success("Produto ".$objProduto->getNome()." <strong>cadastrado</strong> com sucesso");
            }
            break;

        case 'editar_produto':

            $objProduto->setIdProduto($_GET['idProduto']);
            $objProduto = $objProdutoRN->consultar($objProduto);

            if(isset($_POST['btn_salvar_Prato'])){
                $objProduto->setPreco($_POST['numPreco']);
                $objProduto->setNome($_POST['txtNome']);
                $objProduto->setIndexNome(strtoupper($objUtils->tirarAcentos($_POST['txtNome'])));
                $objProduto->setCategoriaProduto($_POST['sel_categoria_produto']);

                $objProdutoRN->alterar($objProduto);

                $alert = Alert::alert_success("Produto ".$objProduto->getNome()." <strong>alterado</strong> com sucesso");
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_produto.php');
    }

    CategoriaProdutoINT::montar_select_categorias_produtos($select_categorias, $objCategoriaProduto,$objCategoriaProdutoRN,null,null);

} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Produto");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();
echo $alert.'
  <div class="container-fluid">
    <h1 class="mt-4">Produto</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>';
    echo '         <li class="breadcrumb-item active">Cadastrar Produto</li>';
    if(Sessao::getInstance()->verificar_permissao('listar_produto')) {
        echo '          <li class="breadcrumb-item"><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_produto') . '">Listar Produto</a></li>';
    }
   echo '  </ol>
    </div>
<div class="conteudo_grande" >
<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_numero_Prato">Informe o nome do produto:</label>
            <input type="text" class="form-control" placeholder="prato" 
                   onblur="" name="txtNome"  value="'.Pagina::formatar_html($objProduto->getNome()).'">
        </div>
        <div class="col-md-4 mb-3">
            <label for="label_numero_Prato">Selecione a categoria do produto:</label>
            '.$select_categorias.'
        </div>
        <div class="col-md-4 mb-3">
            <label for="label_numLugares">Informe o preço do produto:</label>
            <input type="number" class="form-control" placeholder="R$" step="any"
                   name="numPreco"  value="'.Pagina::formatar_html($objProduto->getPreco()).'">
        </div>
    </div>
    
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <button class="btn btn-primary" type="submit" style="width: 30%; margin-left: 35%;" name="btn_salvar_produto">SALVAR</button>
        </div>
    </div>
</form>
</div>';


Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();