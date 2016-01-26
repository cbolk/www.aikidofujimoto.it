<?php
	include("./class.db.php");
  	include("./class.login.php");
	include("./class.aikidoka.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	

	if($isLogged == false) { 
		header("Location: adm_index.php");
		exit;
	} 

	$db = new dbaccess();
	$elem = new aikidoka();

	if($_POST){
		$elem->id = $_POST['del'];	
		$elem->del($db);		
	}
?>