<?php
	namespace app\utils;

	class Utils{


		public static function genarateRandStr($len){
		  $chars = "123456789_ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		  $str="";
		  $charsLen = strlen($chars);
		  for($i= 0; $i< $len; $i++){
		    $str .= $chars[rand(0, $charsLen-1)];
		  }
		  return $str;
		}

	}


?>