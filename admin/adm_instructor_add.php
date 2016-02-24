<?php  session_start();

	include("basic.php");
	include("class.db.php");
	include("class.login.php");
	include("class.instructor.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	

	if($isLogged == false) { 
		header("Location: adm_index.php");
		exit;
	} 

	$db = new dbaccess();

	/* do the insertion */
	$ai = new instructor();
	$ai->lastname = strtolower($_POST["lastname"]); 
	$ai->firstname = strtolower($_POST["firstname"]); 
	$ai->rank = strtolower($_POST["rank"]); 
	$ai->sorting = strtolower($_POST["sorting"]); 
	
	$ris =  $ai->add($db);
	
	echo $ris;
?>