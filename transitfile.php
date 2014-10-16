<?php
    include_once('socket.php');

    function transitfile($ipAddress, $ipdest ,$output, $output1)
    {
        
        $sock = connect($ipAddress);
       sleep(1);
        socket_write($sock, $ipdest, strlen ($ipdest)) or transitfile($ipAddress, $ipdest ,$output, $output1);
        usleep(10000);
        socket_write($sock, $output, strlen ($output)) or transitfile($ipAddress, $ipdest ,$output, $output1);
        usleep(10000);
        socket_write($sock, $output1, strlen ($output1)) or transitfile($ipAddress, $ipdest ,$output, $output1);
        
        socket_close($sock);
    }
    transitfile($argv[1], $argv[2], $argv[3], $argv[4]);
?>