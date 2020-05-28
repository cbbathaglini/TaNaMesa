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
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $objMesa = new Mesa();
    $objMesaRN = new MesaRN();

    $alert = '';

    switch($_GET['action']){
        case 'cadastrar_mesa':
            if(isset($_POST['btn_salvar_mesa'])){
                $objMesa->setNumero($_POST['numMesa']);
                $objMesa->setNumLugares($_POST['numQntLugares']);
                $objMesa->setSituacao(MesaRN::$STA_LIBERADA);
                $objMesaRN->cadastrar($objMesa);

                $alert = Alert::alert_success("Mesa de número ".$objMesa->getNumero()." <strong>cadastrada</strong> com sucesso");
            }
            break;

        case 'editar_mesa':
            if(!isset($_POST['btn_salvar_mesa'])){
                $objMesa->setIdMesa($_GET['idMesa']);
                $objMesa = $objMesaRN->consultar($objMesa);

            }

            if(isset($_POST['btn_salvar_mesa'])){
                $objMesa->setIdMesa($_GET['idMesa']);
                $objMesa->setNumero($_POST['numMesa']);
                $objMesa->setNumLugares($_POST['numQntLugares']);
                $objMesa->setSituacao(MesaRN::$STA_LIBERADA);
                $objMesaRN->alterar($objMesa);

                $alert = Alert::alert_success("Mesa de número ".$objMesa->getNumero()." <strong>alterada</strong> com sucesso");
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_mesa.php');
    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Mesa");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'
 
<div class="conteudo_grande" >
<form method="POST">
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="label_numero_mesa">Digite o número da mesa:</label>
            <input type="number" class="form-control" placeholder="nº mesa" 
                   onblur="" name="numMesa"  value="'.Pagina::formatar_html($objMesa->getNumero()).'">
   

        </div>
        <div class="col-md-6 mb-3">
            <label for="label_numLugares">Digite a quantidade de lugares a mesa tem: (opcional)</label>
            <input type="number" class="form-control" placeholder="nº lugares" 
                   onblur="" name="numQntLugares"  value="'.Pagina::formatar_html($objMesa->getNumLugares()).'">
   

        </div>
              
    </div>  
    <button class="btn btn-primary" type="submit" name="btn_salvar_mesa">SALVAR</button>
</form>
</div>';



Pagina::getInstance()->fechar_corpo();

