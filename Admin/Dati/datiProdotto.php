<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 24/02/2018
 * Time: 15:39
 */
$id_prod = filter_input(INPUT_POST, "id_prod", FILTER_SANITIZE_STRING);
include "../../connessione.php";
$oggP = null;
$aCat = array();
$aIng = array();
$aIngY = array();
try {
    $oggP = $connessione->query("SELECT * FROM prodotto WHERE id_prodotto = $id_prod")->fetch(PDO::FETCH_OBJ);
    foreach ($connessione->query("SELECT * FROM cat_prodotto") AS $row){
        $aCat[] = array($row['id_cat_prodotto'],$row['nome_cat']);
    }
    foreach ($connessione->query("SELECT * FROM ingredienti") AS $row){
        $aIng[] = array($row['id_ing'],$row['nome_ing']);
    }
    foreach ($connessione->query("SELECT * FROM prod_ing WHERE id_prodotto = '$id_prod'") AS $row){
        $aIngY[] = array($row['id_ing'],$row['id_prodotto']);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
$esito = array('prodotto'=>$oggP,'arrayC'=>$aCat,'arrayI'=>$aIng,'IngS'=>$aIngY);
echo json_encode($esito);
$connessione = null;