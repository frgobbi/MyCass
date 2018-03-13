<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 06/03/2018
 * Time: 10:37
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
    <link rel="stylesheet" href="CSS/Cassa.css">
    <style type="text/css">
        @font-face {
            font-family: KaushanScript;
            src: url(../Librerie/Font/KaushanScript-Regular.otf);
        }

    </style>
    <script type="text/javascript">

    </script>
    <script type="text/javascript" src="javascript/cassa.js"></script>
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
            BodyCassa();
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
<!-- Modal Varie-->
<div class="modal fade" id="modal_varie" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Varie</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <textarea style="background-color: white" class="display form-control text-right" disabled
                                  rows="1" id="display_varie"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','1')" class="numeri btn btn-info btn-block">1</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','2')" class="numeri btn btn-info btn-block">2</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','3')" class="numeri btn btn-info btn-block">3</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','4')" class="numeri btn btn-info btn-block">4</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','5')" class="numeri btn btn-info btn-block">5</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','6')" class="numeri btn btn-info btn-block">6</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','7')" class="numeri btn btn-info btn-block">7</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','8')" class="numeri btn btn-info btn-block">8</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','9')" class="numeri btn btn-info btn-block">9</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','00')" class="numeri btn btn-info btn-block">00</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','0')" class="numeri btn btn-info btn-block">0</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','.')" class="numeri btn btn-info btn-block">.</button>
                    </div>
                </div><!--numeri-->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" onclick="annullaVarie()" class="btn btn-danger btn-block">Cancella
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" onclick="prodotto_varie()" class="btn btn-primary btn-block">Varie
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal SubTotale-->
<div class="modal fade" id="modal_subtot" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Contanti</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <textarea style="background-color: white" class="display form-control text-right" disabled
                                  rows="1" id="display_sub"></textarea>
                    </div>
                </div>
                <div class="row"><!--numeri-->
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','1')" class="numeri btn btn-info btn-block">1</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','2')" class="numeri btn btn-info btn-block">2</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','3')" class="numeri btn btn-info btn-block">3</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','4')" class="numeri btn btn-info btn-block">4</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','5')" class="numeri btn btn-info btn-block">5</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','6')" class="numeri btn btn-info btn-block">6</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','7')" class="numeri btn btn-info btn-block">7</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','8')" class="numeri btn btn-info btn-block">8</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','9')" class="numeri btn btn-info btn-block">9</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','00')" class="numeri btn btn-info btn-block">00</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','0')" class="numeri btn btn-info btn-block">0</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','.')" class="numeri btn btn-info btn-block">.</button>
                    </div>
                </div><!--numeri-->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" onclick="annullaResto()" class="btn btn-danger btn-block">Resto 0</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" onclick="totale_ord()" class="btn btn-primary btn-block">Resto</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Prodotto-->
<div class="modal fade" id="modal_prodotto" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Prodotto</h4>
            </div>
            <div class="modal-body" id="body_p">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
