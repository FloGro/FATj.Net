<?php
include_once('message.php');
include_once('socket.php');
include_once('IPScan.php');

var_dump(initNetList());
$sock = connect('192.168.118.2');
$myIP = "192.168.118.3";
$TTL = '20';
$message = "LE CAPSLOCK TUE DES CHATONS.";
send($sock, $myIP);
sleep(1);
send($sock, $TTL);
sleep(1);
send($sock, $message);
sleep(1);
?>
