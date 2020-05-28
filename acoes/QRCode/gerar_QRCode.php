<?php

session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Mesa/Mesa.php';
    require_once __DIR__ . '/../../classes/Mesa/MesaRN.php';

    // Realizamos a importação da biblioteca para gerar QR Code.
    require_once __DIR__ . '/../../bibsExternas/phpqrcode/qrlib.php';

    $objMesaRN = new MesaRN();

    $arr_mesas = $objMesaRN->listar(new Mesa());

    // Realizamos um laço de repetição para percorrer cada registro retornado do DB.
    foreach ($arr_mesas as $value) {
    // Configuramos um nome único para o QR Code com base no número da matrícula.
        $qrCodeName = "mesa_{$value->getIdMesa()}.png";
        /**
         * Realizamos a criação da imagem PNG, sendo passado as seguintes informações:
         * 1º - A string que desejamos inserir no QR Code.
         * 2º - O nome da imagem que criamos no passo anterior.
         */
        QRcode::png($value->getIdMesa(), $qrCodeName);
    // Para finalizar realizamos a exibição da imagem no navegador.
        echo '<h3>ID DA MESA '.$value->getIdMesa().': </h3>';
        echo "<img width='150px' src='{$qrCodeName}'>";
    }

}catch(Throwable $e){
    die($e);
}
