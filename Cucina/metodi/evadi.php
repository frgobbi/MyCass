<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 30/03/2018
 * Time: 19:27
 */
$numeroCK = filter_input(INPUT_POST,"numeroC",FILTER_SANITIZE_STRING);
$stringa = filter_input(INPUT_POST,"str", FILTER_SANITIZE_STRING);
$tipo = filter_input(INPUT_POST,"tipo",FILTER_SANITIZE_STRING);
$check = array();
for($i=0;$i<$numeroCK;$i++){
    $key = "CK".$i;
    $check[] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_STRING);
}
$esito =0;
    include "../../connessione.php";
    try{
        $connessione->beginTransaction();
        if($tipo == 0){
            $connessione->exec("UPDATE `comanda` SET `evasa` = '1' WHERE comanda.code_c = '$stringa'");
        } else {
            for($i=0;$i<count($check);$i++){
                $var = $check[$i];
                $connessione->exec("UPDATE `comanda` SET `evasa` = '1' WHERE comanda.code_c = '$var'");
            }
        }
        $connessione->commit();
    } catch (PDOException $pdo){
        $connessione->rollBack();
        $esito = 1;
    }
    $connessione = null;
echo $esito;