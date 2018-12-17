<?php
// -------- calculator result --------------------------------------------------------------
$para1				= isset($_REQUEST['para1']) 			? stripcleantohtml($_REQUEST['para1'])				: '';
$para2				= isset($_REQUEST['para2']) 			? stripcleantohtml($_REQUEST['para2'])				: '';
$para3				= isset($_REQUEST['para3']) 			? stripcleantohtml($_REQUEST['para3'])				: '';
$para4				= isset($_REQUEST['para4']) 			? stripcleantohtml($_REQUEST['para4'])				: '';

function getEirResult($val1,$val2,$val3,$val4){
	
	$path		= "/var/www/java/bin/calPLoanEIR.sh";

	$cmd = $path.' '.escapeshellarg($val1).' '.escapeshellarg($val2).' '.escapeshellarg($val3).' '.escapeshellarg($val4);
	$result = shell_exec($cmd);

	$result = explode (":", $result);

	$result_0_text = "";
	$result_1_text = "";

	if ($result[0]<>0){	$result_0_text .= str_replace(" ","",$result[0])."個月";	}
	if ($result[1]<>0){	$result_1_text .= str_replace(" ","",$result[1])."港元";	}

	eir_ary[0] = $result_0_text;
	eir_ary[1] = $result_1_text;

	return eir_ary;
}

eir_result = new stdClass();
eir_result->minpay_tenor            = "";
eir_result->minpay_total_payment    = "";

if ($para1 != "" AND $para2 != "" AND $para3 != "" AND $para4 != "") {

	eir = getEirResult($para1,$para2,$para3,$para4);

	eir_result->minpay_tenor            = eir[0];
    eir_result->minpay_total_payment    = eir[1];
}

echo json_encode(eir_result);

?>