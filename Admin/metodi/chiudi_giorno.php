<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 07/04/2018
 * Time: 11:47
 */
$esito = 0;
$giorno = null;
include "../../connessione.php";
try{
    $giorno = $connessione->query("SELECT * FROM giorno WHERE chiuso = 0")->fetch(PDO::FETCH_OBJ);

    $oggI_Prod = $connessione->query("SELECT SUM(prezzo) as Totale FROM `ordine` INNER JOIN comanda ON ordine.id_comanda = comanda.id_comanda INNER JOIN prodotto ON ordine.id_prodotto = prodotto.id_prodotto WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b='0' AND comanda.flag_pos='0'")->fetch(PDO::FETCH_OBJ);
    $oggI_varie = $connessione->query("SELECT SUM(importo) as Totale FROM `ordine_v` INNER JOIN comanda ON ordine_v.id_comanda = comanda.id_comanda WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b=0 AND comanda.flag_pos=0")->fetch(PDO::FETCH_OBJ);

    $oggI_POS_Prod = $connessione->query("SELECT SUM(prezzo) as Totale FROM `ordine` INNER JOIN comanda ON ordine.id_comanda = comanda.id_comanda INNER JOIN prodotto ON ordine.id_prodotto = prodotto.id_prodotto WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b='0' AND comanda.flag_pos='1'")->fetch(PDO::FETCH_OBJ);
    $oggI_POS_varie = $connessione->query("SELECT SUM(importo) as Totale FROM `ordine_v` INNER JOIN comanda ON ordine_v.id_comanda = comanda.id_comanda WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b=0 AND comanda.flag_pos=1")->fetch(PDO::FETCH_OBJ);

    $Totale = doubleval($oggI_Prod->Totale)+doubleval($oggI_varie->Totale)+doubleval($oggI_POS_Prod->Totale)+doubleval($oggI_POS_varie->Totale);

   $connessione->exec("UPDATE `giorno` SET `incasso`= '$Totale',`chiuso`= '1' WHERE id_giorno = '$giorno->id_giorno'");
} catch (PDOException $e){
    $esito = 1;
}
$connessione = null;
$arrEsito = array("esito"=>$esito, "id_G"=>$giorno->id_giorno);
echo json_encode($arrEsito);