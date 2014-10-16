<?php
    include_once('socket.php');
function transitfilec($ipAddress, $output)
{
    $sock = connect($ipAddress);
    socket_write($sock, "FIN", strlen ("FIN")) or transitfilec($ipAddress, $output)
;
    usleep(10000);
    socket_write($sock, $output, strlen ($output)) or transitfilec($ipAddress, $output);
;
    socket_close($sock);
}
    transitfilec($argv[1], $argv[2]);

?>
