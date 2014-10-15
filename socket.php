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
    
function connectserver($ipAddress) {
        if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);
            
            die("Couldn't create socket: [$errorcode] $errormsg \n");
        }
        
        echo "Socket created \n";
    // Bind the source address
    if( !socket_bind($sock, $ipAddress , 5000) )
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        
        die("Could not bind socket : [$errorcode] $errormsg \n");
    }
    
    echo "Socket bind OK \n";
    
    if(!socket_listen ($sock , 10))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        
        die("Could not listen on socket : [$errorcode] $errormsg \n");
    }
    
    echo "Socket listen OK \n";
    
    echo "Waiting for incoming connections... \n";

    return ($sock);
}

function transitfile($ipAddress, $ipdest ,$output, $output1)
    {
    $sock = connect($ipAddress);
          socket_write($sock, $ipdest, strlen ($ipdest)) or die("Could not write output\n");
        sleep(1);
    socket_write($sock, $output, strlen ($output)) or die("Could not write output\n");
    sleep(1);
    socket_write($sock, $output1, strlen ($output1)) or die("Could not write ttl output\n");
 
        socket_close($sock);
    }
function transitfilec($ipAddress, $output1, $output)
    {
    $sock = connect($ipAddress);
socket_write($sock, "FIN", strlen ("FIN")) or die("Could not write ttl\n");
        sleep(1);
    socket_write($sock, $output, strlen ($output)) or die("Could not write ou\n");
        socket_close($sock);
    }    
?>