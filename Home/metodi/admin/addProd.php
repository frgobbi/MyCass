<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 20/02/2018
 * Time: 23:40
 */
$nome = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_STRING);
$prezzo =filter_input(INPUT_POST,"prezzo",FILTER_SANITIZE_STRING);
$categoria =filter_input(INPUT_POST,"categoria",FILTER_SANITIZE_STRING);
$disp = filter_input(INPUT_POST,"disp",FILTER_SANITIZE_STRING);
$ingQ =filter_input(INPUT_POST,"ingQ",FILTER_SANITIZE_STRING);
$ingredienti = array();
if($ingQ==1) {
    foreach ($_POST['ingredienti'] as $r) {
        $ingredienti[] = $r;

    }
}
include "../../../connessione.php";
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
        $connessione->exec("INSERT INTO `prodotto`(`id_prodotto`, `nome_p`, `prezzo`, `disp`, `id_cat_prodotto`, `flag_ing`) VALUE (NULL,'$nome','$prezzo','$disp','$categoria','$ingQ')");
        if($ingQ==1){
            $oggP = $connessione->query("SELECT * FROM  prodotto WHERE nome_p = '$nome'")->fetch(PDO::FETCH_OBJ);
            for($i=0;$i<count($ingredienti);$i++){
                $id_i = $ingredienti[$i];
                $connessione->exec("INSERT INTO prod_ing (id_prodotto, id_ing) VALUE ('$oggP->id_prodotto','$id_i')");
            }
        }
    }
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
echo "<script type='text/javascript'>window.location.href='../../home.php'</script>";