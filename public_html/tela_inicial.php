<?php
session_start();
try {
    require_once '../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../classes/Pagina/Pagina.php';

    require_once __DIR__ . '/../utils/Utils.php';

    require_once __DIR__ . '/../classes/Usuario/Usuario.php';
    require_once __DIR__ . '/../classes/Usuario/UsuarioRN.php';
    require_once __DIR__ . '/../classes/Mesa/Mesa.php';
    require_once __DIR__ . '/../classes/Mesa/MesaRN.php';

    require_once __DIR__ . '/../classes/Pedido/Pedido.php';
    require_once __DIR__ . '/../classes/Pedido/PedidoRN.php';


    Sessao::getInstance()->validar();

    $objPedido = new Pedido();
    $objPedidoRN = new PedidoRN();

    date_default_timezone_set('America/Sao_Paulo');
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();

    $objMesa = new Mesa();
    $objMesaRN = new MesaRN();

    $html_mesas = '';
    $mesas = $objMesaRN->listar($objMesa);
    foreach ($mesas as $mesa) {
        if ((in_array(Sessao::getInstance()->getIdUsuario(), $mesa->getIdFuncionario()) && $mesa->getIdFuncionario() != null) || $_SESSION['TANAMESA']['PERFIL'] == PerfilUsuarioRN::$PU_ADMINISTRADOR) {
            if ($mesa->getBoolPrecisaFunc()) {
                $html_mesas .= '<div class="col-xl-3 col-md-6">
                                    <div class="card bg-warning text-white mb-4">
                                        <div class="card-body"> Mesa ' . $mesa->getIdMesa() . ' (AGUARDANDO GARÇOM)</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_pedido&idMesa=' . $mesa->getIdMesa()) . '">Ver Pedido</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>';
            }

            if ($mesa->getDisponivel() && !$mesa->getEsperandoPedido() && !$mesa->getBoolPrecisaFunc()) {
                $html_mesas .= '<div class="col-xl-3 col-md-6">
                                    <div class="card bg-success text-white mb-4">
                                        <div class="card-body"> Mesa ' . $mesa->getIdMesa() . ' (DISPONÍVEL)</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link links_cards" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_pedido&idMesa=' . $mesa->getIdMesa()) . '"> Fazer pedido  </a>
                                            <div class="small text-white"></div>
                                        </div>
                                    </div>
                                </div>';
            }

            if (!$mesa->getDisponivel() && !$mesa->getBoolPrecisaFunc()) {
                $html_mesas .= '<div class="col-xl-3 col-md-6">
                                    <div class="card bg-danger text-white mb-4">
                                        <div class="card-body"> Mesa ' . $mesa->getIdMesa() . ' (OCUPADA)</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_pedido&idMesa=' . $mesa->getIdMesa() . '&idPedido=' . $mesa->getIdPedido()) . '">Ver Pedido</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>';
            }
        }
    }
}catch (Throwable $e){
    die($e);
    Pagina::getInstance()->processar_excecao($e);
}

//$objUsuario->setIdUsuario(Sessao::getInstance()->getCPF());
//$objUsuario = $objUsuarioRN->consultar($objUsuario);

Pagina::abrir_head("TÁ NA MESA");
//Pagina::getInstance()->adicionar_javascript("chart_area_pedidos");
?>
    <!-- chart dos pedidos por dia -->
    <script type="text/javascript">
        //setInterval(verificarAmostras, 3000);
        //function verificarAmostras(){
        $.ajax({
            url: "<?=Sessao::getInstance()->assinar_link('controlador.php?action=ver_pedidos_dia') ?>",
            success: function (result) {
                //alert(result);
                //Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                //Chart.defaults.global.defaultFontColor = '#292b2c';


                // Area Chart Example
                var ctx = document.getElementById("myAreaChart");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: result['mes'],
                        datasets: [{
                            label: "Pedidos",
                            lineTension: 0.3,
                            backgroundColor: "rgba(2,117,216,0.2)",
                            borderColor: "rgba(2,117,216,1)",
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(2,117,216,1)",
                            pointBorderColor: "rgba(255,255,255,0.8)",
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(2,117,216,1)",
                            pointHitRadius: 50,
                            pointBorderWidth: 2,
                            data:result['qntPedidos'],
                        }],
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: 15,
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    color: "rgba(0, 0, 0, .125)",
                                }
                            }],
                        },
                        legend: {
                            display: false
                        }
                    }
                });

            }});
        //}
        //alert(<?php echo $res;?>);

    </script>
