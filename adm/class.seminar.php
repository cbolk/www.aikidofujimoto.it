<?php

  class seminar {

  	var $id;
  	var $fromdate;
  	var $fromtime;
  	var $dtstart;
  	var $shortdate;
  	var $todate;
  	var $totime;
  	var $dtend;
  	var $title;
  	var $description;
  	var $locationfk;
  	var $fulllocation;
  	var $location;
  	var $address;
  	var $city;
  	var $shortcity;
    var $lat;
    var $long;
  	var $seminartype;
  	var $instructors = array();
  	var $instructorlabel;
  	var $instructortag;
  	var $organizerfk;
  	var $organizer;
  	var $phone;
  	var $email;
  	var $opening;
  	var $url;
  	var $tags;
  	var $pdf;
  	var $image;
  	var $photo;
  	var $pagelink;
  	var $ics;
  	var $gcal;
  	var $expires;
  	var $notes;
  	var $schedule;
  	var $fees;

  	/* retrieves the info of a seminar */
  	function get($dbconn, $sid){
  		$sem = $this->getStage($dbconn, $sid);
//  		print_r($sem);
		$this->id =  $sem[0]['id'];
		if($this->id === NULL)
			return;

  		$this->fromdate = $sem[0]['startdate'];
  		$this->shortdate = date("Ymd", strtotime($this->fromdate));
  		$this->fromtime = $sem[0]['starthour'];
  		$this->dtstart = date("Ymd", strtotime($this->fromdate)) . "T" . str_replace(":", "", $this->fromtime) . "Z";
  		$this->todate = $sem[0]['enddate'];
  		$this->totime = $sem[0]['endhour'];
  		$this->dtend = date("Ymd", strtotime($this->todate)) . "T" . str_replace(":", "", $this->totime) . "Z";
  		$this->description = $sem[0]['description'];
  		$this->title = $sem[0]['shortdescription'];

	    $this->locationfk = $sem[0]['locationfk'];
		if($this->locationfk != 0 && $this->locationfk != NULL){
    		$loc = $this->getLocation($dbconn, $this->locationfk);
			$this->location = $loc[0]['name'];
			$this->address = $loc[0]['address'];
			$this->city = $loc[0]['city'];
			$this->shortcity =$loc[0]['shortcity'];
		    $this->long = $loc[0]['longitude'];
		    $this->lat = $loc[0]['latitude'];
		    $this->placeID = $loc[0]['placeID'];
		} else {
			$this->location = $sem[0]['location'];
			$this->address = $sem[0]['address'];
			$this->city = $sem[0]['city'];
			$this->shortcity =$sem[0]['shortcity'];
		}
		$this->fulllocation = "<strong>" . $this->location . "</strong>: " . $this->address . " - " . $this->city;

		$this->seminartype = $sem[0]['semtype'];

		$this->organizerfk = $sem[0]['organizerfk'];
		if($this->organizerfk != 0){
			$this->organizer = $sem[0]['orgname'];
			$this->phone = $sem[0]['orgphone'];
			$this->email = $sem[0]['orgmail'];
			if(strpos($sem[0]['orgurl'],"http")==0)
				$this->url = $sem[0]['orgurl'];
			else
				$this->url = "http://" . $sem[0]['orgurl'];
			$this->opening = $sem[0]['orghours'];
		} else {
			$this->organizer = $sem[0]['organizer'];
			$this->phone = $sem[0]['phone'];
			$this->email = $sem[0]['email'];
			if(strpos($sem[0]['url'],"http")==0)
				$this->url = $sem[0]['url'];
			else
				$this->url = "http://" . $sem[0]['url'];
			$this->opening = "";
		}

		$this->pdf = $sem[0]['pdf'];
		$this->image = $sem[0]['image'];
		$this->photo = $sem[0]['photo'];
		$this->tags = $sem[0]['tags'];
		$this->notes = $sem[0]['notes'];
		$this->schedule = $sem[0]['schedule'];
  		$this->fees = $sem[0]['fees'];

		$this->instructors = $this->getStageInstructors($dbconn, $this->id);
		$ninst = count($this->instructors);
		$this->instructorlabel = "";
		$this->instructortag = "";
		for($i = 0; $i < $ninst; $i++){
			$this->instructorlabel = $this->instructorlabel . "M&deg; " . $this->instructors[$i]['lastname'];
			$this->instructortag = $this->instructortag . substr($this->instructors[$i]['lastname'],1);
			if($i < $ninst - 1)
				$this->instructorlabel = $this->instructorlabel . " &amp; ";
		}

		$this->pagelink = $sem[0]['link'];
		$this->ics = $sem[0]['ics'];
		$this->gcal = $sem[0]['gcal'];

		$this->expires = $sem[0]['expires'];
		return $this;
  	}

  	/* clear all fields */
  	function clear()
  	{
  		foreach ($this as &$value) 
 		   $value = null;
  	}

  	/* retrieves the information of a stage, given its ID */
  	/* returns an array */
	function getStage($dbconn, $sid)
	{
		$query = "SELECT s.*, st.description as semtype, l.name as locname, l.address as locaddress, l.city as loccity, l.shortcity as locshortcity, l.placeID as locplaceID, o.name as orgname, o.phone as orgphone, o.email as orgmail, o.website as orgurl, o.openinghours as orghours FROM seminar s LEFT JOIN seminartype st ON s.typefk=st.id LEFT JOIN location l ON s.locationfk = l.id LEFT JOIN location o ON s.organizerfk = o.id WHERE s.id = " . $sid . ";";
//		echo $query;
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum == 1){	/* stage */
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
	}

	/* returns the data of the next seminar to be held*/
	function getNextStage($dbconn)
	{
		$query = "SELECT s.*, st.description as semtype, l.name as locname, l.address as locaddress, l.city as loccity, l.shortcity as locshortcity, l.placeID as locplaceID, o.name as orgname, o.phone as orgphone, o.email as orgmail, o.website as orgurl, o.openinghours as orghours FROM seminar s LEFT JOIN seminartype st ON s.typefk=st.id LEFT JOIN location l ON s.locationfk = l.id LEFT JOIN location o ON s.organizerfk = o.id WHERE  s.enddate >= DATE(NOW()) order by s.startdate asc LIMIT 1;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum == 1){	/* next upcoming stage */
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;
			return $data;
        }
        return null;
	}

	/* returns the ID of the next seminar to be held*/
	function getNextStageID($dbconn)
	{
		$query = "SELECT id FROM seminar WHERE enddate >= DATE(NOW()) order by startdate asc LIMIT 1;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum == 1){	/* next upcoming stage */
	        $row = mysql_fetch_assoc($result);
			return $row['id'];
        }
        return null;
	}

	/* returns the data of the next seminar to be held
	COPIED ALSO TO UTILITIES */
	function getNextStageMMDD($dbconn)
	{
		$query = "SELECT startdate FROM seminar WHERE startdate >= DATE(NOW()) order by startdate asc LIMIT 1;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
        while($row = mysql_fetch_assoc($result)){
   	        $mmdd = sprintf($row['startdate'],4,4);
			return $mmdd;
        }
        return null;
	}


	/* adds a new seminar */
	function add($dbconn){

		$query = "INSERT INTO seminar (startdate, enddate, starttime, endtime, month, year, shortdescription, description, ";
		$query = $query . "locationfk, location, address, city, shortcity, schedule, fees, tags, typefk, organizerfk, ";
		$query = $query . "organizer, email, phone, url, link, ics, gcal, notes, pdf, image, photo, expires) ";
		$query = $query . " values ('$this->fromdate','$this->todate','$this->fromtime','$this->totime',MONTH('$this->fromdate'),YEAR('$this->todate'), '$this->title', '$this->description', ";
		$query = $query . " $this->locationfk, '$this->location', '$this->address', '$this->city', '$this->shortcity', '$this->schedule', '$this->fees', '$this->tags', $this->seminartype, $this->organizerfk, ";
		$query = $query . " '$this->organizer', '$this->email', '$this->phone', '$this->url', '$this->pagelink', '$this->ics', '$this->gcal', '$this->notes', '$this->pdf', '$this->image', '$this->photo', '$this->expires');";

		//echo $query;

		$result = $dbconn->qry($query);
		$newID = mysql_insert_id(); 

		/* add instructors */
		$inum = count($this->instructors);
		for($i = 0; $i < $inum; $i++){
			$query = "INSERT INTO seminarinstructor VALUES (" . $newID ."," . $this->instructors[$i]['id'] . "," . ($i+1) . ");";
			//echo $query;
			if(strpos($query,"NULL") == FALSE)
				$result = $dbconn->qry($query);
		}
		return $newID;
	}

	/* adds a new seminar */
	function update($dbconn){
		$this->setGCal();

		$query = "UPDATE seminar SET startdate='$this->fromdate', enddate='$this->todate', month=MONTH('$this->fromdate'), ";
		$query = $query . " startime='$this->fromtime',endtime='$this->totime', ";
		$query = $query . "year=YEAR('$this->todate'), description='$this->description', shortdescription='$this->title', ";
		$query = $query . "locationfk=$this->locationfk, location='$this->location', address='$this->address', city='$this->city', shortcity='$this->shortcity',";
		$query = $query . " schedule='$this->schedule', fees='$this->fees', tags='$this->tags', typefk=$this->seminartype, organizerfk=$this->organizerfk, ";
		$query = $query . "organizer='$this->organizer', email='$this->email', phone='$this->phone', url='$this->url', pdf='$this->pdf', link='$this->pagelink', ics='$this->ics', gcal='$this->gcal', notes='$this->notes', image='$this->image', photo='$this->photo', expires='$this->expires'";
		$query = $query . " WHERE id = $this->id;";

		$result = $dbconn->qry($query);

		/* update instructors by deleteing them first */
		$query = "DELETE FROM seminarinstructor WHERE seminarfk = " . $this->id . ";";
		$resultinst = $dbconn->qry($query);

		$inum = count($this->instructors);
		for($i = 0; $i < $inum; $i++){
			$query = "INSERT INTO seminarinstructor VALUES (" . $newID ."," . $this->instructors[$i]['id'] . "," . ($i+1) . ");";
			if(strpos($query,"NULL") == FALSE)
				$result = $dbconn->qry($query);
		}

		return $query;
	}

	/* delete a new seminar */
	function del($dbconn){

		$query = "DELETE FROM seminar WHERE id = " . $this->id . ";";
		$result = $dbconn->qry($query);

		/* instructors */
		$query = "DELETE FROM seminarinstructor WHERE seminarfk = " . $this->id . ";";
		$resultinst = $dbconn->qry($query);

		return $result;

	}

	/* retrieves the list of all seminar ids */
	function getStageListID($dbconn){
		$query = "SELECT id FROM seminar ORDER BY startdate DESC;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
        $data = array();
        while($row = mysql_fetch_assoc($result))
	        $data[] = $row;
		return $data;
	}

	function getStagesMonthYear($dbconn, $month, $year){
		$query = "SELECT s.*, st.description as semtype, l.name as locname, l.address as locaddress, l.city as loccity, l.placeID as locplaceID, o.name as orgname, o.phone as orgphone, o.email as orgmail, o.website as orgurl, o.openinghours as orghours FROM seminar s LEFT JOIN seminartype st ON s.typefk=st.id LEFT JOIN location l ON s.locationfk = l.id LEFT JOIN location o ON s.organizerfk = o.id WHERE (MONTH(startdate) = $month AND YEAR(startdate) = $year) OR (MONTH(enddate) = $month AND YEAR(enddate) = $year) ORDER BY startdate asc;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        if($result){
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;
        }
		return $data;
	}

  	function rawlist($dbconn, $activeonly, $thisyearonly){
  		if($thisyearonly){
			$today = Date('Y-m-d');
			if(date('m', strtotime($today)) >= 9)
				$year = date('Y', strtotime($today));
			else
				$year = date('Y', strtotime($today)) - 1;
			$from = $year . "-09-01";
  		}
  		if($activeonly && $thisyearonly)			
			$query = "SELECT * from seminar where DATE(startdate) >= '" . $from . "' AND (DATE(expires) > DATE(NOW()) OR expires='0000-00-00') order by startdate ASC;";
  		else if ($thisyearonly)
			$query = "SELECT * FROM seminar WHERE DATE(startdate) >= '" . $from . "' ORDER BY startdate DESC;";
		else
			$query = "SELECT * FROM seminar ORDER BY startdate DESC;";
		
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
  		return $result;
  	}

  	/* retrieves the list of seminars, eventually those that are active and/or upcoming only */
  	function getList($dbconn, $activeonly, $upcoming){
  		if($activeonly){
  			$strCond = "WHERE DATE(expires) > DATE(now()) OR expires='0000-00-00' ";
	  		if($upcoming)
  				$strCond = $strCond . " AND DATE(enddate) > DATE(now()) ";
  		} else if($upcoming)
  			$strCond = " WHERE DATE(enddate) > DATE(now()) ";

 		//$query = "SELECT * from seminar " . $strCond . " ORDER BY startdate DESC;";
 		$query = "SELECT * from seminar " . $strCond . " ORDER BY date DESC;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){	/* seminar type */
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
 	}

  	/* prints out the list of seminars, eventually those that are active and/or upcoming only */
  	function printList($dbconn,$mainpage,$editlink,$dellink,$uploaddir){
 		//$query = "SELECT * from seminar ORDER BY startdate DESC;";
        $strout = "<div id='tabledetails'>";
  		$strout = $strout . "<table class='admin__table'>";
  		$strout = $strout . "<tr>
  			<th width=8%>dal</th>
  			<th width=8%>al</th>
  			<th width=20%>luogo</th>
  			<th width=24%>strillo</th>
  			<th width=15%>maestri</th>
  			<th width=5%>exp</th>
  			<th width=5%>mod.</th>
  			<th width=5%>del.</th>
  			</tr>
  		";
//  		$query = "SELECT * FROM seminar s LEFT JOIN location l ON s.locationfk = l.id ORDER BY startdate DESC";
 		$query = "SELECT * from seminar s ORDER BY startdate DESC;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){	/* seminar type */
			$counter = 1;

	        while($row = mysql_fetch_assoc($result)){
				$mod = fmod($counter,2);
				if ($mod == 1)
					$class = 'todd';
				else
					$class = 'teven';
				if(($row["expires"] != "0000-00-00") && dateExp($row["expires"]))
					$class = $class . ' ' . ' texpired';

				$strout = $strout . "<tr class='" . $class . "'>";
				$strout = $strout . "<td class='tdediting acenter'>" . $dbconn->db_to_date($row["startdate"]) . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $dbconn->db_to_date($row["enddate"]) . "</td>";

				$strout = $strout . "<td class='tdediting aleft'>" . $row["location"] . "</td>";
				$strout = $strout . "<td class='tdediting aleft'>" . $row["shortdescription"] . "</td>";

				$strout = $strout . "<td class='tdediting acenter'>";
				$instructors = $this->getStageInstructors($dbconn,$row["id"]);
				$nin = count($instructors);
				for($i = 0; $i < $nin; $i++){
					$strout = $strout . " M&deg; " . $instructors[$i]['lastname'];
					if($i < $nin-1)
						$strout = $strout . "<br/>";
				}
				$strout = $strout . "</td>";

				$strout = $strout . "<td class='tdediting'>" ;
				if($row["expires"] != "0000-00-00")
					$strout = $strout . $dbconn->db_to_date($row["expires"]);
				$strout = $strout . "</td>";
				$strout = $strout . "<td align=center>";
				$strout = $strout . "<a href='" . $editlink ."&ID=$row[id]'><i class='fa fa-pencil'> </i></a>";
				$strout = $strout . "</td>";
				$strout = $strout . "<td align=center><a href='" . $dellink ."&ID=$row[id]'><i class='fa fa-trash-o'> </i></a></td>";
				$strout = $strout . "</tr>";
				$counter++;
	        }
        }
   		$strout = $strout . "</table>";
		$strout = $strout . "</div>";
		return $strout;
 	}

  	function listall($dbconn,$mainpage,$editlink,$dellink,$uploaddir){
		$strout = "<div id='tablearea'>";
  		$strout = $strout . "<table class='tlist'>
			<tr>
  			<th width=5%>inizio</th>
  			<th width=5%>fine</th>
  			<th width=10%>date</th>
  			<th width=15%>luogo</th>
  			<th width=15%>descrizione</th>
  			<th width=15%>organizzazione</th>
  			<th width=15%>email</th>
  			<th width=5%>loc.</th>
  			<th width=5%>exp</th>
  			<th width=5%>mod.</th>
  			<th width=5%>del.</th>
  			</tr>
  		";

		$query = "SELECT * from seminar order by startdate desc;";
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
				$strout = $strout . "<td class='tdediting'>" . $dbconn->db_to_date($row["startdate"]) . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $dbconn->db_to_date($row["enddate"]) . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["datetext"] . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["location"] . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["description"] . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["organizer"]. "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["email"]. "</td>";
				if($row["pdf"] != ""){
					$strout = $strout . "<td class='tdediting acenter'><a target=_blank href='/" . $uploaddir . "/" .$row["pdf"] . "' alt='locandina dell\'evento'><img src='./images/locandina1.jpg'></a></td>";
				} else
					$strout = $strout . "<td class='tdediting'>&nbsp;</td>";

				$strout = $strout . "<td class='tdediting'>" ;
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
        	$strout = $strout . "<tr><td class='tdediting acenter' colspan='6'><strong>nessun seminario</strong></td></tr>";
        }
  		$strout = $strout . "</table>";
		$strout = $strout . "</div>";
  		return $strout;
  	}


	/* retrieves the instructors for a given stage by ID */
	function getStageInstructors($dbconn, $sid)
	{
		$query = "SELECT i.* from instructor i INNER JOIN seminarinstructor si ON i.id=si.instructorfk WHERE si.seminarfk = " . $sid . " ORDER BY sorting;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){	/* next upcoming stage */
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
	}

	/* builds a selection for the instructors */
	function getStageInstructorsDropdown($dbconn,$order,$iid=NULL)
	{
		$query = "SELECT * from instructor ORDER BY sorting, rank DESC;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){
	        $data = "<select class='seminardd' name='seminarinstructor" . $order . "'>";
	        while($row = mysql_fetch_assoc($result)){
    	        $data = $data . "<option ";
    	        if($iid != NULL && $iid == $row['id'])
    	        	$data = $data . " selected ";
	    	    $data = $data . " value='" . $row['id'] . "'>" . $row['lastname'] . "</option>";
	        }

	        $data = $data . "<option value='NULL'";
	        if($iid == NULL || $iid == 0)
	        	$data = $data . " selected ";
	        $data = $data . ">&nbsp;</option>";
    	    $data = $data . "</select>";
        }
		return $data;
	}

	/* builds a list of options for the dropdown of the selection for the instructors */
	function getStageInstructorsOptions($dbconn,$iid=NULL)
	{
		$query = "SELECT * from instructor ORDER BY sorting, rank DESC;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){
	        $data = "";
	        while($row = mysql_fetch_assoc($result)){
    	        $data = $data . "<option ";
    	        if($iid != NULL && $iid == $row['id'])
    	        	$data = $data . " selected ";
	    	    $data = $data . " value='" . $row['id'] . "'>" . $row['lastname'] . "</option>";
	        }

	        $data = $data . "<option value='NULL'";
	        if($iid == NULL || $iid == 0)
	        	$data = $data . " selected ";
	        $data = $data . ">&nbsp;</option>";
    	    
        }
		return $data;
	}

	/* retrieves the type of a seminar */
	function getStageType($dbconn, $sid)
	{
		$query = "SELECT * from seminartype st INNER JOIN seminar s ON st.id=s.typefk WHERE s.id = " . $sid . ";";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){	/* seminar type */
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
	}

	/* gets types of seminars */
	function getTypes($dbconn)
	{
		$query = "SELECT * from seminartype ORDER BY name;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){	/* seminar type */
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
	}

	/* builds a selection for the instructors */
	function getTypeDropdown($dbconn,$tid = NULL)
	{
		$query = "SELECT * from seminartype ORDER BY description;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){
	       $data = "<select class='seminardd' name='seminartype'>";
	        while($row = mysql_fetch_assoc($result))
	        	if(($row['description'] == "ordinario" && $tid == NULL) || ($tid == $row['id']))
	    	        $data = $data . "<option selected value='" . $row['id'] . "'>" . $row['description'] . "</option>";
				else
	    	        $data = $data . "<option value='" . $row['id'] . "'>" . $row['description'] . "</option>";

	        $data = $data . "<option ";
	        if($tid == NULL || $tid == 0)
	        	$data = $data . " selected ";
	        $data = $data . " value='NULL'>&nbsp;</option>";
	    	$data = $data . "</select>";
        }
		return $data;
	}

	/* builds a list of options for the instructors */
	function getTypeOptions($dbconn,$tid = NULL)
	{
		$query = "SELECT * from seminartype ORDER BY description;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		$sel = false;
		if($rownum >= 1){
 	        $data = "";
	        while($row = mysql_fetch_assoc($result))
	        	if(($row['description'] == "ordinario" && $tid === NULL) || ($tid == $row['id'])){
	    	        $data = $data . "<option selected value='" . $row['id'] . "'>" . $row['description'] . "</option>";
	    	        $sel = true;
				} else
	    	        $data = $data . "<option value='" . $row['id'] . "'>" . $row['description'] . "</option>";

	        $data = $data . "<option ";
	        if($sel == false && ($tid == NULL || $tid == 0))
	        	$data = $data . " selected ";
	        $data = $data . " value='NULL'>&nbsp;</option>";
        }
		return $data;
	}

  function getLocation($dbconn, $lid)
	{
		$query = "SELECT * from location WHERE id= " . $lid .";";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
	}

	/* gets locations */
	function getLocations($dbconn)
	{
		$query = "SELECT * from location ORDER BY sorting;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){	/* seminar type */
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
	}

	/* builds a dropdown for the selection of the location */
	function getLocationDropdown($dbconn, $lid = NULL)
	{
		$query = "SELECT * from location ORDER BY sorting;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		$isFirst = true;
		if($rownum >= 1){	/* seminar type */
	        $data = "<select class='seminardd' name='locationid' onchange='updateLocation()'>";
	        while($row = mysql_fetch_assoc($result)){
				$data = $data . "<option city='" . $row['city'] ."' address='" . $row['address'] ."' value='" . $row['id'] . "'";
				if($lid != NULL){
					if($lid == $row['id'])
						$data = $data . " selected ";
				} else {
					if($isFirst){
						$data = $data . " selected ";
						$isFirst = false;
					}
				}
				$data = $data . ">" . $row['name'] . "</option>";
	        }

	        $data = $data . "<option value='NULL'>_inserisci_a_mano_</option>";
    	    $data = $data . "</select>";
        }

		return $data;
	}

	/* builds a list of options for a dropdown for the selection of the location */
	function getLocationOptions($dbconn, $lid = NULL)
	{
		$query = "SELECT * from location ORDER BY sorting;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		$isFirst = true;
		if($rownum >= 1){	/* seminar type */
	        $data = "";
	        while($row = mysql_fetch_assoc($result)){
				$data = $data . "<option city='" . $row['city'] ."' address='" . $row['address'] ."' value='" . $row['id'] . "'";
				if($lid != NULL){
					if($lid == $row['id'])
						$data = $data . " selected ";
				} else {
					if($isFirst){
						$data = $data . " selected ";
						$isFirst = false;
					}
				}
				$data = $data . ">" . $row['name'] . "</option>";
	        }

	        $data = $data . "<option value='NULL'>_inserisci_a_mano_</option>";
        }

		return $data;
	}

  	function getStageLocation($dbconn, $sid)
	{
		$query = "SELECT l.* from location l INNER JOIN seminar s  ON l.id = s.locationfk WHERE s.id= " . $sid .";";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
	}


	/* builds a dropdown for the selection of the organizer */
	function getOrganizerDropdown($dbconn, $oid = NULL)
	{
		$query = "SELECT * from location WHERE organizer = 1 ORDER BY sorting;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		$isFirst = true;
		if($rownum >= 1){	/* seminar type */
	        $data = "<select class='seminardd' name='organizerid' onchange='updateOrganizer()'>";
	        while($row = mysql_fetch_assoc($result)){
				$data = $data . "<option ";
				if($oid != NULL){
					if($oid == $row['id'])
						$data = $data . " selected ";
				} else {
					if($isFirst){
						$data = $data . " selected ";
						$isFirst = false;
					}
				}

				$data = $data . "optphone='" . $row['phone'] ."' optemail='" . $row['email'] ."' opturl='" . $row['website']  ."' value='" . $row['id'] . "'>" . $row['name'] . "</option>";
	        }
	        $data = $data . "<option value='NULL'>_inserisci_a_mano_</option>";
    	    $data = $data . "</select>";
        }

		return $data;
	}

	/* builds a dropdown for the selection of the organizer */
	function getOrganizerOptions($dbconn, $oid = NULL)
	{
		$query = "SELECT * from location WHERE organizer = 1 ORDER BY sorting;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		$isFirst = true;
		if($rownum >= 1){	/* seminar type */
	        $data = "";
	        while($row = mysql_fetch_assoc($result)){
				$data = $data . "<option ";
				if($oid != NULL){
					if($oid == $row['id'])
						$data = $data . " selected ";
				} else {
					if($isFirst){
						$data = $data . " selected ";
						$isFirst = false;
					}
				}

				$data = $data . "optphone='" . $row['phone'] ."' optemail='" . $row['email'] ."' opturl='" . $row['website']  ."' value='" . $row['id'] . "'>" . $row['name'] . "</option>";
	        }
	        $data = $data . "<option value='NULL'>_inserisci_a_mano_</option>";
        }

		return $data;
	}
	
	
	/* creates a preview of what will be shown in the list of seminars page */
	function getPreview($dbconn){
		$html = "";
		
		
		
		return $html;
	}
	
	
	/* creates the google calendar link */
	function setGCal(){
		$link = "http://www.google.com/calendar/event?action=TEMPLATE";
		$link = $link . "&text=" . str_replace("&deg;","°",str_replace(" ", "+", $this->title));
		if (strpos($this->title,"Maestro") == FALSE && strpos($this->title,"M&deg;") == FALSE && strpos($this->title,"M°") == FALSE )
			$link = $link . "+" . str_replace("&deg;","°",str_replace(" ", "+", str_replace("&amp;", "e",$this->instructorlabel)));
		$link = $link . "&dates=" . $this->dtstart;
	    if($this->fromtime != NULL && strpos($this->dtstart,"T") == FALSE)
	      $link = $link . "T" . str_replace(":","",$this->fromtime) . "Z";
	    $link = $link .  "/" . $this->dtend;
	    if($this->totime != NULL && strpos($this->dtend,"T") == FALSE)
	      $link = $link .  "T" . str_replace(":","",$this->totime) . "Z";
			$link = $link . "&location=" . str_replace(" ", "+", $this->location) . "%2C+". str_replace(" ", "+", $this->address) . "%2C+" . $this->city;
	    if($this->long != NULL)
	      $link = $link . "&ll=" . $this->long . "," . $this->lat ;
			$this->gcal = str_replace("<br/>","",$link);
	}

  	/* creates the ICS file */
  	function createICS(){
	    $icsFileName = $this->shortdate . "_" . $this->instructortag . ".ics";

	    $output =  "BEGIN:VCALENDAR\n";
	    $output = $output . "PRODID:-//AikikaiMilano//AikikaiMilano//IT\n";
	    $output = $output . "VERSION:2.0\n";
	    $output = $output . "METHOD:PUBLISH\n";

	    $output = $output . "BEGIN:VEVENT\n";
	    $output = $output . "CLASS:PUBLIC\n";
	    $output = $output . "DTSTART:" . $this->dtstart . "\n";
	    $output = $output . "DTEND:" . $this->dtend . "\n";
	    $output = $output . "LAST-MODIFIED:0101T000000n";
	    $output = $output . "LOCATION:" . $this->fulllocation . "\n";
	    $output = $output . "SUMMARY:" . $this->title . "\n";
	    $output = $output . "UID:" . date("Y", strtotime($ns->fromdate)) . date("m", strtotime($ns->fromdate)) . $this->id . "\n";  // UID just needs to be some random number.  I used rand() in PHP.

	    $output = $output . "END:VEVENT\n";
	    $output = $output . "END:VCALENDAR\n";
//	 	header('Content-type: text/calendar');
//		header('Content-Disposition: attachment; filename="' . $icsFileName . '"');
		echo $output;
	}

	function stagesOfTheMonthYear($dbconn, $month, $year){
		$query = "SELECT * FROM seminar WHERE (MONTH(startdate) = $month AND YEAR(startdate) = $year) OR (MONTH(enddate) = $month AND YEAR(enddate) = $year) ORDER BY startdate asc;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        if($result){
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;
        }
		return $data;
	}


	function stagesOfTheAYear($dbconn){
		$query = "SELECT * FROM seminar WHERE startdate > IF(NOW()>MAKEDATE(YEAR(NOW()),213),MAKEDATE(YEAR(NOW()),213),MAKEDATE(YEAR(NOW())-1,213)) ORDER BY startdate asc;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
		return $result;
	}

	function makeDate($dbconn){
		$query = "SELECT MAKEDATE(YEAR(NOW()),213) as D1, MAKEDATE(YEAR(NOW())-1,213) as D2;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $row = mysql_fetch_array($result);
        $strout = "[" . $row["D1"] . " - " . $row["D2"] . "]";
		return $strout;
	}

  	function lastStage($dbconn)
  	{
		$query = "SELECT * from seminar WHERE startdate >= DATE(NOW()) order by startdate desc LIMIT 1;";
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
				$strout = $strout . "<td class='tdediting'>" . $dbconn->db_to_date($row["startdate"]) . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $dbconn->db_to_date($row["enddate"]) . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["datetext"] . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["location"] . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["description"] . "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["organizer"]. "</td>";
				$strout = $strout . "<td class='tdediting acenter'>" . $row["email"]. "</td>";
				$strout = $strout . "</tr>";
				$counter++;
			}
			return $strout;
        }
        return null;

  	}

	function lastUpdate($dbconn)
	{

		$query = "SELECT * from seminar order by modified desc LIMIT 1;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $rownum = mysql_num_rows($result);
        $lastup = "--";
        if($rownum > 0){
			$row = mysql_fetch_array($result);
			$lastup = strftime("%A, %d %B %Y", strtotime($row["modified"]));
        }
		return $lastup;

	}

	/*
	function nextStage($dbconn)
	{
		$query = "SELECT * from seminar WHERE startdate >= DATE(NOW()) order by startdate asc LIMIT 1;";
		$dbconn->dbconnect();
		$result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum > 0){	 
			$row = mysql_fetch_array($result);
			$next = strtotime($row["startdate"]);
			return $next;
        }
		return null;
	}
	*/


	function monthNextStage($dbconn)
	{
		$date = $this->nextStage($dbconn);
		if($date != null)
			return date('m', $date);
		return date('m', strtotime(Date('Y-m-d')));
	}


	/* generate stage list for admin */
	function adminStageList($db,$page){
		$query = "SELECT * from seminar order by startdate asc;";
		$db->dbconnect();
		$result = $db->qry($query);
		$rownum = mysql_num_rows($result);
		$output = "<ul class='seminarlist'>";
		$output = $output . "<li class='seminarrow bbottom'><span class='seminarinfo'>dal</span>";
		$output = $output . "<span class='seminarinfo'>al</span>";
		$output = $output . "<span class='seminarinfo'>luogo</span>";
		$output = $output . "<span class='seminarinfo'>titolo</span>";
		$output = $output . "<span class='seminarinfo'>diretto da</span>";
		$output = $output . "<span class='seminarinfo'>pdf</span>";
		$output = $output . "<span class='seminarinfo'>min</span>";
		$output = $output . "<span class='seminarinfo'>img</span>";
		$output = $output . "<span class='seminarinfo'>edit</span>";
		$output = $output . "<span class='seminarinfo'>del</span>";
		$output = $output . "</li>";
		$cu = new utils();
		$odd = FALSE;
		while ($row = mysql_fetch_array($result)){
			$sid = $row['id'];
			$s = new seminar();
			$loc = $s->getStageLocation($db,$sid);
			$instr = $s->getStageInstructors($db,$sid);
			$nin = count($instr);

			$output = $output . "<li class='seminarrow" . $odd . "'>";
			$output = $output . "<span class='seminarinfo'><div class='semdate'>" .  $cu->date2monthday($row['startdate'])  . "</div></span>";
			$output = $output . "<span class='seminarinfo'><div class='semdate'>" . $cu->date2monthday($row['enddate']) . "</div></span>";

//			$output = $output . "<span class='seminarinfo'>" . $loc[0]['shortcity'] . "</span>";
			if($loc[0]['name'] != "")
				$output = $output . "<span class='seminarinfo'>" . $loc[0]['name'] . "</span>";
			else
				$output = $output . "<span class='seminarinfo'>" . $row['location'] . "</span>";

			$output = $output . "<span class='seminarinfo'>" . $row['shortdescription'] . "</span>";

			$output = $output . "<span class='seminarinfo'>" ;
			for($i = 0; $i < $nin; $i++){
				$output = $output . "M&deg;&nbsp;" . $instr[$i]['lastname'];
				if($i < $nin - 1)
					$output = $output . "<br/>";
			}
			$output = $output . "</span>";
			if($row['pdf'] != "")				
				$output = $output . "<span class='seminarinfo'><i class='fa fa-file-pdf-o'></i></span>";
			else
				$output = $output . "<span class='seminarinfo'></span>";

			if($row['image'] != "")				
				$output = $output . "<span class='seminarinfo'><i class='fa fa-file-image-o'></i></span>";
			else
				$output = $output . "<span class='seminarinfo'></span>";

			if($row['photo'] != "")				
				$output = $output . "<span class='seminarinfo'><i class='fa fa-picture-o'></i></span>";
			else
				$output = $output . "<span class='seminarinfo'></span>";

			$output = $output . "<span class='seminarinfo'><a href='$page?act=edit&sid=" . $sid . "'><i class='fa fa-pencil-square-o'></i></a></span>";
			$output = $output . "<span class='seminarinfo'><a href='$page?act=del&sid=" . $sid . "'><i class='fa fa-trash'></i></a></span>";

			$output = $output . "</li>";
			$odd = !$odd;
		}
		$output = $output . "</div>";
		return $output;
	}


	  /* full list of seminars */
	function generateListMonthSeminars($db, $num, $year, $semid, $nextUID){
		$s = new seminar();
		$today = date("Y-m-d");
		$thismonth = date("m");
	    $firstdaymonth = $year . "-" . sprintf("%02d", $num) . "-01";
		$nsem = count($semid);
		echo "<div class='seminarlist__month'>";
		echo "<div class='seminarlist__month_name'><a id='" . sprintf("%02d", $num) . "'></a>";
/*		if($thismonth == $num)
			echo getMonthNameFromNumber($num) . "&nbsp;<i class='small fa fa-thumb-tack'></i>";
		else
			echo getMonthNameFromNumber($num); */
		$util = new utils();
		echo  $util->getMonthNameFromNumber($num) . "</div>";
		for($isem = 0; $isem < $nsem; $isem++){
			$SemID = $semid[$isem]["id"];
			$seminario = $s->get($db,$SemID);
			$from = $util->medDate($seminario->fromdate);
			$fromMob = $util->medDate($seminario->fromdate);
			$to = $util->medDate($seminario->todate);
			$toMob = $util->medDate($seminario->todate);
			$semUID = sprintf(str_replace("-", "", $seminario->fromdate),4,4);
			echo "<a id='" . $semUID . "'></a>";
			echo "<div class='seminarlist__event";
			$close = "";
			$ribbon = "";
	     	if(strtotime($seminario->todate) < strtotime($today))
		        echo "_past";
		    else /* cannot be past for sure ... */
		    	if ($semUID == $nextUID){
		    		$close = "_evidence";
		    		$ribbon = "<div class='mobile ribbon'><i class='fa fa-bookmark'></i></div>";
		    	}
		    echo $close ."'>";
		    echo $ribbon;
			echo "<div class='seminarlist__datebox'>";
			echo "<div class='seminarlist__date'><span class='fa-stack fa-lg'><i class='fa fa-calendar-o fa-stack-2x calendar__category_seminar";
			if(strtotime($seminario->todate) < strtotime($today))
				echo "_past";
			echo "'></i><span class='fa-stack-1x calendar-text top10'>";
      		$days2add = 0;
      		while(strtotime($seminario->fromdate) + $days2add*(24 * 60 * 60 * 1000) < strtotime($firstdaymonth))
        		$days2add++;
      		if($days2add == 0)
        		echo date("d", strtotime($seminario->fromdate));
      		else
        		echo date("d", strtotime($firstdaymonth));

			echo "</span></span></div>";
/**/		echo "</div><!--seminarlist__datebox-->";
			echo "<div class='seminarlist__description'>";
			echo "  <div class='seminarlist__type'>Seminario " . $seminario->seminartype  ."</div>";
			echo "  <div class='seminarlist__title'>" . $seminars[$isem]["shortdescription"];
			if (strpos($seminario->title,"Maestro") == FALSE && strpos($seminario->title,"M&deg;") == FALSE && strpos($seminario->title,"M°") == FALSE ){
				echo $seminario->title . '<br/>' . $seminario->instructorlabel;
			} else {
				echo $seminario->title ;
			}
			$seminario->setGCal();
			echo "  </div>";
			echo "  <div class='seminarlist__meta'><i class='fa fa-calendar fa-fw'></i>&nbsp;<em>da</em> " .   $from . " <em>a</em> " . $to . "</div>";
			echo "  <div class='seminarlist__meta'><i class='fa fa-map-o fa-fw'></i>&nbsp;<span class='sc'>" . $seminario->shortcity . "</span>&nbsp;&#9671;&nbsp;" . str_replace("<br/>", " ", $seminario->location) . "</div>";
			echo "  <div class='seminarlist__meta'><a class='noborder' href='/_seminar.php?sid=$SemID'> leggi tutti i dettagli <i class='fa fa-angle-double-right'></i></a></div>";
			echo "<div class='seminarlist__details'>";
			if ($seminario->ics != "")
				echo "<a class='noborder' title='aggiungi al calendario' href='/stages/$seminario->shortdate.ics'><i class='fa fa-calendar-plus-o fa-fw'></i> .ics</a>";
			else
				echo "<a class='noborder' title='aggiungi al calendario' href='/stages/$seminario->shortdate.ics'></a><i class='fa fa-calendar-plus-o fa-fw'></i> .ics";			
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='noborder' title='aggiungi a Google Calendar' target=_blank href='$seminario->gcal'><i class='fa fa-calendar-plus-o fa-fw'></i> GCal</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			if($seminario->pdf != NULL)
				echo "<a class='noborder disable' title='scarica la locandina' href='/stages/$seminario->pdf'><i class='fa fa-file-pdf-o fa-fw'></i>locandina</a>";
			else
				echo "<i class='fa fa-file-pdf-o fa-fw'></i>disponibile prossimamente</a>";
			echo "</div>";
			echo "</div><!--seminarlist__description-->";
		    if($seminario->photo != NULL)
        		echo "<div class='seminarlist__photobox'><img src='./stages/$seminario->photo' class='seminarlist__photo' /></div>";
			echo "</div><!--seminarlist__event-->";
		}
		echo "</div><!--seminarlist__month-->";
	}

	/* generates one seminar element for the seminars' list page */
	function generateSeminarPost($db, $SemID = NULL, $s = NULL){
		if($SemID != NULL){ /* load seminar info from DB */
			$s = new seminar();
			$seminario = $s->get($db,$SemID);
		} else /* seminar info passed with $s */
			$seminario = $s;
		$util = new utils();
		$from = $util->medDate($seminario->fromdate);
		$fromMob = $util->medDate($seminario->fromdate);
		$to = $util->medDate($seminario->todate);
		$toMob = $util->medDate($seminario->todate);
		$semUID = sprintf(str_replace("-", "", $seminario->fromdate),4,4);
		$html = "<a id='" . $semUID . "'></a>";
		$html = $html . "<div class='seminarlist__event";
	    if(strtotime($seminario->todate) < strtotime($today))
			$html = $html . "_past";
		$html = $html . "'></i><span class='fa-stack-1x calendar-text top10'>";
  		$days2add = 0;
  		while(strtotime($seminario->fromdate) + $days2add*(24 * 60 * 60 * 1000) < strtotime($firstdaymonth))
    		$days2add++;
  		if($days2add == 0)
    		$html = $html . date("d", strtotime($seminario->fromdate));
  		else
    		$html = $html . date("d", strtotime($firstdaymonth));

		$html = $html . "</span></span></div>";
		$html = $html . "</div><!--seminarlist__datebox-->";
		$html = $html . "<div class='seminarlist__description'>";
		$html = $html . "  <div class='seminarlist__type'>Seminario " . $seminario->seminartype  ."</div>";
		$html = $html . "  <div class='seminarlist__title'>" . $seminars[$isem]["shortdescription"];
		if (strpos($seminario->title,"Maestro") == FALSE && strpos($seminario->title,"M&deg;") == FALSE && strpos($seminario->title,"M°") == FALSE ){
			$html = $html . $seminario->title . '<br/>' . $seminario->instructorlabel;
		} else {
			$html = $html . $seminario->title ;
		}
		$html = $html . "  </div>";
		$html = $html . "  <div class='seminarlist__meta'><i class='fa fa-calendar fa-fw'></i>&nbsp;<em>da</em> " .   $from . " <em>a</em> " . $to . "</div>";
		$html = $html . "  <div class='seminarlist__meta'><i class='fa fa-map-o fa-fw'></i>&nbsp;<span class='sc'>" . $seminario->shortcity . "</span>&nbsp;&#9671;&nbsp;" . str_replace("<br/>", " ", $seminario->location) . "</div>";
		$html = $html . "  <div class='seminarlist__meta'><a class='noborder' href='/_seminar.php?sid=$SemID'> leggi tutti i dettagli <i class='fa fa-angle-double-right'></i></a></div>";
		if($seminario->pdf != NULL)
			$html = $html . "<a class='noborder disable' title='scarica la locandina' href='/stages/$seminario->pdf'><i class='fa fa-file-pdf-o fa-fw'></i>locandina</a>";
		else
			$html = $html . "<i class='fa fa-file-pdf-o fa-fw'></i>disponibile prossimamente</a>";
		$html = $html . "</div>";
		$html = $html . "</div><!--seminarlist__description-->";
	    if($seminario->photo != NULL)
    		$html = $html . "<div class='seminarlist__photobox'><img src='./stages/$seminario->photo' class='seminarlist__photo' /></div>";
		$html = $html . "</div><!--seminarlist__event-->";		
		
		return $html;
	}


	function generateMonthWSeminars($num, $year, $seminars){
		$firstdaymonth = $year . "-" . sprintf("%02d", $num) . "-01";
		$dayofweek = date('w', strtotime($firstdaymonth));
		$daysinmonth = cal_days_in_month(CAL_GREGORIAN, $num, $year);
		$today = date("Y-m-d");
		$thismonth = date("m");
		$nsem = count($seminars);
		$isem = 0;
		$SemStartDate = $seminars[$isem]["startdate"];
		$SemEndDate = $seminars[$isem]["enddate"];
		$ShortDescription = $seminars[$isem]["shortdescription"];
		$SemId = $seminars[$isem]["id"];
		$isSem = 0;
		echo "<div class='calendar__month'>";
		echo "<div class='calendar__month_name'><a id='" . sprintf("%02d", $num) . "'></a>";
		if($thismonth == $num)
			echo "<strong>" . getMonthNameFromNumber($num) . "</strong>&nbsp;<i class='blue_seminar fa fa-map-pin'></i>";
		else
			echo getMonthNameFromNumber($num);
		echo  "</div>";
		for($i = 1, $j = ($dayofweek + 6) % 7; $j > 0; $j--, $i++)
			echo "<div class='calendar__day calendar__day_not_in_month'  style=''>NA </div>";
		for($day = 1; $day <= $daysinmonth; $day++){
			while($i >= 1 && $i < 6 && $day <= $daysinmonth){
				$fulldate = date("Y-m-d", mktime(0, 0, 0, $num, $day, $year));
				echo "<div class='calendar__day calendar__day_working";
				if(($isem < $nsem) && ($fulldate >= $SemStartDate) && (strtotime($fulldate) <= strtotime($SemEndDate))){
					$isSem = 1;
					$SemDescription = $ShortDescription;
					echo " calendar__category_seminar_bk";
					if(strtotime($fulldate) < strtotime($today))
						echo "_past";
					echo "' alt='$SemDescription' style='cursor: pointer'>";
					if(strtotime($fulldate) == strtotime($SemEndDate) && ($isem < $nsem-1)) {
						$isem++;
						$SemStartDate = $seminars[$isem]["startdate"];
						$SemEndDate = $seminars[$isem]["enddate"];
						$ShortDescription = $seminars[$isem]["shortdescription"];
						$SemId = $seminars[$isem]["id"];
					}
				} else
					echo "' style=''>";

				if($isSem == 1){
					echo "<a class='noborder' href='./_seminar.php?sid=$SemId'>$day</a>";
					echo "<div class='calendar__tooltip' onclick='location.href=&apos;./_seminar.php?sid=$SemId&apos;'><div class='calendar__tooltip__description'>" . $SemDescription . "</div></div>";
					$isSem = 0;
				} else
					echo "$day";

				echo "</div>";
				$i++;
				$day++;
			}
			if($i == 6 && $day <= $daysinmonth){
				/* saturday */
				$fulldate = date("Y-m-d", mktime(0, 0, 0, $num, $day, $year));
				echo "<div class='calendar__day calendar__day_not_working";
				if(($isem < $nsem) && ($fulldate >= $SemStartDate) && ($fulldate <= $SemEndDate)){
					$isSem = 1;
					echo " calendar__category_seminar_bk";
					if(strtotime($fulldate) < strtotime($today))
						echo "_past";
					echo "' alt='$SemDescription' style='cursor: pointer'>";
					$SemDescription = $ShortDescription;
					if(strtotime($fulldate) == strtotime($SemEndDate) && ($isem < $nsem-1)) {
						$isem++;
						$SemStartDate = $seminars[$isem]["startdate"];
						$SemEndDate = $seminars[$isem]["enddate"];
						$ShortDescription = $seminars[$isem]["shortdescription"];
						$SemId = $seminars[$isem]["id"];
					}
				} else
					echo "' style=''>";
				if($isSem == 1){
					echo "<a class='noborder' href='./_seminar.php?sid=$SemId'>$day</a>";
					echo "<div class='calendar__tooltip' onclick='location.href=&apos;./_seminar.php?sid=$SemId&apos;'><div class='calendar__tooltip__description'>" . $SemDescription . "</div></div>";
					$isSem = 0;
				} else
					echo "$day";

				echo "</div>";
				$i = 7;
				$day++;
			}
			if($i == 7 && $day <= $daysinmonth){
				/* sunday */
				$fulldate = date("Y-m-d", mktime(0, 0, 0, $num, $day, $year));
	//			echo strtotime($SemStartDate) . " " . strtotime($fulldate) . " " . strtotime($SemEndDate);
				echo "<div class='calendar__day calendar__day_not_working";
				if(($isem < $nsem) && (strtotime($fulldate) >= strtotime($SemStartDate)) && (strtotime($fulldate) <= strtotime($SemEndDate))){
					$isSem = 1;
					echo " calendar__category_seminar_bk";
					if(strtotime($fulldate) < strtotime($today))
						echo "_past";
					echo "' alt='$SemDescription' style='cursor: pointer'>";
					$SemDescription = $ShortDescription;
					if(strtotime($fulldate) == strtotime($SemEndDate) && ($isem < $nsem-1)) {
						$isem++;
						$SemStartDate = $seminars[$isem]["startdate"];
						$SemEndDate = $seminars[$isem]["enddate"];
						$ShortDescription = $seminars[$isem]["shortdescription"];
						$SemId = $seminars[$isem]["id"];
					}
				} else
					echo "' style=''>";
				if($isSem == 1){
					echo "<a class='noborder' href='./_seminar.php?sid=$SemId'>$day</a>";
					echo "<div class='calendar__tooltip' onclick='location.href=&apos;./_seminar.php?sid=$SemId&apos;'><div class='calendar__tooltip__description'>" . $SemDescription . "</div></div>";
					$isSem = 0;
				} else
					echo "$day";

				echo "</div>";
				$i = 1;
			}
		}
		echo "</div><!-- end month -->";
	}


  }
