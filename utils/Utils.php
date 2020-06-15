<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
class Utils{
    
    private static $instance;
    
    public static  function getInstance(){
        if(self::$instance == null){
            self::$instance= new Utils();
        }
        return self::$instance;
    }
    
        
    function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(Ç)/","/(ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
    }

    public static function validarData($dataPassada,$objExcecao)
    {

        $atual = date("Y-m-d");

        if ($dataPassada > $atual) {
            //echo $dataPassada . " > " . $atual . "\n";
            $objExcecao->adicionar_validacao('A data informada é maior que a data atual', 'idDataHora', 'alert-danger');
        } else {
            //echo $dataPassada . " <= " . $atual . "\n";
        }
    }

    public static function getStrMes($strMes){
        if($strMes == '01') { return ' Jan ';}
        if($strMes == '02') { return ' Fev ';}
        if($strMes == '03') { return ' Mar ';}
        if($strMes == '04') { return ' Abr ';}
        if($strMes == '05') { return ' Mai ';}
        if($strMes == '06') { return ' Jun ';}
        if($strMes == '07') { return ' Jul ';}
        if($strMes == '08') { return ' Ago ';}
        if($strMes == '09') { return ' Set ';}
        if($strMes == '10') { return ' Out ';}
        if($strMes == '11') { return ' Nov ';}
        if($strMes == '12') { return ' Dez ';}
    }

    public static function getLastSevenDaysWithStr(){

        $diaSete = date('d/m/Y', strtotime('-7 days'));
        $diaSeis = date('d/m/Y', strtotime('-6 days'));
        $diaCinco = date('d/m/Y', strtotime('-5 days'));
        $diaQuatro = date('d/m/Y', strtotime('-4 days'));
        $diaTres = date('d/m/Y', strtotime('-3 days'));
        $diaDois = date('d/m/Y', strtotime('-2 days'));
        $diaUm = date('d/m/Y', strtotime('-1 days'));


        $dataSete = explode('/',$diaSete);
        $dataSeis = explode('/',$diaSeis);
        $dataCinco = explode('/',$diaCinco);
        $dataQuatro = explode('/',$diaQuatro);
        $dataTres = explode('/',$diaTres);
        $dataDois = explode('/',$diaDois);
        $dataUm = explode('/',$diaUm);

        $mesDiaSete = Utils::getStrMes($dataSete[1]);
        $mesDiaSeis = Utils::getStrMes($dataSeis[1]);
        $mesDiaCinco = Utils::getStrMes($dataCinco[1]);
        $mesDiaQuatro = Utils::getStrMes($dataQuatro[1]);
        $mesDiaTres = Utils::getStrMes($dataTres[1]);
        $mesDiaDois = Utils::getStrMes($dataDois[1]);
        $mesDiaUm = Utils::getStrMes($dataUm[1]);


        $arr_dias[] = $mesDiaSete . $dataSete[0];
        $arr_dias[] = $mesDiaSeis . $dataSeis[0];
        $arr_dias[] = $mesDiaCinco . $dataCinco[0];
        $arr_dias[] = $mesDiaQuatro . $dataQuatro[0];
        $arr_dias[] = $mesDiaTres . $dataTres[0];
        $arr_dias[] = $mesDiaDois . $dataDois[0];
        $arr_dias[] = $mesDiaUm . $dataUm[0];


        return $arr_dias;

    }

    public static function getLastSevenDays(){

        $diaSete = date('d/m/Y', strtotime('-7 days'));
        $diaSeis = date('d/m/Y', strtotime('-6 days'));
        $diaCinco = date('d/m/Y', strtotime('-5 days'));
        $diaQuatro = date('d/m/Y', strtotime('-4 days'));
        $diaTres = date('d/m/Y', strtotime('-3 days'));
        $diaDois = date('d/m/Y', strtotime('-2 days'));
        $diaUm = date('d/m/Y', strtotime('-1 days'));


        $dataSete = explode('/',$diaSete);
        $dataSeis = explode('/',$diaSeis);
        $dataCinco = explode('/',$diaCinco);
        $dataQuatro = explode('/',$diaQuatro);
        $dataTres = explode('/',$diaTres);
        $dataDois = explode('/',$diaDois);
        $dataUm = explode('/',$diaUm);

        $arr_dias[] = $dataSete[0];
        $arr_dias[] = $dataSeis[0];
        $arr_dias[] =  $dataCinco[0];
        $arr_dias[] =  $dataQuatro[0];
        $arr_dias[] =$dataTres[0];
        $arr_dias[] =  $dataDois[0];
        $arr_dias[] = $dataUm[0];

        return $arr_dias;

    }

    static function random_color() {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for($i = 0; $i < 6; $i++) {
            $index = rand(0,15);
            $color .= $letters[$index];
        }
        return $color;
    }
}
