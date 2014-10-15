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
        $connect = socket_read($client, 1024) or die("Could not read CONNECT\n");
        if ($connect == "FIN")
        {
            usleep(5);
            $msg = socket_read($client, 1024) or die("Could not read MESG\n");
            echo "MESSAGE RETOUR :" . $msg . "\n";
        }
        else if ($connect != "CO")
        {
        
            
            $destip = $connect;
            echo $destip;
            $ttl = socket_read($client, 1024) or die("Could not read input\n");
            echo $ttl;
            $ttl = $ttl - 1;
            $input = socket_read($client, 1024) or die("Could not read input\n");
            // clean up input string
            $input = trim($input);
            echo "Client Message : ".$input."\n";
            
            $output = $input;
            $output1 = $ttl;
            $output2 = $destip;
            if ($output1 <= "0" && $output2 != $ip)
            {
                transitfilec($output2, $output1, $output);
            }
            else if ($output1 <= "0" && $output2 == $ip)
            {
                echo "MESSAGE RETOUR :" . $output . "\n";
            }
            else {
                $nb = rand(0, (sizeof($ipservers) - 1));
                while ($ipservers[$nb] == $ip)
                {
                    $nb = rand(0, (sizeof($ipservers) - 1));
                }
                while (testConnect($ipservers[$nb]) == false )
               {
                   if ($ipservers[$nb] != $ip) {
                    unset($ipservers[array_search($ipservers[$nb],$ipservers)]);
                    sort($ipservers);
                   }
                   $nb = rand(0, (sizeof($ipservers) - 1));
                }
                echo "CONNEXION " . $ipservers[$nb] . "\n";
                usleep(5);
                transitfile($ipservers[$nb], $output2 ,$output1, $output);
            }
        }
usleep(5);
        
    }
    socket_close($client);
    socket_close($sock);
    
    ?>
