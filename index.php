<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 16/02/2018
 * Time: 09:34
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    include "Componenti_Base/Header.php";
    librerieIndex();
    ?>
    <style type="text/css">

    </style>
    <script type="text/javascript">
        function login() {
            var user = $('#user').val();
            var pwd = $('#pwd').val();
            document.getElementById("login").reset();
            if(user != "" || pwd != ""){
                $.ajax({
                    type: "POST",
                    url: "./Metodi_index/login.php",
                    data: "user="+user+"&pwd="+pwd,
                    dataType: "html",
                    success: function(risposta)
                    {
                       if(risposta==0){
                           $('#alertL').hide();
                           window.location.href="./Home/home.php";
                       } else {
                           $('#alertL').show();
                       }
                    },
                    error: function()
                    {

                    }
                });
            }
        }

        function tastoEnter() {
            var tasto = window.event.keyCode;
            if (tasto == 13) {
                login();
            }
        }
    </script>
</head>
<body class="skin-blue wysihtml5-supported sidebar-collapse">
<div class="wrapper">
    <?php
    include "Componenti_Base/NavBar.php";
    navBarIndex();
    //include "Componenti_Base/SideBar.php";
    //sideBarLog();
    ?>
    <div class="content-wrapper">
        <!-- BODY DELLA PAGINA-->
        <section class="content">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3">
                    <div class="box box-primary">
                        <div class="box-header" data-toggle="tooltip" title="Header tooltip">
                            <h3 class="box-title">LOGIN CASSA SUPERNOVA</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-primary btn-xs" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <form id="login">
                                <div class="form-group">
                                    <label for="email">Username:</label>
                                    <input type="email" class="form-control" id="user">
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Password:</label>
                                    <input type="password" onkeyup="tastoEnter()" class="form-control" id="pwd">
                                </div>
                                <div id="alertL" style="display: none" class="callout callout-danger">
                                    <h4>Errore</h4>
                                    <p>I dati inseriti sono errati.</p>
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="login()" class="btn btn-primary btn-block">Entra</button>
                                </div>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </section>
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

