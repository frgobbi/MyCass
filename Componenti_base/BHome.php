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
                            <div class='table-responsive' style="height: 500px; overflow-y: auto">
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
                                            $id_prod= $row['id_prodotto'];
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
                            <button class='btn btn-primary btn-block'>Nuovo giorno</button>
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
                                    foreach ($connessione->query("SELECT DATE_FORMAT(data_g, '%d-%m-%Y') AS data_giorno, incasso, chiuso FROM giorno") as $row){
                                        $incasso = $row['incasso'];
                                        $data = $row['data_giorno'];
                                        $flag = $row['chiuso'];
                                        echo "<tr>";
                                            echo "<td>$data</td>";
                                            echo "<td>$incasso &euro;</td>";
                                            echo "<td><button class='btn btn-danger btn-block'><i class=\"fas fa-window-close\"></i></button></td>";
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
                            <button class='btn btn-success btn-block'>Nuovo Utente</button>
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
                                    <tbody>
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
                                                . "<td><button class='btn btn-primary btn-block'><i class='fas fa-pencil-alt'></i></button></td>"
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