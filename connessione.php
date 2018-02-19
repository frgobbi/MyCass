<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 15/11/2016
 * Time: 10:14
 */
$host = "localhost";
$user = "root";
$password = "";
$db = "mycass";
try {

    $connessione = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    // set the PDO error mode to exception
    $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e)
{
    /*Nel caso in cui venga lanciata un'eccezione, verrà restituito il messaggio
     * di errore corrispondente.
     */
    echo ("Connection failed: " . $e->getCode());
}

