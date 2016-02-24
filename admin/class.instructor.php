<?php

  class instructor {

  	var $id;
  	var $firstname;
  	var $lastname;
  	var $rank;
  	var $sorting;

	function get($dbconn, $aid){
		$query = "SELECT * from instructor where id=" . $aid . ";";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $numrows = mysql_num_rows($result); 
        if($numrows == 1){
	  		$row = mysql_fetch_assoc($result);
	  		$this->id = $row['id'];
	  		$this->firstname = $row['firstname'];
	  		$this->lastname = $row['lastname'];
	  		$this->rank = $row['rank'];
	  		$this->yudansha = $row['sorting'];
	  		return $this;
        }
        return null;
	}

  	/* clear all fields */
  	function clear()
  	{
  		foreach ($this as &$value) 
 		   $value = null;
  	}

	/* adds a new aikidoka */
	function add($dbconn){

		$query = "INSERT INTO instructor (lastname, firstname, rank, sorting) ";
		$query = $query . " VALUES ('$this->lastname','$this->firstname','$this->rank','$this->sorting');";
		//echo $query;
		$result = $dbconn->qry($query);
		$newID = mysql_insert_id(); 

		return $newID;
	}

	/* deletes an aikidoka */
	function del($dbconn){

		$query = "DELETE FROM instructor WHERE id = " . $this->id . ";";
		$result = $dbconn->qry($query);
		
		return $result;

	}
	
	/* updates the information of an aikidoka */
	function update($dbconn){
		
		$query = "UPDATE instructor SET lastname='$this->lastname', firstname='$this->firstname', rank='$this->rank', sorting='$this->sorting' WHERE id = " . $this->id;
		$result = $dbconn->qry($query);
		
		return $result;
	}


  	function rawlist($dbconn){
		$query = "SELECT * FROM instructor where ORDER BY lastname, firstname, sorting ASC;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
  		return $result;
  	}
  	
  	
  	function fullname($dbconn, $aid){
		$query = "SELECT firstname, lastname, concat(firstname, ' ', lastname) as fullname from instructor where id=" . $aid . ";";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
 		
     	$numrows = mysql_num_rows($result); 
    	$data = array();
    	for ($x = 0; $x < $numrows; $x++) {
        	$data[$x] = mysql_fetch_assoc($result);
    	}
    	return $data;
   		//return json_encode($data);     
  	}

  }
