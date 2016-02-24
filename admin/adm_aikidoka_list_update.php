<?php
if(!empty($_POST))
{
	//database settings
	include("./class.db.php");
	include("./class.aikidoka.php");
	$db = new dbaccess();
	$db->dbconnect();
	$p = new aikidoka();
	
	
	foreach($_POST as $field_name => $val)
	{
		//clean post values
		$field_userid = strip_tags(trim($field_name));
		//$v = strip_tags(trim(mysql_real_escape_string($val)));
		
		//from the fieldname:user_id we need to get user_id
		$split_data = explode(':', $field_userid);
		$field_name = $split_data[0];
		$aid = $split_data[1];
		$p->id = $aid;
		if(!empty($aid) && !empty($field_name))
		{
			if(!empty($val)){
				//update the values
				if($field_name === "active" || $field_name === "yudansha" || $field_name === "beginner"){
					$intval = $db->onoff_to_db($val);
					$sql = "UPDATE aikidoka SET $field_name = ". $intval . " WHERE id = " . $aid;
				}else if($field_name === "last_exam" || $field_name == "enrolled")
					$sql = "UPDATE aikidoka SET $field_name = '" . $db->date_to_db($val) . "' WHERE id = " . $aid;
				else
					$sql = "UPDATE aikidoka SET $field_name = '" . $val . "' WHERE id = " . $aid;	
			} else if ($val == 0) {
				$sql = "UPDATE aikidoka SET $field_name = ". $val . " WHERE id = " . $aid;
			}
			$db->qry($sql);
		} else 
			echo "Errore"; 
	}
} else {
	echo "Errore";
}
?>
