<?php
if($_POST['numeroMesa']){
    $arr = array("numeroMesa" => $_POST['numeroMesa']);

    //print_r($arr);
    $json = json_encode($arr);
    echo $json;
    echo "##";try{
        print_r(json_decode($json));
    }catch (Throwable $e){
        die($e);
    }

    //header('Location: controlador_rest.php?action_rest=cadastrar_mesa');

}

echo '<form action="index_rest.php" method="post">
    <!--ID: <input type="number" name="codigo">-->
    Número mesa: <input type="number" name="numeroMesa">
    Numero Lugares: <input type="number" name="numLugaresMesa">
    Situação mesa: <input type="text" name="situacaoMesa">
    <input type="submit" name="submit" value="INSERT">

</form>';