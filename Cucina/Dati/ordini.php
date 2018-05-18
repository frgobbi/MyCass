
<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 27/03/2018
 * Time: 21:15
 */
/*
 * R = rosso
 * G = giallo
 * N = Normale
 */
include "../../connessione.php";
$ordini = array();
$oggG = $connessione->query("SELECT * FROM giorno WHERE chiuso = 0")->fetch(PDO::FETCH_OBJ);
if($oggG = null) {
    foreach ($connessione->query("SELECT * FROM `comanda` WHERE id_giorno = '$oggG->id_giorno' AND evasa = 0") as $row) {
        $colore = "";
        //$id_ord = $row['id_comanda'];
        $cod = $row['code_c'];
        $ora = $row['ora_c'];
        $ora_now = date('H:i:s');
        $datetime1 = new DateTime($ora_now);
        $datetime2 = new DateTime($ora);
        $interval = $datetime1->diff($datetime2);
        $Hdiff = $interval->format('%H:%I:%S');
        $comp_h = explode(":", $Hdiff);
        if ($comp_h[0] >= 1) {
            $colore = "R";
        } else {
            if ($comp_h[1] >= 30) {
                $colore = "G";
            } else {
                $colore = "N";
            }
        }
        $ordini[] = array("codice" => $cod, "ora" => $ora, "colore" => $colore);
    }
    $sqlP = "SELECT prodotto.nome_p, COUNT(*) AS numero FROM `comanda` "
        . "INNER JOIN ordine ON comanda.id_comanda = ordine.id_comanda "
        . "INNER JOIN prodotto ON ordine.id_prodotto = prodotto.id_prodotto "
        . "WHERE id_giorno = '$oggG->id_giorno' AND evasa = 0 AND prodotto.flag_ing = 1 GROUP BY(prodotto.id_prodotto)";
    $prodotti = array();

    foreach ($connessione->query($sqlP) as $row) {
        $prodotti[] = array("prodotto" => $row['nome_p'], "numero" => $row['numero']);
    }
    $esito = array("trovato"=>1,"ordini"=>$ordini,"prodotti"=>$prodotti);
} else {
    $esito = array("trovato"=>0,"ordini"=>null,"prodotti"=>null);
}
$connessione = null;

echo json_encode($esito);

