<?php  session_start();

	include("basic.php");
	include("class.db.php");
	include("class.login.php");
	include("../adm/class.seminar.php");
	include("../adm/class.utilities.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	

	if($isLogged == false) { 
		header("Location: index.php");
		exit;
	} 

	$db = new dbaccess();

	/* do the insertion */
	$ns = new seminar();
	$ns->fromdate = $db->date_to_db($_POST["startdate"]); 
	$ns->fromtime = $_POST["starttime"] . ":00";
		$ns->shortdate = date("Ymd", strtotime($ns->fromdate));
	$ns->dtstart = date("Ymd", strtotime($ns->fromdate)) . "T" . str_replace(":", "", $ns->fromtime) . "Z";
	$ns->todate = $db->date_to_db($_POST["enddate"]);
	$ns->totime = $_POST["endtime"] . ":00";
		$ns->dtend = date("Ymd", strtotime($ns->todate)) . "T" . str_replace(":", "", $ns->totime) . "Z";
	$ns->title = convertCRBR($_POST["shortdescription"]);		
	$ns->description = convertCRBR($_POST["description"]);		
	$ns->locationfk = $_POST["locationid"];
	if($_POST["locationid"] === NULL){
		$ns->location = $_POST["location"];
		$ns->shortcity = convertCRBR($_POST["shortcity"]);
		$ns->address = convertCRBR($_POST["address"]);
		$ns->city = convertCRBR($_POST["city"]);
	} 
	$ns->seminartype = $_POST["seminartype"];
	if(!($_POST["seminarinstructor1"]===NULL))
		$ns->instructors[0]['id'] = $_POST["seminarinstructor1"];
	if(!($_POST["seminarinstructor2"]===NULL))
		$ns->instructors[1]['id'] = $_POST["seminarinstructor2"];
	if(!($_POST["seminarinstructor3"]===NULL))
		$ns->instructors[2]['id'] = $_POST["seminarinstructor3"];

	$ns->organizerfk = $_POST["organizerfk"];
	if($_POST["organizerfk"] === NULL){
		$ns->organizer = $_POST["organizer"];
		$ns->phone = $_POST["phone"];
		$ns->email = $_POST["email"];
		$ns->url = $_POST["url"];
	}
	$ns->tags = $_POST["tags"];
	$ns->pdf =	$_FILES['pdf']['name'];
	$ns->image = $_FILES['image']['name'];
	$ns->photo = $_FILES['photo']['name'];
	$ns->notes	= convertCRBR($_POST["notes"]);
	$ns->schedule	= convertCRBR($_POST["schedule"]);
	$ns->expires	= $db->date_to_db($_POST["expires"]);
	//$ns->setGCal();

	/**/
	if($ns->locationfk){
		$ns->location = NULL;
		$ns->address = NULL;
		$ns->city = NULL;
		$ns->shortcity = NULL;						
	}
	
	
	$ris =  $ns->add($db);

	if ($ns->pdf != ""){
		$srcfile = $_FILES['pdf']['tmp_name'];
		$dstfile =  $uploadpath . $_FILES['pdf']['name'];
		if (!move_uploaded_file($srcfile, $dstfile)) {
				echo('locandina non caricata!');
		}
	}
	if ($ns->image != ""){
		$srcfile = $_FILES['image']['tmp_name'];
		$dstfile =  $uploadpath . $_FILES['image']['name'];
		if (!move_uploaded_file($srcfile, $dstfile)) {
				echo('miniatura non caricata!');
		}
	}
	if ($ns->photo != ""){
		$srcfile = $_FILES['photo']['tmp_name'];
		$dstfile =  $uploadpath . $_FILES['photo']['name'];
		if (!move_uploaded_file($srcfile, $dstfile)) {
				echo('foto per elenco seminari non caricata!');
		}
	}
	/*
	$srcfile = $ns->shortdate . "_" . $ns->instructortag . ".ics";
	$dstfile =  $uploadpath . $srcfile;
	$ns->createICS();
	if (!move_uploaded_file($srcfile, $dstfile)) {
			echo('file ICS non creato!');
	}
	*/
	echo $ris;
?>
