<?php
    
    include_once('socket.php');    
    set_time_limit (0);
    $ipserver1 = '192.168.118.2';
    $ipclient = "192.168.118.3";
    
  //start loop to listen for incoming connections
    
    $sock = connectserver('192.168.118.1');

    
    while (true)
    {

        //Accept incoming connection - This is a blocking call
        $client =  socket_accept($sock);
        
        //display information about the client who is connected
        if(socket_getpeername($client , $address , $port))
        {
            echo "Client $address : $port is now connected to us. \n";
            
        }
        
        //read data from the incoming socket
            $ttl = socket_read($client, 1024) or die("Could not read input\n");
            echo $ttl;
            $ttl = $ttl - 2;
           $input = socket_read($client, 1024) or die("Could not read input\n");
            // clean up input string
           $input = trim($input);
           echo "Client Message : ".$input."\n";
            $output = $input;
            $output1 = $ttl;
	if ($output1 <= "0") 
{
        transitfilec($ipclient, $output1, $output);
	exit;
}
   sleep(1);
       	transitfile($ipserver1, $output1, $output);
sleep(1);

    }
socket_close($client);
    socket_close($sock);

?>
