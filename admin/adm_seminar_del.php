<?php
	include("./class.db.php");
  	include("./class.login.php");
	include("./class.seminar.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	

  if($isLogged == false) { 
    header("Location: adm_index.php");
    exit;
  } 

	$db = new dbaccess();
	$s = new seminar();

	if($_POST){
		$s->id = $_POST['del'];	
		$s->del($db);		
	}
?>