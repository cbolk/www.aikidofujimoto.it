<?php  session_start();

	include("basic.php");
	include("class.db.php");
	include("class.login.php");
	include("class.aikidoka.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	

	if($isLogged == false) { 
		header("Location: adm_index.php");
		exit;
	} 

	$db = new dbaccess();

	/* do the insertion */
	$ai = new aikidoka();
	$ai->lastname = strtolower($_POST["lastname"]); 
	$ai->firstname = strtolower($_POST["firstname"]); 
	if($_POST["lastexam"] === null || $_POST["lastexam"] == "")
		$ai->lastexam = "0000-00-00"; 
	else
		$ai->lastexam = $db->date_to_db($_POST["lastexam"]); 
	$ai->enrolled = $db->date_to_db($_POST["enrolled"]); 
	$ai->rank = str_replace(":"," ",$_POST["rank"]); 
	$ai->yudansha = $db->onoff_to_db($_POST["yudansha"]); 
	$ai->beginner = $db->onoff_to_db($_POST["beginner"]); 
	$ai->youngster = $db->onoff_to_db($_POST["youngster"]); 
	$ai->active = $db->onoff_to_db($_POST["active"]); 
	
	$ris =  $ai->add($db);
	
	echo $ris;
?>