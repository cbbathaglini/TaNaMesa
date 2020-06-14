<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{

    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Mesa/Mesa.php';
    require_once __DIR__ . '/../../classes/Mesa/MesaRN.php';
    require_once __DIR__ . '/../../classes/Usuario/Usuario.php';
    require_once __DIR__ . '/../../classes/Usuario/UsuarioRN.php';
    require_once __DIR__ . '/../../classes/Usuario/UsuarioINT.php';
    require_once __DIR__ . '/../../utils/Alert.php';



    Sessao::getInstance()->validar();

    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();


    $objMesa = new Mesa();
    $objMesaRN = new MesaRN();

    $alert = '';
    $select_funcionario ='';
    //UsuarioINT::montar_select_usuario($select_funcionario, $objUsuarioRN, $objUsuario,null,null);
    $arr_usuarios = $objUsuarioRN->listar($objUsuario);
    //print_r($arr_usuarios);

    switch($_GET['action']){
        case 'cadastrar_mesa':
            if(isset($_POST['btn_salvar_mesa'])){
                $objMesa->setDisponivel(true);
                $objMesa->setBoolPrecisaFunc(false);
                $objMesa->setEsperandoPedido(false);
                $objMesa->setIdPedido(null);

                foreach ($arr_usuarios as $usuario){
                    if(!is_null($_POST['id'.$usuario->getIdUsuario()])){
                        $arr[] = intval($_POST['id'.$usuario->getIdUsuario()]);
                    }
                }

                $arr = array_unique($arr);

                $objMesa->setIdFuncionario($arr);
                $objMesaRN->cadastrar($objMesa);

                $alert = Alert::alert_success("Mesa de número ".$objMesa->getIdMesa()." <strong>cadastrada</strong> com sucesso");
            }
            break;

        case 'editar_mesa':

            $objMesa->setIdMesa($_GET['idMesa']);
            $objMesa = $objMesaRN->consultar($objMesa);


            if(isset($_POST['btn_salvar_mesa'])){
                foreach ($arr_usuarios as $usuario){
                    if(!is_null($_POST['id'.$usuario->getIdUsuario()])){
                        $arr[] = intval($_POST['id'.$usuario->getIdUsuario()]);
                    }
                }

                $arr = array_unique($arr);

                $objMesa->setIdFuncionario($arr);
                $objMesaRN->alterar($objMesa);

                $alert = Alert::alert_success("Mesa de número ".$objMesa->getIdMesa()." <strong>alterada</strong> com sucesso");
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_mesa.php');
    }

    $cont = 0;
    $checks ='<div class="form-row">';
    foreach ($arr_usuarios as $usuario){
        if(!in_array(0,$usuario->getListaPerfis())) {

            $checked = '';
            if (!is_null($_POST['id' . $usuario->getIdUsuario()])) {
                $checked = ' checked ';
            }

            /**if(in_array($recurso->getIdRecurso(),$objPerfilUsuario->getListaRecursos())){
             * $checked = ' checked ';
             * }**/

            $checks .= '
                    <div class="col-3">
                        <div class="form-check">
                          <input class="form-check-input" ' . $checked . ' type="checkbox" name="id' . $usuario->getIdUsuario() . '" value="' . $usuario->getIdUsuario() . '" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">' .
                $usuario->getCPF()
                . '</label>
                       </div>
                    </div>
                ';
            $cont++;
            if ($cont == 4) {
                $cont = 0;
                $checks .= '</div>';
                $checks .= '<div class="form-row">';
            }
        }
    }
    $checks .= '</div>';

} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Mesa");

Pagina::getInstance()->fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::abrir_lateral();

echo $alert.'
 <div class="container-fluid">
    <h1 class="mt-4">Mesa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'">Dashboard</a></li>
            <li class="breadcrumb-item active">Cadastrar Mesa</li>
            <li class="breadcrumb-item"><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_mesa').'">Listar Mesa</li>
        </ol>
    </div>
<div class="conteudo_grande" >
<form method="POST">
 <label for="label_numero_mesa">Selecione os funcionários responsáveis:</label>          
            '.$checks.'

    <button class="btn btn-primary" type="submit" name="btn_salvar_mesa">SALVAR</button>
</form>
</div>';



Pagina::fechar_lateral();
Pagina::footer();
Pagina::fechar_body();
Pagina::fechar_html();

