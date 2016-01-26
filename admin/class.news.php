<?php

  class news {
  	
  	var $id;
  	var $date;
  	var $expires;
  	var $title;
  	var $description;
  	
   	/* clear all fields */
  	function clear()
  	{
  		foreach ($this as &$value) 
 		   $value = null;
  	}

  	function get($dbconn, $nid){
  		$n = $this->getNews($dbconn, $nid);
		$this->id =  $n[0]['id'];
		if($this->id === NULL)
			return;
			
  		$this->date = $n[0]['date'];
  		$this->title = $n[0]['title'];
  		$this->description = $n[0]['description'];
  		$this->expires = $n[0]['expires'];
  		
	}

  	/* retrieves the information of a piece of news, given its ID */
  	/* returns an array */
	function getNews($dbconn, $nid)
	{
		$query = "SELECT * FROM news WHERE id = " . $nid . ";";
//		echo $query;
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum == 1){	/* news */
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
	}

	function add($dbconn)
	{
		$query = "INSERT INTO news (date, title, description, expires) ";
		$query = $query . " VALUES ('$this->date','$this->title','$this->description','$this->expires');";

		//echo $query;

		$result = $dbconn->qry($query);
		$newID = mysql_insert_id(); 

		return $newID;		
	}

	/* updates the info of a piece of news */
	function update($dbconn){

		$query = "UPDATE news SET date='$this->date', title='$this->title', description='$this->description', expires='$this->expires'";
		$query = $query . " WHERE id = " . $this->id . ";";

		echo $query;
		$result = $dbconn->qry($query);

		return $this->id;
	}

	/* deletes a piece of news */
	function del($dbconn){

		$query = "DELETE FROM news WHERE id = " . $this->id . ";";
		$result = $dbconn->qry($query);

		return $result;

	}

  	function rawlist($dbconn, $activeonly){
  		if($activeonly)
			$query = "SELECT * from news where DATE(expires) > DATE(NOW()) OR expires='0000-00-00' order by date desc;";
  		else
			$query = "SELECT * from news order by date desc;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
  		return $result;
  	}
  	
	/* returns the number of active news */
	function numActiveNews($dbconn)
	{
		$query = "SELECT COUNT(*) FROM news WHERE DATE(expires) > DATE(NOW()) OR expires='0000-00-00';";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $row = mysql_fetch_array($result);
        return $row[0];
        
	}

	/* returns the number of news */
	function numNews($dbconn)
	{
		$query = "SELECT COUNT(*) FROM news ;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $row = mysql_fetch_array($result);
        return $row[0];
        
	}
 	
  	function listall($dbconn,$mainpage,$editlink,$dellink){
		$strout = "<div class='actions aright'>";
		$strout = $strout . "<a class='btn-fuji adm-list' href=$mainpage>elenco notizie</a>&nbsp;";
		$strout = $strout . "<a class='btn-fuji adm-add' href=$mainpage?Mod=nuovo>nuova notizia</a>";
		$strout = $strout . "</div>";
		$strout = $strout . "<div id='tablearea'>";
  		$strout = $strout . "<table class='tlist'>
			<tr>	
  			<th width=10%>data</th>
  			<th width=22%>titolo</th>
  			<th width=42%>descrizione</th>
  			<th width=10%>scadenza</th>
  			<th width=5%>mod.</th>
  			<th width=5%>del.</th>
  			</tr>
  		";
			
		$query = "SELECT * from news order by date desc;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $rownum = mysql_num_rows($result);
        if($rownum > 0){
			$counter = 1;
			while ($row = mysql_fetch_array($result)){
				$mod = fmod($counter,2);
				if ($mod == 1)
					$class = 'todd';
				else
					$class = 'teven';
				if(($row["expires"] != "0000-00-00") && dateExp($row["expires"]))
					$class = $class . ' ' . ' texpired';
				$strout = $strout . "<tr class='" . $class . "'>";
				$strout = $strout . "<td class='tdediting'>" . $dbconn->db_to_date($row["date"]) . "</td>";
				$strout = $strout . "<td class='tdediting'>" . $row["title"] . "</td>";
				$strout = $strout . "<td class='tdediting'>" . $row["description"]. "</td>";
				$strout = $strout . "<td class='tdediting'>";
				if($row["expires"] != "0000-00-00")
					$strout = $strout . $dbconn->db_to_date($row["expires"]);	
				$strout = $strout . "</td>";
				$strout = $strout . "<td align=center>";
				$strout = $strout . "<a href='" . $editlink ."&ID=$row[id]'><img alt='aggiorna' src=./images/edit.png></a>";	
				$strout = $strout . "</td>";
				$strout = $strout . "<td align=center><a href='" . $dellink ."&ID=$row[id]'><img alt='elimina' src=./images/delete.png></a></td>";				
				$strout = $strout . "</tr>";				
				$counter++;
			}
        } else {
        	$strout = $strout . "<tr><td class='tdediting acenter' colspan='6'><strong>nessuna notizia</strong></td></tr>";
        }
  		$strout = $strout . "</table>";
		$strout = $strout . "</div>";
  		return $strout;
  	}

  	
  }