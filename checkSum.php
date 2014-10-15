<?php
function checkSum($string1, $string2) {
	$checkSum = "";
	for($i = 0; isset($string1[$i]) || isset($string2[$i]); $i++) {
		if (isset($string1[$i]) && isset($string2[$i]))
			$checkSum .= ".".(ord($string1[$i]) + ord($string2[$i]));
		else if (isset($string1[$i]) && !isset($string2[$i]))
			$checkSum .= ".".ord($string1[$i]);
		else if (!isset($string1[$i]) && isset($string2[$i]))
			$checkSum .= ".".ord($string2[$i]);
	}
	return ($checkSum);
}

function checkSumParser($checkSum) {
	$checkSumParser = array();
	$j = -1;
	for($i = 0; isset($checkSum[$i]); $i++) {
		if ($checkSum[$i] != ".") {
			$checkSumParser[$j] .= $checkSum[$i];
		}
		else
			$j++;
	}
	return ($checkSumParser);
}

function missingPacket($string,$checkSum) {
	$string2 = "";
	$checkSumParser = checkSumParser($checkSum);
	for ($i = 0; isset($checkSumParser[$i]); $i++) {
		if(isset($string[$i])) {
			$string2 .= chr($checkSumParser[$i] - ord($string[$i]));
		}
		else
			$string2 .= chr($checkSumParser[$i]);
	}
	return ($string2);
}
?>
