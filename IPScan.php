<?php
include_once('socket.php');

function testConnect($ipAddress) {
if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0))) {
    return(false);
}
if(!@socket_connect($sock , $ipAddress, 5000)) {
    return(false);
}
send($sock, 'CO');
socket_close($sock);
return (true);
}

function initNetList() {
$subnet = "192.168.118.";
$IPlist = array();
for ($i = 1, $j = 0; $i < 11 ;$i++)
{
        if(testConnect($subnet.$i) == true) {
        $IPlist[$j] = $subnet.$i;
        $j++;
        }
}
return($IPlist);
}
?>
