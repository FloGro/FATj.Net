<?php

function send($sock, $message) {
socket_write($sock, $message, strlen($message)) or die("Could not send data to server\n");
}

function receive($sock) {
$result = socket_read ($sock, 1024) or die("Could not read server response\n");
return ($result);
}

?>