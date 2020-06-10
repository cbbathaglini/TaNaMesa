<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{

    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProduto.php';
    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProdutoRN.php';

    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $objCategoriaProduto = new CategoriaProduto();
    $objCategoriaProdutoRN = new CategoriaProdutoRN();

    $alert = '';


    switch($_GET['action']){
        case 'cadastrar_categoria_produto':
            if(isset($_POST['btn_salvar_categoria'])){
                $objCategoriaProduto->setDescricao($_POST['txtDescricao']);

                $objCategoriaProdutoRN->cadastrar($objCategoriaProduto);

                $alert = Alert::alert_success("Categoria ".$objCategoriaProduto->getDescricao()." <strong>cadastrada</strong> com sucesso");
            }
            break;

        case 'editar_categoria_produto':

            $objCategoriaProduto->setIdCategoriaProduto($_GET['idCategoriaProduto']);
            $objCategoriaProduto = $objCategoriaProdutoRN->consultar($objCategoriaProduto);

            if(isset($_POST['btn_salvar_categoria'])){
                $objCategoriaProduto->setDescricao($_POST['txtDescricao']);

                $objCategoriaProdutoRN->cadastrar($objCategoriaProduto);

                $alert = Alert::alert_success("Categoria ".$objCategoriaProduto->getDescricao()." <strong>alterada</strong> com sucesso");
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_categoriaProduto.php');
    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Categoria do Produto");
Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();

echo $alert.'
 <div class="container-fluid">
    <h1 class="mt-4">Categoria Produto</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>
            <li class="breadcrumb-item active">Cadastrar Categoria do Produto</li>
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_categoria_produto').'">Listar Categoria do Produto</li>
        </ol>
    </div>
<div class="conteudo_grande" >
<form method="POST">
 <label for="label_numero_Prato">Informe o nome da categoria:</label>
            <input type="text" class="form-control" placeholder="categoria" 
                   onblur="" name="txtDescricao"  value="'.Pagina::formatar_html($objCategoriaProduto->getDescricao()).'">

    <button class="btn btn-primary" type="submit" name="btn_salvar_categoria">SALVAR</button>
</form>
</div>';



Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();

