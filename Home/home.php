<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 18/02/2018
 * Time: 13:21
 */
session_start();
if (!$_SESSION['login']) {
    header("Location:../index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    include "../Componenti_Base/Header.php";
    libreriePublic();
    ?>
</head>
<body class="skin-blue wysihtml5-supported sidebar-collapse">
<div class="wrapper">
    <?php
    include "../Componenti_Base/NavBar.php";
    navBarLog();
    ?>
    <div class="content-wrapper">
        <!-- BODY DELLA PAGINA-->
        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <?php
            if ($_SESSION['cat'] == 1) {
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
                                        <button class='btn btn-primary btn-lg btn-block'>Prodotti</button>
                                    </div>
                                    <div class='col-xs-4'>
                                        <button class='btn btn-warning btn-lg btn-block'>Categorie</button>
                                    </div>
                                    <div class='col-xs-4'>
                                        <button class='btn btn-danger btn-lg btn-block' onclick="$('#modal-ing').modal('show')">Ingredienti</button>
                                    </div>
                                </div>
                                <br>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <div class='table-responsive'>
                                            <table class='table table-bordered table-hovered'>
                                                <thead>
                                                <tr>
                                                    <th>Nome Prodotto</th>
                                                    <th>Prezzo</th>
                                                    <th>Categoria</th>
                                                </tr>
                                                </thead>
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
                                        <div class='table-responsive'>
                                            <table class='table table-bordered table-hovered'>
                                                <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Incasso</th>
                                                    <th>Chiusura</th>
                                                </tr>
                                                </thead>
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
                                        <div class='table-responsive'>
                                            <table class='table table-bordered table-hovered'>
                                                <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Cognome</th>
                                                    <th>Categoria</th>
                                                    <th>Modifica</th>
                                                </tr>
                                                </thead>
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
            ?>

        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
        </div>
        <strong>SOS snack creata da Gobbi Francesco 5binf anno 2015/2016.</strong>
    </footer>
</div><!-- ./wrapper -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- The Modal Ingredienti-->
<div class="modal fade" id="modal-ing">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Aggiungi Ingredienti</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="./metodi/admin/addIng.php">
                    <div class="form-group">
                        <label for="nome">Nome ingrediente:</label>
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Pane" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Inserisci</button>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- The Modal Categorie-->
<div class="modal fade" id="modal-ing">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Aggiungi Ingredienti</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="./metodi/admin/addCat.php">
                    <div class="form-group">
                        <label for="nome">Nome categoria:</label>
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Pane" required>
                    </div>

                    <div class="form-group">
                        <label for="sel1">Select list:</label>
                        <select class="form-control" id="sel1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Inserisci</button>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


</body>
</html>
