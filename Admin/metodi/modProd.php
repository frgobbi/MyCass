<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 28/02/2018
 * Time: 18:55
 */
$id_p = filter_input(INPUT_GET,"id_prod",FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_STRING);
$prezzo =filter_input(INPUT_POST,"prezzo",FILTER_SANITIZE_STRING);
$categoria =filter_input(INPUT_POST,"categoria",FILTER_SANITIZE_STRING);
$disp = filter_input(INPUT_POST,"disp",FILTER_SANITIZE_STRING);
$ingQ =filter_input(INPUT_POST,"ingQM",FILTER_SANITIZE_STRING);
$ingredienti = array();
if($ingQ==1) {
    foreach ($_POST['ingredienti'] as $r) {
        $ingredienti[] = $r;

    }
}
include "../../connessione.php";
try{
    $nFilter = strtoupper($nome);
    $trovato = 0;
    foreach ($connessione->query("SELECT * FROM prodotto") as $row){
        $nRic = strtoupper($row['nome_p']);
        if(strcmp($nFilter,$nRic)==0){
            $trovato = 1;
        }
    }
    if($trovato == 0){
        $nome = ucfirst($nome);
        $connessione->exec("UPDATE prodotto SET nome_p = '$nome', prezzo = '$prezzo', disp = '$disp', id_cat_prodotto = '$categoria', flag_ing = '$ingQ' WHERE id_prodotto = '$id_p'");
    } else {
        $connessione->exec("UPDATE prodotto SET prezzo = '$prezzo', disp = '$disp', id_cat_prodotto = '$categoria', flag_ing = '$ingQ' WHERE id_prodotto = '$id_p'");
    }

    $connessione->exec("DELETE FROM prod_ing WHERE id_prodotto = '$id_p'");
    if($ingQ==1){
        for($i=0;$i<count($ingredienti);$i++){
            $id_i = $ingredienti[$i];
            $connessione->exec("INSERT INTO prod_ing (id_prodotto, id_ing) VALUE ('$id_p','$id_i')");
        }
    }
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
echo "<script type='text/javascript'>window.location.href='../admin.php'</script>";