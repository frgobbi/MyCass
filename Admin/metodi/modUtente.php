<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 05/03/2018
 * Time: 23:26
 */
$username = filter_input(INPUT_POST,"id_u",FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_STRING);
$cognome = filter_input(INPUT_POST,"cognome",FILTER_SANITIZE_STRING);
$cat = filter_input(INPUT_POST,"cat",FILTER_SANITIZE_STRING);
$pwd = filter_input(INPUT_POST,"pwd",FILTER_SANITIZE_STRING);
$esito = 0;

include "../../connessione.php";
try{
    $connessione->exec("UPDATE utente SET nome = '$nome', cognome='$cognome', id_cat='$cat' WHERE username = '$username'");
    if(strcmp($pwd,"")!=0){
        $pwd_cript = password_hash($pwd,PASSWORD_BCRYPT);
        $connessione->exec("UPDATE utente SET pwd='$pwd_cript' WHERE username = '$username'");
    }
}catch (PDOException $e){
    $esito = 1;
    //echo $e->getMessage();
}
$connessione = null;
echo $esito;