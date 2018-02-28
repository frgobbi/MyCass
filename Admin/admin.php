<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 24/02/2018
 * Time: 12:16
 */
session_start();
if (!$_SESSION['login']) {
    header("Location:../index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="../Admin/Javascript/Prodotti.js"></script>
    <script type="text/javascript" src="../Admin/Javascript/Giornate.js"></script>
    <?php
    include "../Componenti_Base/Header.php";
    libreriePublic();
    ?>
    <script type="text/javascript">
        function controllaS(id) {
            var key;
            var keyQ;
            if(id==1){
                key = "#ingM";
                keyQ = "#ingQM";
            }else {
                key = "#ing";
                keyQ = "#ingQ";
            }
            if ($(keyQ).val() == 1) {
                $(key).show();
            } else {
                $(key).hide();
            }
        }
        function popupModificacat(){
            crea_tabella();
            $('#modal-mod-cat').modal('show');
        }
        function popProd(id_prod) {
            bodyModProd(id_prod);
            $('#modal-mod-prod').modal('show');
        }
    </script>
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
            include "../Componenti_base/BHome.php";
                BodyAdmin();
            ?>

        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
        </div>
        <strong>Cassa SUPERNOVA 2018 Create By Gobbi Francesco.</strong>
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
                <form method="post" action="metodi/addIng.php">
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
<div class="modal fade" id="modal-cat">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Aggiungi categorie prodotto</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="metodi/addCat.php">
                    <div class="form-group">
                        <label for="nome">Nome categoria:</label>
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Bibite" required>
                    </div>

                    <div class="form-group">
                        <label for="colore">Colore:</label>
                        <select class="form-control" name="colore" id="colore">
                            <option value="bg-danger">Rosso</option>
                            <option value="bg-orange">Arancione</option>
                            <option value="bg-warning">Giallo</option>
                            <option value="bg-success">Verde</option>
                            <option value="bg-teal">Verde Acqua</option>
                            <option value="bg-info">Azzurro</option>
                            <option value="bg-primary">Blu</option>
                            <option value="bg-navy">Blu Scuro</option>
                            <option value="bg-purple">Viola</option>
                            <option value="bg-maroon">Fucsia</option>
                            <option value="bg-gray">Grigio</option>
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

<!-- The Modal Prodotti-->
<div class="modal fade" id="modal-prodotti">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Aggiungi Prodotti</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="metodi/addProd.php">
                    <div class="form-group">
                        <label for="nome">Nome prodotto:</label>
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Hamburger" required>
                    </div>

                    <div class="form-group">
                        <label for="prezzo">Prezzo: (per la virgola usa il punto</label>
                        <input type="text" class="form-control" name="prezzo" id="prezzo" placeholder="1.5" required>
                    </div>

                    <div class="form-group">
                        <label for="caregorie">Categoria prodotto:</label>
                        <select class="form-control" name="categoria" id="categoria">
                            <option value="0">Scegli cat...</option>
                            <?php
                            include "../connessione.php";
                            try {
                                foreach ($connessione->query("SELECT * FROM cat_prodotto") as $row) {
                                    $id_cat = $row['id_cat_prodotto'];
                                    $nome_cat = $row['nome_cat'];
                                    echo "<option value=\"$id_cat\">$nome_cat</option>";
                                }
                            } catch (PDOException $e) {
                                echo $e->getMessage();
                            }
                            $connessione = null;
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="disp">Disponibilit&agrave;:</label>
                        <select class="form-control" name="disp" id="disp">
                            <option value="1">SI</option>
                            <option value="0">NO</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ingQ">Ingredienti:</label>
                        <select class="form-control" name="ingQ" id="ingQ" onchange="controllaS(0)">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select>
                    </div>

                    <div id="ing" style="display: none">
                        <div class="box box-info">
                            <div class="box-body">
                                <?php
                                include "../connessione.php";
                                try {
                                    echo "<div class='row'>";
                                    foreach ($connessione->query("SELECT * FROM ingredienti") as $row) {
                                        $id_ing = $row['id_ing'];
                                        $nome_ing = $row['nome_ing'];
                                        echo "<div class=col-sm-4>";
                                        echo "<div class=\"form-check\" style='display: inline'>"
                                            . "<label class=\"form-check-label\">"
                                            . "<input type=\"checkbox\" name='ingredienti[]' class=\"form-check-input\" value=\"$id_ing\"> $nome_ing"
                                            . "</label>"
                                            . "</div>";
                                        echo "</div>";

                                    }
                                    echo "</div>";
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                                $connessione = null;
                                ?>
                            </div>
                        </div>
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

<!-- The Modal modifica Categorie-->
<div class="modal fade" id="modal-mod-cat">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modifica Categorie</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="body-mod-cat">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- The Modal modifica Prodotto-->
<div class="modal fade" id="modal-mod-prod">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modifca Prodotto</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="body-mod-prod">

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
