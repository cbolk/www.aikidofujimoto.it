<?php
	include("./class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
	if($_POST){
		$iid=$_POST['del'];	
		$query = "DELETE FROM seminar WHERE id = $iid ";
		$result = $db->qry($query);
		$query = "DELETE FROM seminarinstructor WHERE seminarfk = $iid ";
		$result = $db->qry($query);
	}
	$db->close();
?>
<html>
	<head><title><?php echo $iid; ?></title></head>
	<body>
		<?php echo $query; ?>
	</body>
</html>