<?php
if(!empty($_POST))
{
	//database settings
	include("./class.db.php");
	include("./class.aikidoka.php");
	$db = new dbaccess();
	$p = new aikidoka();
	foreach($_POST as $field_name => $val)
	{
		//clean post values
		$field_userid = strip_tags(trim($field_name));
		$h = $val;
		
		//from the fieldname:user_id we need to get user_id
		$split_data = explode(':', $field_userid);
		$aid = $split_data[0];
		$day = $split_data[1];
		$p->id = $aid;
		if(!empty($aid) && !empty($day)){
			if($val >= 0){
				$p->updateMonthHours($db,$day,$h); 
			}
		} else 
			echo "Errore"; 
	}
} else {
	echo "Errore";
}
?>