<?php
Pagina::fechar_head();
Pagina::abrir_body();
Pagina::getInstance()->montar_menu_topo();

Pagina::abrir_lateral();

echo '    
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                       
                        <div class="row" >
                            '.$html_mesas.'

                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Pedidos por dia <small style="color: grey;">*Últimos 7 dias</small></div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%"  height="40"></canvas></div>
                                    <div class="card-footer small text-muted">Atualizado hoje às '.date("H:i:s").'</div>
                                </div>
                                
                            </div>
                           <!-- <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Bar Chart Example</div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>-->
                        </div>
                    </div>';




/*
echo
    '<div class="conjunto_itens">';

        <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_mesa')) {
                echo '   <div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_mesa').'">CADASTRO MESA</a>          
                        </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_mesa')) {
                echo '<div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_mesa').'">LISTAR MESA</a>          
                        </div>';
            }
    echo'</div>';

echo'    <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_perfil_usuario')) {
                echo '       <div class="col-md-6">
                                <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_perfil_usuario').'">CADASTRAR PERFIL USUÁRIO</a>          
                            </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_perfil_usuario')) {
                echo '       <div class="col-md-6">
                            <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_perfil_usuario') . '">LISTAR PERFIL USUÁRIO</a>          
                        </div>';
            }
echo'</div>';

echo'        <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_recurso')) {
                echo '            <div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_recurso') . '">CADASTRAR RECURSO</a>          
                        </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_recurso')) {
                echo '            <div class="col-md-6">
                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_recurso') . '">LISTAR RECURSO</a>          
                    </div>';
            }
echo'        </div>';

echo'         <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_usuario')) {
                echo '             <div class="col-md-6">
                     <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_usuario') . '">CADASTRAR USUÁRIO</a>          
                </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_usuario')) {
                echo '<div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario') . '">LISTAR USUÁRIO</a>          
                        </div>';
            }
echo'         </div>';


        
echo'         <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_usuario_perfilUsuario')) {
                echo '<div class="col-md-6">
                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_usuario_perfilUsuario') . '">CADASTRAR USUÁRIO+PERFIL</a>          
                        </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_usuario_perfilUsuario')) {
                echo ' <div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario_perfilUsuario') . '">LISTAR USUÁRIO+PERFIL</a>          
                        </div>';
            }
echo' </div>';

echo'       <div class="row">';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_perfilUsuario_recurso')) {
                echo '<div class="col-md-6">
                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_perfilUsuario_recurso') . '">CADASTRAR PERFIL USUÁRIO+RECURSO</a>          
                      </div>';
            }
            if(Sessao::getInstance()->verificar_permissao('listar_perfilUsuario_recurso')) {
                    echo '  <div class="col-md-6">
                                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_perfilUsuario_recurso') . '">LISTAR PERFIL USUÁRIO+RECURSO</a>          
                            </div>';
                }
echo'        </div>';

echo'       <div class="row">';
                if(Sessao::getInstance()->verificar_permissao('gerar_QRCode')) {
                    echo '<div class="col-md-12">
                                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=gerar_QRCode') . '">GERAR QRCode</a>          
                                      </div>';
                }
echo'        </div>';

echo'       <div class="row">';
if(Sessao::getInstance()->verificar_permissao('cadastrar_ingrediente')) {
        echo '<div class="col-md-6">
                 <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_ingrediente') . '">CADASTRAR INGREDIENTE</a>          
              </div>';
}
if(Sessao::getInstance()->verificar_permissao('listar_ingrediente')) {
        echo '  <div class="col-md-6">
                     <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_ingrediente') . '">LISTAR INGREDIENTE</a>          
                </div>';
}
echo'        </div>';

echo'       <div class="row">';
        if(Sessao::getInstance()->verificar_permissao('cadastrar_prato')) {
            echo '<div class="col-md-6">
                         <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_prato') . '">CADASTRAR PRATO</a>          
                      </div>';
        }
        if(Sessao::getInstance()->verificar_permissao('listar_prato')) {
            echo '  <div class="col-md-6">
                             <a  class="btn btn-primary" STYLE="margin-top: 17px;width: 100%;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_prato') . '">LISTAR PRATO</a>          
                        </div>';
        }
echo'        </div>';


echo'    </div>';

*/

Pagina::fechar_lateral();
Pagina::footer();
?>
    <!--<script src="js/chart_area_pedidos.js"></script>-->
<?php
Pagina::fechar_body();
Pagina::fechar_html();


