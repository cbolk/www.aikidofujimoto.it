<?php

	class classinstructor {

		function add($db,$data){
			$query = "INSERT INTO traininginstructor SET fullname='".$data['fullname']."', shortbio='".$data['shortbio']."', lastname='".$data['lastname']."', rank='". $data['rank']."';";
	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		        $db->close(); 
		    	return 0;
		    }
	        die('impossibile aggiungere la nuova voce');
    	}

		function del($db,$id){
			$query = "DELETE FROM traininginstructor WHERE ID=".$id.";";
    		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$db->close(); 
		    	return 0;
		    }
	        die('impossibile eliminare la voce selezionata');
    	}

		function upd($db,$data){
			$query = "UPDATE traininginstructor SET fullname='".$data['fullname']."', shortbio='".$data['shortbio']."', lastname='".$data['lastname']."', rank='". $data['rank']."' WHERE ID=".$data['id'].";";
    		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$db->close(); 
		    	return 0;
		    }
	        die('impossibile aggiornare la voce selezionata');
    	}

		function updField($db,$updateqry){
			$query = "UPDATE traininginstructor SET ". $updateqry .";";
    		$db->dbconnect();
		    if($result = $db->qry($query)){
		    	$db->close(); 
		    	return 0;
		    }
	        die('impossibile aggiornare la voce selezionata');
    	}

    	function get($db){
			$query = "SELECT * FROM traininginstructor ORDER BY lastname;";
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

    	function getFromId($db, $id){
			$query = "SELECT * FROM traininginstructor WHERE ID=".$id.";";
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

    	function getFromLastname($db, $lastname){
			$query = "SELECT * FROM traininginstructor WHERE lastname='".$lastname."';";
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

    	function findInstructor($list, $id) {
			$n = count($list);
			for($i = 0; $i < $n; $i++)
				if($list[$i]['id'] == $id)
	            	return $list[$i];	    

	        return null;
		}

	}
?>