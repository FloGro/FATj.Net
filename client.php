<?php

//les arguments sont : fichier password
include_once('message.php');
include_once('socket.php');
include_once('IPScan.php');
include_once('fileCut.php');

$netList = initNetList();
$finalDestination = "192.168.118.4";
//$TTL = $argv[1];
$TTL = '67';
//$message = file_reader($argv[1], $argv[2]);
$message = ['Paquet','Paquet'];

for($i = 0; $i < sizeof($message); $i++) {
       $server = $netList[rand(0, sizeof($netList) - 1)];
       $sock = connect($server);
       sleep(1);
       send($sock, $finalDestination);
       usleep(5000);
       send($sock, $TTL);
       usleep(5000);
       send($sock, $message[$i]);
       socket_close($sock);
}
?>
