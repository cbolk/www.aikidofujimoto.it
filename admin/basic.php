<?php
	
	/*
	 * returns the name of the current page
	 *
	 */
	setlocale(LC_TIME, 'ita');
	date_default_timezone_set('Europe/Rome');
	$uploaddir = "stages/";
	$uploadpath = realpath("..". DIRECTORY_SEPARATOR . $uploaddir) . DIRECTORY_SEPARATOR ;
	$uploadurl = DIRECTORY_SEPARATOR . $uploaddir . DIRECTORY_SEPARATOR;
	
	function curPageName() {
 		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}

	function dateExp($exp_date)
	{
   		$today = strtotime(Date('Y-m-d'));  
   		$expiration_date = strtotime($exp_date);
   		if($expiration_date < $today)
			return true;
		return false;     
	}	

	function convertCRBR($val)
	{
		return str_replace(chr(10),"<br/>",$val);
	}
	
	function convertBRCR($val)
	{
		return str_replace("<br/>",chr(10),$val);
	}
	
	function fixAccents($val)
	{
		$vowelssrc = array("a'", "e'", "i'", "o'", "u'", "A'", "E'", "I'", "O'", "U'");
		$vowelsdst = array("à", "è", "ì", "ò", "ù", "À", "È", "Ì", "Ò", "Ù");
		return str_replace($vowelssrc,$vowelsdst,$val);

	}
	
	function fixDeg($val)
	{
		return str_replace("°", "&deg;", $val);
	}

	function getMonthName($d){
		return strftime("%B", strtotime($d));
	}
	
	function getMonthYear($d){
		return strftime("%B '%y", strtotime($d));
		
	}
	
?>