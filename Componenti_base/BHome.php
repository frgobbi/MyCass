<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 21/02/2018
 * Time: 19:51
 */
function BodyAdmin()
{
    ?>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="box box-warning">
                <div class="box-header" data-toggle="tooltip" title="Header tooltip">
                    <h3 class="box-title">Prodotti & co.</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-warning btn-xs" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button class="btn btn-warning btn-xs" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class='row'>
                        <div class='col-xs-4'>
                            <button class='btn btn-primary btn-lg btn-block'
                                    onclick="$('#modal-prodotti').modal('show')">Prodotti
                            </button>
                        </div>
                        <div class='col-xs-4'>
                            <button class='btn btn-warning btn-lg btn-block'
                                    onclick="$('#modal-cat').modal('show')">Categorie
                            </button>
                        </div>
                        <div class='col-xs-4'>
                            <button class='btn btn-danger btn-lg btn-block'
                                    onclick="$('#modal-ing').modal('show')">Ingredienti
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <button class='btn btn-primary btn-sm btn-block'
                                    onclick="popupModificacat()">Modifica categorie
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='table-responsive' style="height: 527px; overflow-y: auto">
                                <table class='table table-bordered table-hovered'>
                                    <thead>
                                    <tr>
                                        <th>Nome Prodotto</th>
                                        <th>Prezzo</th>
                                        <th>Categoria</th>
                                        <th>Modifica</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $connessione = null;
                                    include "../connessione.php";
                                    try {
                                        foreach ($connessione->query("SELECT prodotto.id_prodotto, prodotto.nome_p,prodotto.prezzo,cat_prodotto.nome_cat FROM prodotto INNER JOIN cat_prodotto ON prodotto.id_cat_prodotto = cat_prodotto.id_cat_prodotto ORDER BY(cat_prodotto.id_cat_prodotto)") as $row) {
                                            $n_p = $row['nome_p'];
                                            $pre = $row['prezzo'];
                                            $nome_c = $row['nome_cat'];
                                            $id_prod = $row['id_prodotto'];
                                            echo "<tr>"
                                                . "<td>$n_p</td>"
                                                . "<td>$pre &euro;</td>"
                                                . "<td>$nome_c</td>"
                                                . "<td><button class='btn btn-primary btn-block' onclick=\"popProd($id_prod)\"><i class='fas fa-pencil-alt'></i></button></td>"
                                                . "</tr>";
                                        }
                                    } catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }
                                    $connessione = null;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->

            </div><!-- /.box -->
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header" data-toggle="tooltip" title="Header tooltip">
                    <h3 class="box-title">Giornate</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button class="btn btn-primary btn-xs" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class='row'>
                        <div class='col-sm-12'>
                            <button class='btn btn-primary btn-block' onclick="addGiornata()">Nuovo giorno</button>
                            <br>
                            <div id="ErrorA" style="display: none;" class="callout callout-danger">
                                <h4>Errore</h4>
                                <p>Questo giorno è gi&agrave; presente.</p>
                            </div>
                            <div id="WarnigA" style="display: none;" class="callout callout-warning">
                                <h4>Attenzione</h4>
                                <p>Prima di avviare un giorno, chiudere le giornate precedenti.</p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='table-responsive' style="height: 200px; overflow-y: auto">
                                <table class='table table-bordered table-hovered'>
                                    <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Incasso</th>
                                        <th>Chiusura</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bodyTG">
                                    <?php
                                    include "../connessione.php";
                                    foreach ($connessione->query("SELECT DATE_FORMAT(data_g, '%d-%m-%Y') AS data_giorno, incasso, chiuso FROM giorno") as $row) {
                                        $incasso = $row['incasso'];
                                        $data = $row['data_giorno'];
                                        $flag = $row['chiuso'];
                                        echo "<tr>";
                                        echo "<td>$data</td>";
                                        echo "<td>$incasso &euro;</td>";
                                        if ($flag == 0) {
                                            echo "<td><button class='btn btn-danger btn-block'><i class=\"fas fa-window-close\"></i></button></td>";
                                        } else {
                                            echo "<td><button disabled class='btn btn-danger btn-block disabled'><i class=\"fas fa-window-close\"></i></button></td>";
                                        }

                                        echo "</tr>";
                                        $connessione = null;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->

            </div><!-- /.box -->

            <div class="box box-success">
                <div class="box-header" data-toggle="tooltip" title="Header tooltip">
                    <h3 class="box-title">Utenti</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-success btn-xs" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button class="btn btn-success btn-xs" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class='row'>
                        <div class='col-sm-12'>
                            <button class='btn btn-success btn-block' onclick="$('#modal-new_utente').modal('show')">
                                Nuovo Utente
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='table-responsive' style="height: 230px; overflow-y: auto">
                                <table class='table table-bordered table-hovered'>
                                    <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                        <th>Categoria</th>
                                        <th>Modifica</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bodyTUtente">
                                    <?php
                                    $connessione = null;
                                    include "../connessione.php";
                                    try {
                                        foreach ($connessione->query("SELECT utente.nome, utente.cognome, utente.username,cat_utente.nome_cat FROM utente INNER JOIN cat_utente ON utente.id_cat = cat_utente.id_cat WHERE cat_utente.id_cat !=1") as $row) {
                                            $n_u = $row['nome'];
                                            $c_u = $row['cognome'];
                                            $u_u = $row['username'];
                                            $cat = $row['nome_cat'];
                                            echo "<tr>"
                                                . "<td>$u_u</td>"
                                                . "<td>$n_u</td>"
                                                . "<td>$c_u</td>"
                                                . "<td>$cat</td>"
                                                . "<td><button onclick='popUtente(\"$u_u\")' class='btn btn-primary btn-block'><i class='fas fa-pencil-alt'></i></button></td>"
                                                . "</tr>";
                                        }
                                    } catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }
                                    $connessione = null;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->

            </div><!-- /.box -->
        </div>
    </div>
    <?php
}

