<?php

	class traininghour {

		function add($db,$data){
			$query = "INSERT INTO trainingschedule SET weekday=".$data['weekday'].", starttime='".$data['starttime']."', endtime='".$data['endtime']."', tag='". $data['tag']."', leaderid=".$data['leaderid'].",leaderid_alt=".$data['leaderid_alt']."', notes='". $data['notes']."';";
	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		        $db->close(); 
		    	return 0;
		    }
	        die('impossibile aggiungere la nuova voce');
    	}

		function del($db,$wid,$hid){
			$query = "DELETE FROM trainingschedule WHERE weekday=".$id." AND starttime='" . $hid . "';";
    		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$db->close(); 
		    	return 0;
		    }
	        die('impossibile eliminare la voce selezionata');
    	}

		function upd($db,$data){
			$query = "UPDATE trainingschedule SET weekday=".$data['weekday'].", starttime='".$data['starttime']."', endtime='".$data['endtime']."', tag='". $data['tag']."', leaderid=".$data['leaderid'].",leaderid_alt=".$data['leaderid_alt']."', notes='". $data['notes']."';";
    		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$db->close(); 
		    	return 0;
		    }
	        die('impossibile aggiornare la voce selezionata');
    	}

		function updField($db,$updateqry){
			$query = "UPDATE trainingschedule SET ". $updateqry .";";
    		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$db->close(); 
		    	return 0;
		    }
	        die('impossibile aggiornare la voce selezionata');
    	}

    	function get($db){
			$query = "SELECT ts.* FROM trainingschedule ts ORDER BY weekday, starttime;";
	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$numrows = mysql_num_rows($result);
		    	$res = array();
		    	for ($x = 0; $x < $numrows; $x++) 
		        	$res[] = mysql_fetch_assoc($result);
		        $db->close();

		    	return json_encode($res);
		    }
	        die('impossibile accedere alla lista di istruttori');

    	}

    	function getByMonth($db,$month){
    		if($month == 7 || $month == 8 || $month == 9)
				$query = "SELECT ts.* FROM trainingschedule ts ORDER BY weekday, starttime WHERE month=" . $month . ";";
			else
				$query = "SELECT ts.* FROM trainingschedule ts ORDER BY weekday, starttime WHERE month=0;";
	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$numrows = mysql_num_rows($result);
		    	$res = array();
		    	for ($x = 0; $x < $numrows; $x++) 
		        	$res[] = mysql_fetch_assoc($result);
		        $db->close();

		    	return json_encode($res);
		    }
	        die('impossibile accedere alla lista di istruttori');

    	}

    	function getOrderByHourByMonth($db, $month){
    		if($month == 7 || $month == 8 || $month == 9)
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=" . $month . " ORDER BY starttime, weekday;";
			else
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=0 ORDER BY starttime, weekday;";
	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$numrows = mysql_num_rows($result);
		    	$res = array();
		    	for ($x = 0; $x < $numrows; $x++) 
		        	$res[] = mysql_fetch_assoc($result);
		        $db->close(); 
		    	return json_encode($res);
		    }
	        die('impossibile accedere alla voce selezionata');

    	}

   		function getToday($db){
			$today = Date('Y-m-d');
  			$month = date('m', strtotime($date));
  			$wid = date('w', strtotime($date));
    		if($month == 7 || $month == 8 || $month == 9)
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=" . $month . " AND weekday=".$wid." ORDER BY starttime;";
			else
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=0 AND weekday=".$wid." ORDER BY starttime;";
	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$numrows = mysql_num_rows($result);
		    	$res = array();
		    	for ($x = 0; $x < $numrows; $x++) 
		        	$res[] = mysql_fetch_assoc($result);
		        $db->close(); 
		    	return json_encode($res);
		    }
	        die('impossibile alle lezioni odierne');

    	}

    	function getDay($db, $day){
  			$month = date('m', strtotime($day));
  			$wid = date('w', strtotime($day));
    		if($month == 7 || $month == 8 || $month == 9)
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=" . $month . " AND weekday=".$wid." ORDER BY starttime;";
			else
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=0 AND weekday=".$wid." ORDER BY starttime;";
	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$numrows = mysql_num_rows($result);
		    	$res = array();
		    	for ($x = 0; $x < $numrows; $x++) 
		        	$res[] = mysql_fetch_assoc($result);
		        $db->close(); 
		    	return json_encode($res);
		    }
	        die('impossibile alle lezioni odierne');

    	}


    	function getWeekdayByMonth($db, $wid, $month){
    		if($month == 7 || $month == 8 || $month == 9)
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=" . $month . " AND weekday=".$wid." ORDER BY starttime;";
			else
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=0 AND weekday=".$wid." ORDER BY starttime;";
	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$numrows = mysql_num_rows($result);
		    	$res = array();
		    	for ($x = 0; $x < $numrows; $x++) 
		        	$res[] = mysql_fetch_assoc($result);
		        $db->close(); 
		    	return json_encode($res);
		    }
	        die('impossibile accedere alla voce selezionata');

    	}

    	function getByInstructorByMonth($db, $lid, $month){
    		if($month == 7 || $month == 8 || $month == 9)
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=" . $month . " AND (leaderid=".$lid." OR leaderid_alt = ".$lid.") ORDER BY weekday, starttime;";
			else
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=0 AND (leaderid=".$lid." OR leaderid_alt = ".$lid.") ORDER BY weekday, starttime;";

	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$numrows = mysql_num_rows($result);
		    	$res = array();
		    	for ($x = 0; $x < $numrows; $x++) 
		        	$res[] = mysql_fetch_assoc($result);
		        $db->close(); 
		    	return json_encode($res);
		    }
	        die('impossibile accedere alla voce selezionata');

    	}

   		function getByTagByMonth($db, $tag, $month){
   			if($month == 7 || $month == 8 || $month == 9)
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=" . $month . " AND tag=".$tag." ORDER BY weekday, starttime;";
			else
				$query = "SELECT ts.* FROM trainingschedule ts WHERE month=0 AND tag=".$tag." ORDER BY weekday, starttime;";

	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$numrows = mysql_num_rows($result);
		    	$res = array();
		    	for ($x = 0; $x < $numrows; $x++) 
		        	$res[] = mysql_fetch_assoc($result);
		        $db->close(); 
		    	return json_encode($res);
		    }
	        die('impossibile accedere alla voce selezionata');

    	}

	}
?>