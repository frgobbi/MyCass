<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 24/02/2018
 * Time: 14:18
 */
$id_cat = filter_input(INPUT_POST, "id_cat", FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
$colore = filter_input(INPUT_POST, "colore", FILTER_SANITIZE_STRING);
$esito = 0;
include "../../connessione.php";
try {
    $connessione->exec("UPDATE cat_prodotto SET nome_cat = '$nome', colore = '$colore' WHERE id_cat_prodotto = '$id_cat'");
} catch (PDOException $e) {
    echo $e->getMessage();
    $esito =1;
}
$connessione = null;
echo $esito;