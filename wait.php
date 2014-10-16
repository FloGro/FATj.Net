<?php

    
        include_once('socket.php');
        include_once('myip.php');
        include_once('IPScan.php');
        set_time_limit (0);
        
      //  $ipservers = initNetList();
        $ip = "10.104.30.70";
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
            
            }
            $connect = @socket_read($client, 1024);
            if ($connect == "FIN")
            {
                usleep(10000);
                $msg = @socket_read($client, 1024);
                if ($msg == false)
                    continue 2;
                
                echo "MESSAGE RETOUR :" . $msg . "\n";
            }
        
        }
        socket_close($client);
        socket_close($sock);
        
        ?>
