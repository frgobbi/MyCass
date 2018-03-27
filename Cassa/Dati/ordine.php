<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 27/03/2018
 * Time: 10:49
 */
$num_ord = filter_input(INPUT_POST, "id_ord", FILTER_SANITIZE_STRING);
$id_giorno = filter_input(INPUT_POST, "id_giorno", FILTER_SANITIZE_STRING);
$arrayProd = array();
$arrayVarie = array();
$sql_p = "SELECT prodotto.nome_p, COUNT(*) AS num, prezzo FROM `ordine` "
    . "INNER JOIN comanda ON ordine.id_comanda = comanda.id_comanda "
    . "INNER JOIN prodotto ON ordine.id_prodotto = prodotto.id_prodotto "
    . "WHERE comanda.id_comanda = '$num_ord' AND comanda.id_giorno = '$id_giorno' GROUP BY(ordine.id_prodotto)";

$sql_v = "SELECT importo FROM `ordine_v` "
    . "INNER JOIN comanda ON ordine_v.id_comanda = comanda.id_comanda "
    . "WHERE comanda.id_comanda = 2 AND comanda.id_giorno = 1";
include "../../connessione.php";
try {
    foreach ($connessione->query($sql_p) as $row) {
        $arrayProd[] = array("nome_p" => $row['nome_p'], "num" => $row['num'], "prezzo" => $row['prezzo']);
    }
    foreach ($connessione->query($sql_v) as $row) {
        $arrayProd[] = array("nome_p" => "Varie", "num" => "1", "prezzo" => $row['importo']);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
$connessione = null;
$arrayEsito = array("prodotti"=>$arrayProd,"varie"=>$arrayVarie);
echo json_encode($arrayEsito);