<?php  session_start();

	include("basic.php");
	include("class.db.php");
	include("class.login.php");
	include("class.news.php");
	include("class.utilities.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	

	if($isLogged == false) { 
		header("Location: adm_index.php");
		exit;
	} 

	$db = new dbaccess();

	/* do the insertion */
	$ns = new news();
	$ns->date = $db->date_to_db($_POST["date"]); 
	$ns->title = fixAccents($_POST["title"]);		
	$ns->description = fixAccents($_POST["description"]);		

	if(!($_POST["expires"]===NULL || $_POST["expires"] == "") )
		$ns->expires = $db->date_to_db($_POST["expires"]);
	else
		$ns->expires = date('Y-m-d', strtotime('+1 month'));

	$ris =  $ns->add($db);

	echo $ris;
?>
