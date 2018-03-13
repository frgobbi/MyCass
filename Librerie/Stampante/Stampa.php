<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 13/03/2018
 * Time: 19:37
 */

$comando = filter_input(INPUT_POST,"comando",FILTER_SANITIZE_STRING);
set_time_limit(0);
//$address = '79.56.184.64';
$address = 'localhost';
$port = 4600;
echo $address;
$server = array('server' => $address, 'porta' => $port);
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!($conn = socket_connect($socket, $server['server'], $server['porta']))) {
    echo "connessione non avvenuta";
    exit;
}
socket_write($socket, $comando);
socket_close($socket);
?>