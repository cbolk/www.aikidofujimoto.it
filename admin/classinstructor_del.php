<?php
	include("../admin/class.db.php");
    include("./class.classinstructor.php");
    $db = new dbaccess();
    $db->dbconnect();

	if($_POST){
		$iid=$_POST['lid'];	
    	$ci = new classinstructor();
    	$ci->del($db,$iid);
	}
	$db->close();
?>