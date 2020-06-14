<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Produto/Produto.php';
    require_once __DIR__ . '/../../classes/Produto/ProdutoRN.php';

    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProduto.php';
    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProdutoRN.php';
    require_once __DIR__ . '/../../classes/CategoriaProduto/CategoriaProdutoINT.php';

    require_once __DIR__.'/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $objProduto = new Produto();
    $objProdutoRN = new ProdutoRN();

    $objCategoriaProduto = new CategoriaProduto();
    $objCategoriaProdutoRN = new CategoriaProdutoRN();

    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_produto':
            try{
                $objProduto->setIdProduto($_GET['idProduto']);
                $objProdutoRN->remover($objProduto);
                $alert .= Alert::alert_success("Produto removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    $arrProdutos = $objProdutoRN->listar($objProduto);

    foreach ($arrProdutos as $p){
       if($p->getCategoriaProduto() == 2 || $p->getCategoriaProduto() == 1 || $p->getCategoriaProduto() == 8){ //massas,frangos e massas
           $style = ' width="100px" height="80px" ';
       }else{
           $style = ' width="50px" height="80px" ';
       }
        $objCategoriaProduto->setIdCategoriaProduto($p->getCategoriaProduto());
        $objCategoriaProduto = $objCategoriaProdutoRN->consultar($objCategoriaProduto);
        $html.='<tr>
                        <th scope="row">'.Pagina::formatar_html($p->getIdProduto()).'</th>
                         <td><img '.$style.'  src="'.$p->getCaminhoImgSistWEB().'" ></td>
                         <td>'.Pagina::formatar_html($p->getNome()).'</td>
                        <td>'.Pagina::formatar_html($objCategoriaProduto->getDescricao()).'</td>
                        <td>'.Pagina::formatar_html($p->getPreco()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_produto')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_produto&idProduto='.Pagina::formatar_html($p->getIdProduto())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_produto')) {
            $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_produto&idProduto='.Pagina::formatar_html($p->getIdProduto())).'"><i class="fas fa-trash-alt"></a></td>';
        }

        $html .= ' </tr>';
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Produtos");
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
        if(Sessao::getInstance()->verificar_permissao('cadastrar_produto')) {
                echo '          <li class="breadcrumb-item"><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_produto') . '"> Cadastrar Produto</a></li>';
            }
echo '         <li class="breadcrumb-item active">Listar Produto</li>';
echo '  </ol>
    </div>
 
    <div class="conteudo_listar">'.
    '<div class="conteudo_tabela"><table class="table table-hover">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">FOTO PRODUTO</th>
                        <th scope="col">NOME</th>
                        <th scope="col">CATEGORIA</th>
                        <th scope="col">PREÇO</th>
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
