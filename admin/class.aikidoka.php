<?php

  class aikidoka {

  	var $id;
  	var $firstname;
  	var $lastname;
  	var $rank;
  	var $yudansha;
  	var $beginner;
  	var $youngster;
  	var $exams = array();
  	var $lastexam;
	var $enrolled;
	var $active;  	

	function get($dbconn, $aid){
		$query = "SELECT * from aikidoka where id=" . $aid . ";";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $numrows = mysql_num_rows($result); 
        if($numrows == 1){
	  		$row = mysql_fetch_assoc($result);
	  		$this->id = $row['id'];
	  		$this->firstname = $row['firstname'];
	  		$this->lastname = $row['lastname'];
	  		$this->rank = $row['rank'];
	  		$this->yudansha = $row['yudansha'];
	  		$this->beginner = $row['beginner'];
	  		$this->youngster = $row['beginner'];
	  		$this->lastexam = $row['last_exam'];
	  		$this->exams = $this->getExams($dbconn, $this->id);
	  		$this->enrolled = $row['enrolled'];
	  		$this->active = $row['active'];
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

		$query = "INSERT INTO aikidoka (lastname, firstname, rank, yudansha, youngster, beginner, last_exam, enrolled, active) ";
		$query = $query . " VALUES ('$this->lastname','$this->firstname','$this->rank','$this->yudansha', '$this->youngster',";
		$query = $query . " '$this->beginner', '$this->lastexam', '$this->enrolled', '$this->active');";
		//echo $query;
		$result = $dbconn->qry($query);
		$newID = mysql_insert_id(); 

		return $newID;
	}

	/* deletes an aikidoka */
	function del($dbconn){

		$query = "DELETE FROM aikidoka WHERE id = " . $this->id . ";";
		$result = $dbconn->qry($query);
		
		/* exams */
		$query = "DELETE FROM exams WHERE aikidokafk = " . $this->id . ";";
		$resultinst = $dbconn->qry($query);

		/* exams */
		$query = "DELETE FROM attendance WHERE aikidokafk = " . $this->id . ";";
		$resultinst = $dbconn->qry($query);

		return $result;

	}
	
	/* updates the information of an aikidoka */
	function update($dbconn){
		$strSQLE = "";
		$qexam = "SELECT * FROM exam where aikidoka_fk= " . $this->id . " AND rank = '" .  $this->rank . "';";
		$result = $dbconn->qry($qexam);
		$numrows = mysql_num_rows($result); 
		if ($numrows == 0){
			$strSQLE = "INSERT INTO exam(aikidoka_fk, date, rank) VALUES(" . $this->id . ",'" . $this->lastexam . "','" . $this->rank . "');";
		}
		$preExamSQL = "";
		$acurr = "SELECT last_exam, rank FROM aikidoka where id= " . $this->id . ";";
		$result = $dbconn->qry($acurr);
		$row =  mysql_fetch_assoc($result);
		$ldate = $row['last_exam'];
		$lrank = $row['rank'];
		$qexam = "SELECT * FROM exam where aikidoka_fk= " . $this->id . " AND rank = '" .  $lrank . "' AND date = '" . $ldate . "';";
		$result = $dbconn->qry($qexam);	
		$numrows = mysql_num_rows($result); 
		if ($numrows == 0){
			$preExamSQL = "INSERT INTO exam(aikidoka_fk, date, rank) VALUES(" . $this->id . ",'" . $ldate . "','" . $lrank . "');";
		}
		
		$query = "UPDATE aikidoka SET lastname='$this->lastname', firstname='$this->firstname', rank='$this->rank', yudansha='$this->yudansha', youngster='$this->youngster', beginner='$this->beginner', last_exam='$this->lastexam', enrolled='$this->enrolled', active='$this->active' WHERE id = " . $this->id;
		$result = $dbconn->qry($query);
		
		if($strSQLE != ""){
			$resultexam = $dbconn->qry($strSQLE);
		}
		if($preExamSQL != ""){
			$resultexam = $dbconn->qry($preExamSQL);
		}
		return $result;
	}

	/* updates the information of an aikidoka */
	function updateMonthHours($dbconn,$day,$hours){
		$query = "SELECT attendance.hours FROM attendance WHERE date = '" . $day . "' AND aikidoka_fk = " . $this->id;
		$result = $dbconn->qry($query);
		if(mysql_num_rows($result) == 0)
			$query = "INSERT INTO attendance (date,hours,aikidoka_fk) VALUES (\"" . $day . "\"," . $hours . "," . $this->id . ");";
		else 
			$query = "UPDATE attendance SET hours = " . $hours . " WHERE date = \"" . $day . "\" AND aikidoka_fk = " . $this->id . ";";
		$result = $dbconn->qry($query);			
		return $result;
	}

	/* adds a new aikidoka */
	function addExam($dbconn){

		$query = "INSERT INTO exams (aikidokafk, date, rank) ";
		$query = $query . " VALUES ('$this->aikidokafk','$this->date','$this->rank');";

		$result = $dbconn->qry($query);

		return $result;
	}


  	function rawlist($dbconn, $activeonly){
  		if($activeonly)			
			$query = "SELECT * FROM aikidoka where active = 1 ORDER BY lastname, firstname ASC;";
		else
			$query = "SELECT * FROM aikidoka ORDER BY lastname, firstname ASC;";
		
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
  		return $result;
  	}
  	
  	
  	function fullname($dbconn, $aid){
		$query = "SELECT firstname, lastname, concat(firstname, ' ', lastname) as fullname from aikidoka where id=" . $aid . ";";
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

  	function isBeginner($dbconn, $aid){
		$query = "SELECT beginner from aikidoka where id=" . $aid . ";";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
 		
    	$data = mysql_fetch_assoc($result);
    	// print_r($data);
    	return $data[beginner];
   		//return json_encode($data);     
  	}
  	
  	function getDateLastexam($dbconn, $aid){
		$query = "SELECT last_exam from aikidoka where id=" . $aid . ";";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $info = mysql_fetch_assoc($result);
  		return $info["last_exam"];
  	}

	function getExams($dbconn, $aid){
		$query = "SELECT * from exam where aikidoka_fk=" . $aid . ";";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
		$rownum = mysql_num_rows($result);
		if($rownum >= 1){	/* exams */
	        $data = array();
	        while($row = mysql_fetch_assoc($result))
    	        $data[] = $row;

        }
		return $data;
  	}

  	function getHoursMonthYear($dbconn, $aid, $month, $year){
		$query = "SELECT date, hours from attendance where aikidoka_fk=" . $aid . " AND MONTH(date) = $month AND YEAR(date) = $year ORDER BY date;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
     	$numrows = mysql_num_rows($result); 
    	$data = array();
    	for ($x = 0; $x < $numrows; $x++) {
        	$data[] = mysql_fetch_assoc($result);
    	}
    	return $data;
  	}

  	function getHoursYear($dbconn, $aid, $fromyear, $toyear){
		$query = "SELECT YEAR( date ) AS YY, MONTH( date ) AS MM, SUM( hours ) AS MH FROM attendance where aikidoka_fk=" . $aid;
		$query = $query . " AND date > '" . $fromyear . "/08/31' AND date <= '" . $toyear . "/08/31'";
		$query = $query . " GROUP BY YEAR( date ) , MONTH( date )";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $num = mysql_num_rows($result);
		for($i = 0; $i < $num; $i++) 
			$mhours[$i] = mysql_fetch_assoc($result);	

  		return $mhours;
  	}

  	function getHoursFromExam($dbconn, $aid){
  		$this->lastexam = $this->getDateLastexam($dbconn, $aid);
		$query = "SELECT YEAR( date ) AS YY, MONTH( date ) AS MM, SUM( hours ) AS MH FROM attendance where aikidoka_fk=" . $aid;
		$query = $query . " AND date > '$this->lastexam' ";
		$query = $query . " GROUP BY YEAR( date ) , MONTH( date )";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $num = mysql_num_rows($result);
		for($i = 0; $i < $num; $i++) 
			$mhours[$i] = mysql_fetch_assoc($result);	
        	
  		return $mhours;
  	}

	function getTotHoursMonthAll($dbconn,$lastdateofmonth){
		$query = "SELECT attendance.aikidoka_fk as id, sum(attendance.hours) as monthhrs FROM attendance WHERE month(date) = '" . date('m',$lastdateofmonth) . "' AND year(date) = ' " . date('Y',$lastdateofmonth) . "' GROUP BY attendance.aikidoka_fk ";
		$dbconn->dbconnect();
        $hours = $dbconn->qry($query);
        $num = mysql_num_rows($hours);
		for($i = 0; $i < $num; $i++) 
			$datahrs[$i] = mysql_fetch_assoc($hours);	
		return $datahrs;
	}

  	function getHoursDay($dbconn, $aid, $theday){
		$query = "SELECT attendance.aikidoka_fk as id, attendance.date, attendance.hours FROM attendance WHERE attendance.aikidoka_fk=" . $aid ." AND date = '" . $theday . "'";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $num = mysql_num_rows($result);
        if($num == 1){
        	$info = mysql_fetch_assoc($result);
        	$nhours = $info['hours'];
        } else
	  		$nhours = 0;
	  	return $nhours;
  	}

	function generateMonthKeikoHoursColor($num, $year, $hours){
		$firstdaymonth = $year . "-" . sprintf("%02d", $num) . "-01";
		$dayofweek = date('w', strtotime($firstdaymonth));
		$daysinmonth = cal_days_in_month(CAL_GREGORIAN, $num, $year);
		$today = date("Y-m-d");
		$thismonth = date("m");
		$ndays = count($hours);
		$nday = 0;
		$keikoday = $hours[0]['date'];
		$nhrs = $hours[0]['hours'];
		$tothours = 0;

		$util = new utils();

		echo "<div class='content'><h3>";
		echo $util->getMonthNameFromNumber($num);
		echo  "</h3></div>\n";
		$util = new utils();
		echo "<div class='content'>";
		echo "<div class='calendar_row calendar__weekdaynames'>\n<div class='calendar__day_not_in_month'>&nbsp;</div>\n";
		for($i = 0; $i < 7; $i++)
			echo "<div class='calendar__weekday'>" . $util->dowInItalian(($i+1) % 7) . "</div>\n";
		echo "</div><!-- row -->\n";
		$strhours = "";
		echo "<div class='calendar_row'>\n<div class='calendar__day_not_in_month'>&nbsp;</div>\n";
		for($i = 1, $j = ($dayofweek + 6) % 7; $j > 0; $j--, $i++){
			echo "<div class='calendar__day calendar__day_not_in_month'>NA </div>\n";
		}
		for($day = 1; $day <= $daysinmonth; $day++){
			if($i == 1)
				echo "\n<div class='calendar_row'>\n<div class='calendar__day_not_in_month'>&nbsp;</div>";
			while($i >= 1 && $i < 6 && $day <= $daysinmonth){
				$fulldate = date("Y-m-d", mktime(0, 0, 0, $num, $day, $year));
				echo "<div class='calendar__day calendar__day_working";
				if(strtotime($fulldate) == strtotime($today)) echo " today ";
				if(($nday < $ndays) && (strtotime($fulldate) == strtotime($keikoday))){
					echo " keiko_$nhrs' alt='$nhrs'>";
					$tothours = $tothours + $nhrs;
					if((strtotime($fulldate) == strtotime($keikoday)) && ($nday < $ndays-1)) {
						$nday++;
						$keikoday = $hours[$nday]["date"];
						$nhrs = $hours[$nday]["hours"];
					}
				} else {
					echo "' style=''>";
				}

				echo "$day";	
				echo "</div>\n";
				$i++;
				$day++;
			}
			if($i == 6 && $day <= $daysinmonth){
				/* saturday */
				$fulldate = date("Y-m-d", mktime(0, 0, 0, $num, $day, $year));
				echo "<div class='calendar__day calendar__day_not_working";
				if(strtotime($fulldate) == strtotime($today)) echo " today ";
				if(($nday < $ndays) && ($fulldate == $keikoday)){
					echo " keiko_$nhrs' alt='$nhrs'>";
					$tothours = $tothours + $nhrs;
					if((strtotime($fulldate) == strtotime($keikoday)) && ($nday < $ndays-1)) {
						$nday++;
						$keikoday = $hours[$nday]["date"];
						$nhrs = $hours[$nday]["hours"];
					}
				} else{
					echo "' style=''>";
				}

				echo "$day";
				echo "</div>\n";
				$i = 7;
				$day++;
			}
			if($i == 7 && $day <= $daysinmonth){
				/* sunday */
				$fulldate = date("Y-m-d", mktime(0, 0, 0, $num, $day, $year));
				echo "<div class='calendar__day calendar__day_not_working";
				if(strtotime($fulldate) == strtotime($today)) echo " today ";
				if(($nday < $ndays) && (strtotime($fulldate) == strtotime($keikoday))){
					echo " keiko_$nhrs' alt='$nhrs'>";
					$tothours = $tothours + $nhrs;
					if((strtotime($fulldate) == strtotime($keikoday)) && ($nday < $ndays-1)) {
						$nday++;
						$keikoday = $hours[$nday]["date"];
						$nhrs = $hours[$nday]["hours"];
					}
				} else {
					echo "' style=''>";
				}

				echo "$day";
				echo "</div>\n";
				echo "</div><!-- row -->\n";
				$i = 1;
			}

		}
		if ($i > 1){
			for(; $i <= 7; $i++)
				echo "<div class='calendar__day calendar__day_not_in_month'  style=''>NA </div>\n";
			echo "</div><!-- row -->\n";
		}
		echo "\n<div class='calendar_row'>\n<div class='calendar__year_label'>TOTALE:</div>\n";
		for($i = 0; $i < 7; $i++)
			echo "<div class='calendar__day calendar__day_not_in_month'>NA</div>\n";
		echo "<div class='calendar__month_tot'><strong>" . $tothours . "</strong></div></div>\n";	

		echo "</div><!-- end content -->";
	}

	function printKeikoHoursColorScale(){
		echo "<div class='content'>\n";
		echo "<div class='calendar_row'>\n";
		echo "<div class='calendar__day calendar__day_nobackground'>ore:</div>\n";
		for($i = 1; $i < 6; $i++){
			echo "<div class='calendar__day calendar__day_not_working keiko_$i'>$i</div>\n";
		}
		echo "<div class='calendar__day calendar__day_nobackground'>&nbsp;</div>";
		echo "</div>\n</div>";
	}

	function numActiveAikidoka($dbconn)
	{
		$query = "SELECT COUNT(*) FROM aikidoka WHERE active=1;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $row = mysql_fetch_array($result);
        return $row[0];
		
	}
	
	function numActiveYudansha($dbconn)
	{
		$query = "SELECT COUNT(*) FROM aikidoka WHERE yudansha = 1 AND active=1;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $row = mysql_fetch_array($result);
        return $row[0];
		
	}

	function numActiveYoungster($dbconn)
	{
		$query = "SELECT COUNT(*) FROM aikidoka WHERE youngster = 1 AND active=1;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $row = mysql_fetch_array($result);
        return $row[0];
		
	}

	function numActiveBeginner($dbconn)
	{
		$query = "SELECT COUNT(*) FROM aikidoka WHERE beginner = 1 AND active=1;";
		$dbconn->dbconnect();
        $result = $dbconn->qry($query);
        $row = mysql_fetch_array($result);
        return $row[0];
		
	}

  }
