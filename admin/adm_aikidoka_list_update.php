<?php
if(!empty($_POST))
{
	//database settings
	include("./class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
	
  if($isLogged == false) { 
    header("Location: adm_index.php");
    exit;
  } 
	
	
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
				//update the values
				if($field_name === "active" || $field_name === "yudansha" || $field_name === "beginner"){
					$intval = $db->onoff_to_db($val);
					$sql = "UPDATE aikidoka SET $field_name = ". $intval . " WHERE id = " . $user_id;
				}else if($field_name === "last_exam" || $field_name == "enrolled")
					$sql = "UPDATE aikidoka SET $field_name = '" . $db->date_to_db($val) . "' WHERE id = " . $user_id;
				else
					$sql = "UPDATE aikidoka SET $field_name = '" . $val . "' WHERE id = " . $user_id;

				mysql_query($sql) or mysql_error();
			} else if ($val == 0) {
				$sql = "UPDATE aikidoka SET $field_name = ". $val . " WHERE id = " . $user_id;
				mysql_query($sql) or mysql_error();
			}
		} else 
			echo "Errore"; 
	}
} else {
	echo "Errore";
}
?>
