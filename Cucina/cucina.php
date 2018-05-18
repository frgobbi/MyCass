<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 27/03/2018
 * Time: 11:18
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
    <script type="text/javascript" src="javascript/cucina.js"></script>
    <style type="text/css">
        .btn span.glyphicon {
            opacity: 0;
        }
        .btn.active span.glyphicon {
            opacity: 1;
        }
    </style>
    <script type="text/javascript">
        function tastoEnter() {
            var tasto = window.event.keyCode;
            if (tasto == 13) {
                evadi();
            }
        }

        $('body').click(function() {
            $('#code').focus();
        });
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
                BodyCucina();
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
</body>
</html>
