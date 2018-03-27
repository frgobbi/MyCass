<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 12/03/2018
 * Time: 23:08
 */
session_start();
$lettere = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$username = $_SESSION['user'];
$num = filter_input(INPUT_POST, "num_P", FILTER_SANITIZE_STRING);
$tipo = filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_STRING);
$nominativo = filter_input(INPUT_POST,"nominativo",FILTER_SANITIZE_STRING);
$trovato= false;
$code = "";
$sql = "";
$Ncomanda = "";
$codeBar = "";
$numO = 0;
$esito = 0;
$id_prodotti = array();
$prezzi = array();
$quant = array();
$desc = array();
$ing = array();
for ($i = 0; $i < $num; $i++) {
    $keyId = "id" . $i;
    $keyPrezzi = "prezzi" . $i;
    $keyQuant = "quant" . $i;
    $keyDesc = "desc" . $i;
    $keyIng = "prod_i".$i;
    $id_prodotti[] = filter_input(INPUT_POST, $keyId, FILTER_SANITIZE_STRING);
    $prezzi[] = filter_input(INPUT_POST, $keyPrezzi, FILTER_SANITIZE_STRING);
    $quant[] = filter_input(INPUT_POST, $keyQuant, FILTER_SANITIZE_STRING);
    $desc[] = filter_input(INPUT_POST, $keyDesc, FILTER_SANITIZE_STRING);
    $ing[] = filter_input(INPUT_POST, $keyIng, FILTER_SANITIZE_STRING);
}
/*echo "$tipo<br>";
for($i=0;$i<$num;$i++) {
    echo $id_prodotti[$i] . "<br>";
    echo $prezzi[$i] . "<br>";
    echo $quant[$i] . "<br>";
    echo $desc[$i] . "<br>";
}*/
include "../../connessione.php";
try {
    //AVVIO TRANSAZIONI
    $connessione->beginTransaction();
    //RECUPERO DATI GIORNATA E COMANDA
    $oggGiornata = $connessione->query("SELECT * FROM giorno WHERE chiuso = 0")->fetch(PDO::FETCH_OBJ);
    $oggMaxCom = $connessione->query("SELECT MAX(id_comanda) AS numero FROM `comanda` WHERE id_giorno = '$oggGiornata->id_giorno'")->fetch(PDO::FETCH_OBJ);
    //DEFINISCO LA VARIABILE CON IL NUMERO ORDINE
    $numO = 0;
    if($oggMaxCom->numero == NULL){
        $numO = 1;
    } else {
        $numO = $oggMaxCom->numero+1;
    }
    $strGiorno = numCifre($oggGiornata->id_giorno);
    $strComanda = numCifre($numO);
    //CREA LE ULTIME 4 CIFRE E CONTROLLA SE IL CODICE è GIA' PRESENTE NEL DB CASO POSITIVO LO INSERISCO
    do {
        $trovato = false;

        $a = rand(0, 25);
        $b = rand(0, 25);
        $c = rand(0, 25);
        $d = rand(0, 25);
        $code = $strGiorno.$lettere[$a].$lettere[$b].$lettere[$c].$lettere[$d];

        foreach ($connessione->query("SELECT * FROM `comanda`") as $row){
            if(strcmp($code,$row['code_c'])==0){
                $trovato = true;
            }
        }
    } while ($trovato== true);
    if(strcmp($nominativo,"")!=0){
        $Ncomanda = $nominativo;
    } else{
        $Ncomanda = "Scontrino N. $numO";
    }
    //controllo se ci sono prodotti con ing
    $controlloing = 0;
    for($i=0;$i<$num;$i++){
        if($ing[$i]==1){
            $controlloing = 1;
        }
    }
    //NORMALE
    if($tipo == 0){
        $sql = "INSERT INTO comanda (id_comanda, nome_comanda, id_giorno, code_C, ora_c, flag_b, flag_pos,evasa) VALUE ('$numO','$Ncomanda','$oggGiornata->id_giorno','$code',NOW(),0,0,'$controlloing')";
    } else {
        //BUONO SCONTO
        if($tipo == 1){
            $sql = "INSERT INTO comanda (id_comanda, nome_comanda, id_giorno, code_C, ora_c, flag_b, flag_pos,evasa) VALUE ('$numO','$Ncomanda','$oggGiornata->id_giorno','$code',NOW(),1,0,'$controlloing')";
        } else {
            //POSS
            $sql = "INSERT INTO comanda (id_comanda, nome_comanda, id_giorno, code_C, ora_c, flag_b, flag_pos,evasa) VALUE ('$numO','$Ncomanda','$oggGiornata->id_giorno','$code',NOW(),0,1,'$controlloing')";
        }
    }
    //CREAZIONE DELLA COMANDA
    $connessione->exec($sql);
    if($controlloing==1) {
        //CREAZIONE DEL BAR CODE
        $codeBar = $code;
    }
    //INSERIMENTO PRODOTTI NELL'ORDINE
    for ($i = 0; $i < $num; $i++) {
        for ($j = 0; $j < $quant[$i]; $j++) {
            if (strcmp($desc[$i], "Varie") != 0) {
                $insert = "INSERT INTO ordine(id_ord, username, id_prodotto, id_comanda) VALUE (NULL,'$username','$id_prodotti[$i]','$numO')";
                $connessione->exec($insert);
            } else {
                $valore = doubleval($prezzi[$i]);
                $insert = "INSERT INTO ordine_v (id_ord, username, importo, id_comanda) VALUE (NULL,'$username','$valore','$numO')";
                $connessione->exec($insert);
            }
        }
    }

    //CONFERMA TRANSAZIONE
    $connessione->commit();
} catch (PDOException $e) {
    //ANNULLAMENTO TRANSAZIONI
    $connessione->rollBack();
    $esito = 1;
    echo $e->getMessage();
}
$connessione = null;
$a_esito = array("esito"=>$esito,"ingredienti"=>$controlloing,"codComanda"=>$codeBar,"NomeC"=>$Ncomanda,"numO"=>$numO);
echo json_encode($a_esito);

function numCifre($numero){
    $esito = "";
    if ($numero < 10) {
        $esito = "000" . $numero;
    } else {
        if ($numero <100) {
            $esito = "00" . $numero;
        } else{
            if($numero <1000){
                $esito = "0" . $numero;
            } else {
                $esito = $numero;
            }
        }
    }
    return $esito;
}
