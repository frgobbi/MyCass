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
include "../Componenti_base/BHome.php";
if ($_SESSION['cat'] == 1) {
    echo "<script type='text/javascript'>window.location.href='../Admin/admin.php'</script>";
} else {
    if($_SESSION['cat']==2){
        echo "<script type='text/javascript'>window.location.href='../Cassa/cassa.php'</script>";
    }
}
?>