function BodyCassa()
{
    ?>
    <div class="row">
        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-warning">
                        <div class="box-header" data-toggle="tooltip" title="Header tooltip">
                            <form class="box-title form-inline">
                                <div class="form-group">
                                    <label for="nominativo">Nominativo </label>
                                    <input id="nominativo" onkeyup="" type="text" class="form-control">
                                </div>
                            </form>
                            <div class="box-tools pull-right">
                                <button class="btn btn-warning btn-xs" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                <button class="btn btn-warning btn-xs" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body" style="height: 570px; overflow-y: auto; overflow-x: hidden">
                            <div class="row">
                                <?php
                                $connessione = null;
                                include "../connessione.php";
                                try {
                                    foreach ($connessione->query("SELECT * FROM `prodotto` INNER JOIN cat_prodotto ON cat_prodotto.id_cat_prodotto = prodotto.id_cat_prodotto WHERE disp = 1 ORDER BY(prodotto.id_cat_prodotto) ASC") as $row) {
                                        $id_p = $row['id_prodotto'];
                                        $nome = $row['nome_p'];
                                        $colore = $row['colore'];
                                        $prezzo = $row['prezzo'];
                                        echo "<div class=\"col-lg-3 col-md-6\">"
                                            . "<a href=\"#\" onclick='popupProdotto(\"$id_p\")'>"
                                            . "<!-- small box -->"
                                            . "<div class=\"small-box $colore\">"
                                            . "<h4 style='font-size:24px; padding-top:15px; color: white; font-family: KaushanScript' class='text-center'>$nome</h4>"
                                            . "<a href=\"#\" onclick='popupProdotto(\"$id_p\")' style='font-family: KaushanScript;font-size: 18px;' class=\"small-box-footer text-\">"
                                            . "$prezzo &euro;"
                                            . "</a>"
                                            . "</div>"
                                            . "</a>"
                                            . "</div>";
                                    }
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                                $connessione = null;
                                ?>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>

            <div class="row" style="font-family: KaushanScript">
                <div class="col-xs-3">
                    <button class="btn btn-primary btn-lg btn-block" onclick="creaInfo()">Info</button>
                </div>
                <div class="col-xs-3">
                    <button class="btn btn-primary btn-lg btn-block" onclick="annulla()">Cancella Ordine</button>
                </div>
                <div class="col-xs-3">
                    <button class="btn btn-primary btn-lg btn-block" onclick="cancella()">Correzione</button>
                </div>
                <div class="col-xs-3">
                    <button class="btn btn-primary btn-lg btn-block" onclick="popupVarie()">Varie</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12" style="padding-right: 30px; font-family: KaushanScript">
            <div class="row">
                <div class="box box-primary">
                    <div class="box-header" data-toggle="tooltip" title="Header tooltip"></div>
                    <div class="box-body" id="scontrino" style="height: 604px; overflow-y: auto; overflow-x:hidden">
                        <div class="row container-fluid" id="area_ordine"
                             style="height: 470px; overflow-y: auto; overflow-x:hidden">
                            <!--da javascript-->
                        </div>
                        <div class="row" id="area_sub_tot" style="display: none;">
                            <hr>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left" style="font-family: KaushanScript"><h4><b>Contante:</b></h4>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right" id="contante"><h4>
                                    <b>15.25 &euro;</b></h4></div>
                        </div>
                        <div class="row" id="area_tot">
                            <hr>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left" style="font-family: KaushanScript"><h3><b>Tot:</b></h3></div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right" id="tot" style="font-family: KaushanScript"><h3><b> 0 &euro;</b></h3>
                            </div>

                        </div>
                        <div class="row" id="area_resto" style="display: none;">
                            <hr>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left" style="font-family: KaushanScript"><h4><b>Resto:</b></h4></div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right" id="resto" style="font-family: KaushanScript"><h4>
                                    <b>15.25 &euro;</b></h4>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>

            <div class="row" style="font-family: KaushanScript">
                <div class="btn-group btn-group-justified">
                    <a href="#" class="btn btn-primary btn-lg" onclick="subtotale()">Sub</a>
                    <a href="#" class="btn btn-primary btn-lg" onclick="totale_ord('0')">Totale</a>
                    <a href="#" class="btn btn-primary btn-lg" onclick="totale_ord('2')">POS</a>
                    <a href="#" class="btn btn-primary btn-lg" onclick="totale_ord('1')">Buono</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}