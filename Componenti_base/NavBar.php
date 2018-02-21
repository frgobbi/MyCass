<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 20/05/2017
 * Time: 12:46
 */
function navBarIndex()
{
    ?>
    <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">MyCass</a>
        <nav class="navbar navbar-static-top" role="navigation">
            <div class="navbar-custom-menu">

            </div>
            <!--<div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="user user-menu">
                        <a href="#" onclick="alert('funzione ancora non presente')">
                            <span><i class="fa fa-user-plus" aria-hidden="true"></i> Sign up</span>
                        </a>
                    </li>
                </ul>
            </div>-->
        </nav>
    </header>
    <?php
}

function navBarLog()
{
    $id_utente = $_SESSION['user'];
    $connessione = null;
    include "../connessione.php";
    try {
        $oggU = $connessione->query("SELECT * FROM utente WHERE username = '$id_utente'")->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $connessione = null;
    echo "<header class=\"main-header\">"
        . "<!-- Logo -->"
        . "<a href=\"../Home/home.php\" class=\"logo\">MyCass</a>"
        . "<nav class=\"navbar navbar-static-top\" role=\"navigation\">"
        . "<div class=\"navbar-custom-menu\">"
        . "<ul class=\"nav navbar-nav\">"
        . "<li class=\"user user-menu\">"
        . "<a href=\"../Metodi_Index/logout.php\">"
        . "<span><i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i> Log out</span>"
        . "</a>"
        . "</li>"
        . "</ul>"
        . "</div>"
        . "<div class=\"navbar-custom-menu\">"
        . "<ul class=\"nav navbar-nav\">"
        . "<li class=\"user user-menu\">"
        . "<a href=\"#\">"
        . "<span><i class=\"fa fa-user\" aria-hidden=\"true\"></i> Profilo</span>"
        . "</a>"
        . "</li>"
        . "</ul>"
        . "</div>"
        . "</nav>"
        . "</header>";

}