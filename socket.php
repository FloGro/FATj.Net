<?php
function connect($ipAddress) {
if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Couldn't create socket: [$errorcode] $errormsg \n");
}
 
echo "Socket created \n";

if(!socket_connect($sock , $ipAddress, 5000))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Could not connect: [$errorcode] $errormsg \n");
}
 
echo "Connection established \n";

return ($sock);
}

function send($sock, $message) {
socket_write($sock, $message, strlen($message)) or die("Could not send data to server\n");
}
$sock = connect('10.104.30.70');
$message = 'What ?';
send($sock, $message);
socket_close($sock);
?>