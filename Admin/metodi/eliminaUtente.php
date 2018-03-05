<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 05/03/2018
 * Time: 23:47
 */
$username = filter_input(INPUT_POST,"id_u",FILTER_SANITIZE_STRING);
$esito = 0;

include "../../connessione.php";
try{
    $connessione->exec("DELETE FROM utente WHERE username = '$username'");
}catch (PDOException $e){
    $esito = 1;
    //echo $e->getMessage();
}
$connessione = null;
echo $esito;