<?php
if(!empty($_POST))
{
	//database settings
	include("../admin/class.db.php");
	include("./class.classinstructor.php");
	$db = new dbaccess();
	$db->dbconnect();
	foreach($_POST as $field_name => $val)
	{
		//clean post values
		$field_userid = strip_tags(trim($field_name));
		$val = strip_tags(trim(mysql_real_escape_string($val)));
		
		//from the fieldname:user_id we need to get user_id
		$split_data = explode(':', $field_userid);
		$user_id = $split_data[1];
		$field_name = $split_data[0];
		if(!empty($user_id) && !empty($field_name))
		{
			if(!empty($val)){
				$sql = "$field_name = '" . $val . "' WHERE id = " . $user_id;
			    $ci = new classinstructor();
			    $ci->updField($db,$sql);
			}
		} else 
			echo "Errore"; 
	}
} else {
	echo "Errore";
}
?>
