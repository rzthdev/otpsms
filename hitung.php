<?php
require_once('lib/rfc6238.php');
require_once('lib/Base32.php');
use Base32\Base32;

$secretkey = filter_input(INPUT_POST, 'secret', FILTER_SANITIZE_STRING);

$otp = TokenAuth6238::getTokenCode($secretkey,0); 

function char_at($str, $pos){
  return $str{$pos};
}

function base32tohex($base32) {
    $base32chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
    $bits = "";
    $hex = "";
	
	for($i=0;$i<strlen($base32); $i++){
       $val = strpos($base32chars,char_at($base32,$i));
       $bits .= leftpad(decbin($val));
    }

    for ($i = 0; $i+4 <= strlen($bits); $i+=4) {
        $chunk = substr($bits,$i, 4);
		$hex = $hex.dechex(base_convert($chunk,2,10));
    }
    return $hex;
}

function leftpad($str) {
    $str = substr("00000",0,5 - strlen($str)).$str;
    return $str;
}

$secret_base32 = filter_input(INPUT_POST, 'secret', FILTER_SANITIZE_STRING);
$secret_base32_hex = base32tohex($secret_base32);

$unix_time = time();
$unix_time_div30 = round($unix_time/30);
$unix_time_hex = dechex($unix_time_div30);

$hmac = TokenAuth6238::hmac($secretkey,0); 

$data=array(
	"otp" => $otp,
	"secretHex" => $secret_base32_hex,
	"time" => $unix_time_hex,
	"hmac" => $hmac
);
echo json_encode($data);
?>
