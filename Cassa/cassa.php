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
</body>
</html>
