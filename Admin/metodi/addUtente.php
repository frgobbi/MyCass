<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 02/03/2018
 * Time: 14:21
 */
$username = filter_input(INPUT_POST,"user",FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_STRING);
$cognome = filter_input(INPUT_POST,"cognome",FILTER_SANITIZE_STRING);
$cat = filter_input(INPUT_POST,"cat",FILTER_SANITIZE_STRING);
$pwd = filter_input(INPUT_POST,"pwd",FILTER_SANITIZE_STRING);
$esito = 0;
$oggU = null;
include "../../connessione.php";
try{
    if(strcmp($user,"")!=0){
        $esiste = 0;
        foreach ($connessione->query("SELECT * FROM utente") as $row){
            if(strcmp($row['username'],$username)==0){
                $esiste = 1;
            }
        }
        if($esiste == 0){
            $pwd_cript = password_hash($pwd,PASSWORD_BCRYPT);
            $connessione->query("INSERT INTO utente (username, nome, cognome, id_cat, pwd) VALUE ('$username','$nome','$cognome','$cat','$pwd_cript')");
            $oggU = $connessione->query("SELECT * FROM utente INNER JOIN cat_utente ON utente.id_cat = cat_utente.id_cat WHERE username = '$username'")->fetch(PDO::FETCH_OBJ);
        } else{
            $esito = 1;
        }
    } else {
        $esito = 1;
    }
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
$arr = array("esito"=>$esito,"ogg"=>$oggU);
echo json_encode($arr);