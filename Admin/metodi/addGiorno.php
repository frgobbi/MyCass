<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 01/03/2018
 * Time: 20:02
 */

/*
 * Esiti
 * 0 giorno aggiunto
 * 1 giorno già presente
 * 2 chiudre giorni
 */
$data_n = date('Y-m-d');
$data_n .="%";
$esito = 0;
$newG=null;
include "../../connessione.php";
try{
    $oggD = $connessione->query("SELECT * FROM `giorno` WHERE data_g = '$data_n'")->fetch(PDO::FETCH_OBJ);
    if($oggD!=null){
        $esito = 1;
    }

    $chiuso = 0;
    foreach ($connessione->query("SELECT * FROM `giorno`") as $row){
        if($row['chiuso']==0){
            $chiuso = 1;
        }
    }

    if ($chiuso == 1){
        $esito = 2;
    }

    if($esito==0){
        $connessione->exec("INSERT INTO `giorno` (`id_giorno`, `data_g`, `incasso`, `chiuso`) VALUES (NULL, NOW(), '0', '0')");
        $newG = $connessione->query("SELECT DATE_FORMAT(data_g, '%d-%m-%Y') AS data_giorno, incasso, chiuso FROM giorno WHERE data_g = '$data_n'")->fetch(PDO::FETCH_OBJ);
    }
}catch (PDOException $e){
 echo $e->getMessage();
}
$connessione = null;
$array_e = array("esito"=>$esito,"new_g"=>$newG);
echo json_encode($array_e);