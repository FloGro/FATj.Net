<?php
    
    include_once('socket.php');
    include_once('myip.php');
    include_once('IPScan.php');
    set_time_limit (0);
    
    $ipservers = initNetList();
    $ip = getIPs();
  //start loop to listen for incoming connections
    
    $sock = connectserver($ip);

    
    while (true)
    {

        //Accept incoming connection - This is a blocking call
        $client =  socket_accept($sock);
        
        //display information about the client who is connected
        if(socket_getpeername($client , $address , $port))
        {
            echo "Client $address : $port is now connected to us. \n";
        
            
            if (!in_array($address, $ipservers))
                {
               array_push($ipservers, $address);
                }
            
        }
         $connect = socket_read($client, 1024) or die("Could not read input\n");
        if ($connect == "FIN")
        {
            $msg = socket_read($client, 1024) or die("Could not read input\n");
        echo "MESSAGE RETOUR :" . $msg . "\n";
        }
        else if ($connect != "CO")
        {
            if (testConnect($address) == false && in_array($address,$ipservers)){
                unset($ipservers[array_search($address,$ipservers)]);
                sort($ipservers);
            }
            
            $destip = $connect;
        //read data from the incoming socket
            //$destip = socket_read($client, 1024) or die("Could not read input\n");
        echo $destip;
            $ttl = socket_read($client, 1024) or die("Could not read input\n");
            echo $ttl;
            $ttl = $ttl - 2;
           $input = socket_read($client, 1024) or die("Could not read input\n");
            // clean up input string
           $input = trim($input);
           echo "Client Message : ".$input."\n";
        
            $output = $input;
            $output1 = $ttl;
        $output2 = $destip;
	if ($output1 <= "0")
{
        transitfilec($output2, $output1, $output);
}
    else {
        $nb = rand(0, (sizeof($ipservers) - 1));
        while ($ipservers[$nb] == $ip)
        {
            $nb = rand(0, (sizeof($ipservers) - 1));
        }
        
   sleep(1);
       	transitfile($ipservers[$nb], $output2 ,$output1, $output);
}
        }
sleep(1);
        

    }
socket_close($client);
    socket_close($sock);

?>
