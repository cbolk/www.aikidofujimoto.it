<?php
	include("./class.db.php");
    include("./class.login.php");
	include("./class.news.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	

	if($isLogged == false) { 
		header("Location: adm_index.php");
		exit;
	} 

	$db = new dbaccess();
	$n = new news();

	if($_POST){
		$n->id = $_POST['del'];	
		$n->del($db);		
	}
?>
