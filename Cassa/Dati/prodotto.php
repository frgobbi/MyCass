<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 11/03/2018
 * Time: 02:05
 */
$id_p = filter_input(INPUT_POST,"id_p",FILTER_SANITIZE_STRING);
$obj = null;
$aIng = array();
$aIngY = array();
include "../../connessione.php";
try{
    $obj = $connessione->query("SELECT * FROM prodotto WHERE id_prodotto = '$id_p'")->fetch(PDO::FETCH_OBJ);
    foreach ($connessione->query("SELECT * FROM ingredienti") AS $row){
        $aIng[] = array($row['id_ing'],$row['nome_ing']);
    }
    foreach ($connessione->query("SELECT * FROM prod_ing WHERE id_prodotto = '$id_p'") AS $row){
        $aIngY[] = array($row['id_ing'],$row['id_prodotto']);
    }
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
$esito = array('prodotto'=>$obj,'arrayI'=>$aIng,'IngS'=>$aIngY);
echo json_encode($esito);