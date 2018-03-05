<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 03/03/2018
 * Time: 18:32
 */
$id_utente = filter_input(INPUT_POST,"id_u",FILTER_SANITIZE_STRING);
$oggU = null;
$cat = array();
include "../../connessione.php";
try{
    $oggU = $connessione->query("SELECT * FROM utente WHERE username = '$id_utente'")->fetch(PDO::FETCH_OBJ);
    foreach ($connessione->query("SELECT * FROM cat_utente WHERE id_cat != 1") as $row){
        $cat[] = array($row['id_cat'],$row['nome_cat']);
    }
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
$esito = array("utente"=>$oggU,"cat"=>$cat);
echo json_encode($esito);