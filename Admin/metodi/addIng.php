<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 20/02/2018
 * Time: 00:12
 */
$nome = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $nFilter = strtoupper($nome);
    $trovato = 0;
    foreach ($connessione->query("SELECT * FROM ingredienti") as $row){
        $nRic = strtoupper($row['nome_ing']);
        if(strcmp($nFilter,$nRic)==0){
            $trovato = 1;
        }
    }
    if($trovato == 0){
        $nome = ucfirst($nome);
        $connessione->exec("INSERT INTO ingredienti (id_ing,nome_ing) VALUE (NULL,'$nome')");
    }
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
echo "<script type='text/javascript'>window.location.href='../admin.php'</script>";