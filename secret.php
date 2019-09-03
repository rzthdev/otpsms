<?php
require_once('lib/Base32.php');
use Base32\Base32;

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
		$hex = $hex.dechex(base_convert($chunk,2,10)) ;
    }
    return $hex;
}

function leftpad($str) {
    $str = substr("00000",0,5 - strlen($str)).$str;
    return $str;
}

$length = 10;
$random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, $length);
$secret = $random;
$secret_base32 = Base32::encode($secret);
$secret_base32_hex = base32tohex($secret_base32);
?>