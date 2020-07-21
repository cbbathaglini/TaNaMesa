<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProduto.php';
    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProdutoRN.php';



    Sessao::getInstance()->validar();

    $objCategoriaProduto = new CategoriaProduto();
    $objCategoriaProdutoRN = new CategoriaProdutoRN();

    $alert = '';

    $html = '';

    switch ($_GET['action']){
        case 'remover_categoria_produto':
            try{
                $objCategoriaProduto->setIdCategoriaProduto($_GET['idCategoriaProduto']);
                $objCategoriaProdutoRN->remover($objCategoriaProduto);
                $alert .= Alert::alert_success("Categoria do produto removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    $arrCategoriasProdutos = $objCategoriaProdutoRN->listar($objCategoriaProduto);
    //print_r($arrCategoriasProdutos);

    foreach ($arrCategoriasProdutos as $categoria){
        //print_r($categoria);
        $html.='<tr>
                        <th scope="row">'.Pagina::formatar_html($categoria->getIdCategoriaProduto()).'</th>
                        <td>'.Pagina::formatar_html($categoria->getStrCategoria()).'</td>
                        <td>'.Pagina::formatar_html($categoria->getStrDescricao()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_categoria_produto')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_categoria_produto&idCategoriaProduto='.Pagina::formatar_html($categoria->getIdCategoriaProduto())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_categoria_produto')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_categoria_produto&idCategoriaProduto='.Pagina::formatar_html($categoria->getIdCategoriaProduto())).'"><i class="fas fa-trash-alt"></a></td>';
        }

        $html .= ' </tr>';
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Categorias Produtos");
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
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_categoria_produto').'">Cadastrar Categoria do Produto</a></li>
            <li class="breadcrumb-item active">Listar Categoria do Produto</li>
        </ol>
    </div>
    <div class="conteudo_listar">'.
    '<div class="conteudo_tabela"><table class="table table-hover">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">DESCRIÇÃO</th>
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


Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();

