<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 22/02/2018
 * Time: 19:46
 */
echo "<table class='table table-bordered table-hovered'>"
    . "<thead>"
    . "<tr>"
    . "<th>Nome Cat</th>"
    . "<th>Colore</th>"
    . "<th>Modifica</th>"
    . "</tr>"
    . "</thead>"
    . "<tbody>";
$connessione = null;
include "../../connessione.php";
try {
    foreach ($connessione->query("SELECT * FROM cat_prodotto") as $row) {
        $id_cat = $row['id_cat_prodotto'];
        $nome_cat = $row['nome_cat'];
        $colore = $row['colore'];
        echo "<tr>"
            . "<td id='nome_$id_cat'>$nome_cat</td>";
        if (strcmp($colore, "bg-danger") == 0) {
            echo "<td id='colore_$id_cat'>Rosso</td>";
        } else {
            if (strcmp($colore, "bg-orange") == 0) {
                echo "<td id='colore_$id_cat'>Arancione</td>";
            } else {
                if (strcmp($colore, "bg-warning") == 0) {
                    echo "<td id='colore_$id_cat'>Giallo</td>";
                } else {
                    if (strcmp($colore, "bg-success") == 0) {
                        echo "<td id='colore_$id_cat'>Verde</td>";
                    } else {
                        if (strcmp($colore, "bg-teal") == 0) {
                            echo "<td id='colore_$id_cat'>Verde Acqua</td>";
                        } else {
                            if (strcmp($colore, "bg-info") == 0) {
                                echo "<td id='colore_$id_cat'>Azzurro</td>";
                            } else {
                                if (strcmp($colore, "bg-primary") == 0) {
                                    echo "<td id='colore_$id_cat'>Blu</td>";
                                } else {
                                    if (strcmp($colore, "bg-navy") == 0) {
                                        echo "<td id='colore_$id_cat'>Blu Scuro</td>";
                                    } else {
                                        if (strcmp($colore, "bg-purple") == 0) {
                                            echo "<td id='colore_$id_cat'>Viola</td>";
                                        } else {
                                            if (strcmp($colore, "bg-maroon") == 0) {
                                                echo "<td id='colore_$id_cat'>Fucsia</td>";
                                            } else {
                                                if (strcmp($colore, "bg-gray") == 0) {
                                                    echo "<td id='colore_$id_cat'>Grigio</td>";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        echo "<td id='button_$id_cat'><button onclick=\"modCat($id_cat)\" class='btn btn-primary btn-block'><i class='fa fa-pencil'></i></button></td>"
            . "</tr>";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
$connessione = null;

echo "</tbody>"
    . "</table>"
    . "<div class='row'>"
        . "<div class='col-sm-12'>"
            . "<div id=\"modERR\" style=\"display: none\" class=\"callout callout-danger\">"
            . "<h4>Errore</h4>"
            . "<p>Qualcosa &egrave; andato storto</p>"
            . "</div>"
        . "</div>"
        . "<div class='col-sm-12'>"
            . "<div id=\"modOK\" style=\"display: none\" class=\"callout callout-success\">"
            . "<h4>Modifica effettuata</h4>"
            . "<p>Categoria prodotto modificata</p>"
            . "</div>"
        . "</div>"
    . "</div>";