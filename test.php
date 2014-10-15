<?php
include_once('message.php');
include_once('socket.php');
include_once('IPScan.php');

var_dump(initNetList());
$sock = connect('192.168.118.2');
//$myIP = "10.104.30.70";
$srv = "192.168.118.5";
$TTL = '30';
$message = "LE CAPSLOCK TUE DES CHATONS.";
send($sock, $srv);
sleep(1);
send($sock, $TTL);
sleep(1);
send($sock, $message);
sleep(1);
?>
