<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 20/02/2018
 * Time: 00:35
 */
$nome = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_STRING);
$colore =filter_input(INPUT_POST,"colore",FILTER_SANITIZE_STRING);
include "../../../connessione.php";
try{
    $nFilter = strtoupper($nome);
    $trovato = 0;
    foreach ($connessione->query("SELECT * FROM cat_prodotto") as $row){
        $nRic = strtoupper($row['nome_cat']);
        if(strcmp($nFilter,$nRic)==0){
            $trovato = 1;
        }
    }
    if($trovato == 0){
        $nome = ucfirst($nome);
        $connessione->exec("INSERT INTO cat_prodotto (id_cat_prodotto,nome_cat,colore) VALUE (NULL,'$nome','$colore')");
    }
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
echo "<script type='text/javascript'>window.location.href='../../home.php'</script>";