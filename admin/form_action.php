<?php
	include("class.db.php");
	include("class.login.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption
	if($_REQUEST['action'] == "login"){
    	if($log->login("logon", $_REQUEST['utente'], $_REQUEST['password']) == false){
    		echo "<script type='text/javascript'>window.alert('login e/o password errati.')</script>"; 
    	}
	} else if ($_REQUEST['action'] == "logout") {
		$log->logout();		
	}
	header("Location: adm_index.php");
?>

