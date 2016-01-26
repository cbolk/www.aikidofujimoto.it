<?php
if(!empty($_POST))
{
	//database settings
	include("../admin/class.db.php");
	include("./class.traininghour.php");
	$db = new dbaccess();
	$db->dbconnect();
	foreach($_POST as $field_name => $val)
	{
		//clean post values
		$field_userid = strip_tags(trim($field_name));
		$val = strip_tags(trim(mysql_real_escape_string($val)));
		
		//from the fieldname:user_id we need to get user_id
		$split_data = explode('|', $field_userid);
		$hour_id = $split_data[0];
		$field_name = $split_data[1];
		$msg = "hid: " . $hour_id . " - " . $field_name . " - " . $val;
		if(!empty($hour_id) && !empty($field_name))
		{
			if(!empty($val)){
				$sql = "$field_name = '" . $val . "' WHERE id = " . $hour_id;
			    $th = new traininghour();
			    $th->updField($db,$sql);
			}
		} else 
			echo "Errore"; 
	}
} else {
	echo "Errore";
}
?>
