<?php
include_once('message.php');
include_once('socket.php');
include_once('IPScan.php');

$netList = initNetList();
$finalDestination = "192.168.118.4";
//$TTL = $argv[1];
$TTL = '67';
$message = ["Premier paquet","Deuxieme pacquet","Troisieme paquet","Quatrieme paquet"];

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
