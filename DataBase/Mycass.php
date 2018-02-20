<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 17/02/2018
 * Time: 18:01
 */
$cat_utente = "CREATE TABLE cat_utente("
    . "id_cat INT PRIMARY KEY AUTO_INCREMENT,"
    . "nome_cat VARCHAR(255),"
    . "colore VARCHAR(255),"
    . "logo VARCHAR(255)"
    . ")";

$utente = "CREATE TABLE utente("
    . "username VARCHAR(255) PRIMARY KEY,"
    . "nome VARCHAR(255),"
    . "cognome VARCHAR(255),"
    . "id_cat INT,"
    . "FOREIGN KEY (id_cat) REFERENCES cat_utente(id_cat),"
    . "pwd VARCHAR(255)"
    . ")";

$cat_prodotto = "CREATE TABLE cat_prodotto("
    . "id_cat_prodotto INT PRIMARY KEY AUTO_INCREMENT,"
    . "nome_cat VARCHAR(255),."
    . "colore VARCHAR(255)"
    . ")";

$prodotto = "CREATE TABLE prodotto("
    . "id_prodotto INT PRIMARY KEY AUTO_INCREMENT,"
    . "nome_p VARCHAR(255),"
    . "prezzo DOUBLE,"
    . "disp INT NOT NULL DEFAULT '0',"
    . "id_cat_prodotto INT,"
    . "FOREIGN KEY (id_cat_prodotto) REFERENCES cat_prodotto(id_cat_prodotto),"
    . "flag_ing INT NOT NULL DEFAULT '0'"
    . ")";

$ingredienti = "CREATE TABLE ingredienti ("
    . "id_ing INT PRIMARY KEY AUTO_INCREMENT,"
    . "  nome_ing VARCHAR(255)"
    . ")";

$prod_ing = "CREATE TABLE prod_ing("
    . "id_prodotto INT,"
    . "FOREIGN KEY (id_prodotto) REFERENCES prodotto(id_prodotto),"
    . "id_ing INT,"
    . "FOREIGN KEY (id_ing) REFERENCES ingredienti(id_ing)"
    . ")";

$giorno = "CREATE TABLE giorno("
    . "id_giorno INT PRIMARY KEY AUTO_INCREMENT,"
    . "data_g DATE,"
    . "incasso DOUBLE NOT NULL DEFAULT '0',"
    . "chiuso INT NOT NULL DEFAULT '0'"
    . ")";

$comanda = "CREATE TABLE comanda ("
    . "id_comanda INT PRIMARY KEY AUTO_INCREMENT,"
    . "nome_comanda VARCHAR(255),"
    . "code_C VARCHAR(255) UNIQUE,"
    . "ora_c TIME,"
    . "flag_b INT NOT NULL DEFAULT '0',"
    . "flag_pos INT NOT NULL DEFAULT '0'"
    . ")";

$ordine = "CREATE TABLE ordine ("
    . "id_ord INT PRIMARY KEY AUTO_INCREMENT,"
    . "username VARCHAR(255),"
    . "FOREIGN KEY (username) REFERENCES utente(username),"
    . "id_prodotto INT,"
    . "FOREIGN KEY (id_prodotto) REFERENCES prodotto(id_prodotto),"
    . "id_comanda INT,"
    . "FOREIGN KEY (id_comanda) REFERENCES comanda(id_comanda),"
    . "id_giorno INT,"
    . "FOREIGN KEY (id_giorno) REFERENCES giorno(id_giorno)"
    . ")";

$ordine_v = "CREATE TABLE ordine_v ("
    . "id_ord INT PRIMARY KEY AUTO_INCREMENT,"
    . "username VARCHAR(255),"
    . "FOREIGN KEY (username) REFERENCES utente(username),"
    . "importo DOUBLE,"
    . "id_comanda INT,"
    . "FOREIGN KEY (id_comanda) REFERENCES comanda(id_comanda),"
    . "id_giorno INT,"
    . "FOREIGN KEY (id_giorno) REFERENCES giorno(id_giorno)"
    . ")";

include "../connessione.php";
try{
    $connessione->exec($cat_utente);
    $connessione->exec($utente);
    $connessione->exec($cat_prodotto);
    $connessione->exec($prodotto);
    $connessione->exec($ingredienti);
    $connessione->exec($prod_ing);
    $connessione->exec($giorno);
    $connessione->exec($comanda);
    $connessione->exec($ordine);
    $connessione->exec($ordine_v);
    echo "TABELLE CREATE";
}catch (PDOException $e){
    echo "C\'E\' stato un errore";
}