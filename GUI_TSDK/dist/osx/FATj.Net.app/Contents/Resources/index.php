<?php
	include "start.html";
 	
 	$command = "php client.php";
 	foreach ($_GET as $value) {
 		$command .= " ".$value;
 	}
 	var_dump($command);
 	exec($command);
 ?>