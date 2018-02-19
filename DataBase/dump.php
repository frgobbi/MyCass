<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 18/02/2018
 * Time: 00:46
 */
$pwd = "123456";
$pwd_cript = password_hash($pwd,PASSWORD_BCRYPT);

$cat_utente = "INSERT INTO cat_utente(id_cat, nome_cat, colore, logo) VALUE (NULL,'admin','',''),(NULL,'cassa','',''),(NULL,'cucina','','')";
$utente = "INSERT INTO utente(username, nome, cognome, id_cat, pwd) VALUE ('admin','admin','admin',1,'$pwd_cript'),('cassa','cassa','cassa',2,'$pwd_cript'),('cucina','cucina','cucina',3,'$pwd_cript')";

include "../connessione.php";
try{
    $connessione->exec($cat_utente);
    $connessione->exec($utente);
    echo "DATI INSERITI";
}catch (PDOException $e){
    echo "DATI NON INSERITI";
}