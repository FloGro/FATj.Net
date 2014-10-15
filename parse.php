<?php 
//require_once 'socket.php';

function parse(){

	if (isset($_POST) && count($_POST == 2)) {
	 $file = $_POST[0];
	 $time = $_POST[1];

	 if (file_exists($file)){
	 	if(is_file($file)){

	 		// launch file cut !!!

	 	} else {
	 		echo $file.' is not a file.';
	 	}

	 } else {
	 	echo $file.' does not exist.';
	 }
	} else {
		echo "Incorrect arg number.";
	}
}
?>