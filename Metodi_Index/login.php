<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 16/02/2018
 * Time: 15:29
 */
session_start();
$esito = 0;
include "../connessione.php";
$id_utente = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
$pass = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);
try {
    $utente = $connessione->query("SELECT * FROM `utente` WHERE `username` = '$id_utente'")->fetch(PDO::FETCH_OBJ);
    //$connessione->exec("");
    if (!$utente) {
        $esito = 1;
    } else {
        if (password_verify($pass, $utente->pwd)) {
            echo $esito;
            $_SESSION['login'] = TRUE;
            $_SESSION['cat']=$utente->id_cat;
            $_SESSION['nom_utente'] = $utente->nome . " " . $utente->cognome;
            $_SESSION['user'] = $utente->username;
        } else {
            $esito = 1;
        }

    }
} catch (PDOException $e) {
    echo "error:" . $e;
    $esito = 1;
}
$connessione = null;
echo $esito;