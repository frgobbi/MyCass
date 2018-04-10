<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 23/03/2018
 * Time: 00:05
 */
include "../../connessione.php";
$arrayOrd = array();
$TotaleB = 0;
$TotaleN = 0;
$TotaleP = 0;
try {

    $giorno = $connessione->query("SELECT * FROM giorno WHERE chiuso = 0")->fetch(PDO::FETCH_OBJ);

    $oggI_Prod = $connessione->query("SELECT SUM(prezzo) as Totale FROM `ordine` INNER JOIN comanda ON ordine.id_comanda = comanda.id_comanda INNER JOIN prodotto ON ordine.id_prodotto = prodotto.id_prodotto WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b='0' AND comanda.flag_pos='0'")->fetch(PDO::FETCH_OBJ);
    $oggI_varie = $connessione->query("SELECT SUM(importo) as Totale FROM `ordine_v` INNER JOIN comanda ON ordine_v.id_comanda = comanda.id_comanda WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b=0 AND comanda.flag_pos=0")->fetch(PDO::FETCH_OBJ);

    $oggI_Buono_Prod = $connessione->query("SELECT SUM(prezzo) as Totale FROM `ordine` INNER JOIN comanda ON ordine.id_comanda = comanda.id_comanda INNER JOIN prodotto ON ordine.id_prodotto = prodotto.id_prodotto WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b='1' AND comanda.flag_pos='0'")->fetch(PDO::FETCH_OBJ);
    $oggI_Buono_varie = $connessione->query("SELECT SUM(importo) as Totale FROM `ordine_v` INNER JOIN comanda ON ordine_v.id_comanda = comanda.id_comanda WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b=1 AND comanda.flag_pos=0")->fetch(PDO::FETCH_OBJ);

    $oggI_POS_Prod = $connessione->query("SELECT SUM(prezzo) as Totale FROM `ordine` INNER JOIN comanda ON ordine.id_comanda = comanda.id_comanda INNER JOIN prodotto ON ordine.id_prodotto = prodotto.id_prodotto WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b='0' AND comanda.flag_pos='1'")->fetch(PDO::FETCH_OBJ);
    $oggI_POS_varie = $connessione->query("SELECT SUM(importo) as Totale FROM `ordine_v` INNER JOIN comanda ON ordine_v.id_comanda = comanda.id_comanda WHERE comanda.id_giorno = '$giorno->id_giorno' AND comanda.flag_b=0 AND comanda.flag_pos=1")->fetch(PDO::FETCH_OBJ);

    $TotaleN = doubleval($oggI_Prod->Totale)+doubleval($oggI_varie->Totale);
    $TotaleB = doubleval($oggI_Buono_Prod->Totale)+doubleval($oggI_Buono_varie->Totale);
    $TotaleP = doubleval($oggI_POS_Prod->Totale)+doubleval($oggI_POS_varie->Totale);

    foreach ($connessione->query("SELECT * FROM `comanda` WHERE id_giorno = '$giorno->id_giorno'") as $row){
        $arrayOrd[] = array(
            "num_o"=>$row['id_comanda'],
            "nome_comanda"=>$row['nome_comanda'],
            "ora"=>$row['ora_c']
            );
    }
}catch (PDOException $e){
    echo $e->getMessage();
}
$esito = array(
    "id_g"=>$giorno->id_giorno,
    "totN"=>$TotaleN,
    "totPOS"=>$TotaleP,
    "totBuono"=>$TotaleB,
    "ordini"=>$arrayOrd
);

echo json_encode($esito);