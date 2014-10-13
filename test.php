<?php
include_once('message.php');
include_once('socket.php');

$sock = connect('10.104.30.70');
$message = 'What ?';
while(true) {
send($sock, $message);
$message = receive($sock);
echo $message;
sleep(30);
}
socket_close($sock);
?>