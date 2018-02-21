<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 22/02/2018
 * Time: 00:22
 */
session_start();
session_destroy();
echo "<script type='text/javascript'>window.location.href='../index.php'</script>";