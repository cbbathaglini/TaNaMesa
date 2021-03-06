<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
error_reporting(E_ALL & ~E_NOTICE);
require_once __DIR__ . '/../classes/Sessao/Sessao.php';


switch ($_GET['action']):
    case 'principal':
        require_once 'tela_inicial.php';
        break;

    case 'login':
        require_once 'index.php';
        break;

    case 'sair':
        Sessao::getInstance()->logoff();
        header('Location: controlador.php?action=login');
        break;


    case 'ver_situacao_mesa':
        require_once '../acoes/Mesa/ver_situacao_mesa.php';
        break;
    case 'ver_pedidos_dia':
        require_once '../acoes/Pedido/ver_pedidos_dia.php';
        break;
    case 'ver_mais_pedidos':
        require_once '../acoes/Pedido/ver_mais_pedidos.php';
        break;
    case 'ver_categorias_pedidos':
        require_once '../acoes/Pedido/ver_categorias_pedidos.php';
        break;

    /*
     * MESA
     */
    case 'cadastrar_mesa':
    case 'editar_mesa':
        require_once '../acoes/Mesa/cadastro_mesa.php';
        break;
    case 'listar_mesa':
    case 'remover_mesa':
        require_once '../acoes/Mesa/listar_mesa.php';
        break;

    /*
     * PERFIL USUÁRIO
     */
    case 'cadastrar_perfil_usuario':
    case 'editar_perfil_usuario':
        require_once '../acoes/PerfilUsuario/cadastro_perfilUsuario.php';
        break;
    case 'listar_perfil_usuario':
    case 'remover_perfil_usuario':
        require_once '../acoes/PerfilUsuario/listar_perfilUsuario.php';
        break;

    /*
     *  USUÁRIO + RECURSO
     */
    case 'cadastrar_perfilUsuario_recurso':
    case 'editar_perfilUsuario_recurso':
        require_once '../acoes/PerfilUsuarioRecurso/cadastro_perfilUsuario_recurso.php';
        break;
    case 'listar_perfilUsuario_recurso':
    case 'remover_perfilUsuario_recurso':
        require_once '../acoes/PerfilUsuarioRecurso/listar_perfilUsuario_recurso.php';
        break;


    /*
    *  RECURSO
    */
    case 'cadastrar_recurso':
    case 'editar_recurso':
        require_once '../acoes/Recurso/cadastro_recurso.php';
        break;
    case 'listar_recurso':
    case 'remover_recurso':
        require_once '../acoes/Recurso/listar_recurso.php';
        break;

    /*
    *  USUÁRIO
    */
    case 'cadastrar_usuario':
    case 'editar_usuario':
        require_once '../acoes/Usuario/cadastro_usuario.php';
        break;
    case 'listar_usuario':
    case 'remover_usuario':
        require_once '../acoes/Usuario/listar_usuario.php';
        break;

    /*
    *  USUÁRIO + PERFIL
    */
    case 'cadastrar_usuario_perfilUsuario':
    case 'editar_usuario_perfilUsuario':
        require_once '../acoes/UsuarioPerfil/cadastro_usuarioPerfil.php';
        break;
    case 'listar_usuario_perfilUsuario':
    case 'remover_usuario_perfilUsuario':
        require_once '../acoes/UsuarioPerfil/listar_usuarioPerfil.php';
        break;

    /*
    *  PERFIL USUÁRIO + RECURSO
    */
    case 'cadastrar_perfilUsuario_recurso':
    case 'editar_perfilUsuario_recurso':
        require_once '../acoes/PerfilRecurso/cadastro_perfilRecurso.php';
        break;
    case 'listar_perfilUsuario_recurso':
    case 'remover_perfilUsuario_recurso':
        require_once '../acoes/PerfilRecurso/listar_perfilRecurso.php';
        break;

    /*
     *  INGREDIENTE
     */
    /*
    case 'cadastrar_ingrediente':
    case 'editar_ingrediente':
        require_once '../acoes/Ingrediente/cadastro_ingrediente.php';
        break;
    case 'listar_ingrediente':
    case 'remover_ingrediente':
        require_once '../acoes/Ingrediente/listar_ingrediente.php';
        break;
    */

    /*
    *  CATEGORIA PRODUTO
    */
    case 'cadastrar_categoria_produto':
    case 'editar_categoria_produto':
        require_once '../acoes/CategoriaProduto/cadastro_categoriaProduto.php';
        break;
    case 'listar_categoria_produto':
    case 'remover_categoria_produto':
        require_once '../acoes/CategoriaProduto/listar_categoriaProduto.php';
        break;


    /*
     *  PRODUTO
     */
    case 'cadastrar_produto':
    case 'editar_produto':
        require_once '../acoes/Produto/cadastro_produto.php';
        break;
    case 'listar_produto':
    case 'remover_produto':
        require_once '../acoes/Produto/listar_produto.php';
        break;

    /*
    *  PEDIDO
    */
    case 'realizar_pedido':
    case 'editar_pedido':
        require_once '../acoes/Pedido/realizar_pedido.php';
        break;
    case 'listar_pedido':
    case 'remover_pedido':
        require_once '../acoes/Produto/listar_pedido.php';
        break;


    /*
     * QRCode
     */
    case 'gerar_QRCode':
        require_once '../acoes/QRCode/gerar_QRCode.php';
        break;



    default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador geral.');
endswitch;
