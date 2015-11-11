<?php
	setlocale(LC_TIME, 'ita');
	date_default_timezone_set('Europe/Rome');

	class utils {

		function dowInItalian($dow){
			$dowMap = array('dom', 'lun', 'mar', 'mer', 'gio', 'ven', 'sab');
			return $dowMap[$dow];
		}

		function getHolidays($db, $day){
			$query = "SELECT * FROM trainingholidays WHERE date > " . $day . " ORDER BY fromday;";
	   		$db->dbconnect();
		    if($result = $db->qry($query)){
		        $db->close(); 
		    	return 0;
		    }
	        die('impossibile accedere alle informazioni');
    	}

    	function getSchedule($day){
		  	$month = date('m', strtotime($day));
	   			if($month == 7 || $month == 8 || $month == 9)
	   				return "0" . $month;
	   			return "10";
    	}

		function getStartAcademicYear($date){
			if(date('m', strtotime($date)) >= 9)
				$year = date('Y', strtotime($date));
			else
				$year = date('Y', strtotime($date)) - 1;
			return $year;

		}

		function getEndAcademicYear($date){
			if(date('m', strtotime($date)) >= 9)
				$year = date('Y', strtotime($date)) + 1;
			else
				$year = date('Y', strtotime($date));
			return $year;

		}

		function longDate($day){
			setlocale(LC_TIME, 'ita');
			date_default_timezone_set('Europe/Rome');
			$ld = $this->dowInItalian(date('w', strtotime($day)));
			$ld = $ld . " " . ltrim(date('d', strtotime($day)), '0') . " " . $this->getMonthNameFromNumber(date('m', strtotime($day))) . ", " . date('Y', strtotime($day));
			return $ld;
		}
	
		function medDate($day){
			$ld = $this->dowInItalian(date('w', strtotime($day)));
			$ld = $ld . " " . ltrim(date('d', strtotime($day)), '0') . " " . $this->getMonthMedNameFromNumber(date('m', strtotime($day))) . ", " . date('Y', strtotime($day));
			return $ld;
		}

		function shortDate($day){
			$ld = $this->dowInItalian(date('w', strtotime($day)));
			$ld = $ld . " " . ltrim(date('d', strtotime($day)), '0') . " " . $this->getMonthMedNameFromNumber(date('m', strtotime($day))) . " " . date('Y', strtotime($day));
			return $ld;
		}


		function getMonthNameFromNumber($month)
		{
				$trans = array (
				    'January'   => 'gennaio',
				    'February'  => 'febbraio',
				    'March'     => 'marzo',
				    'April'     => 'aprile',
				    'May'       => 'maggio',
				    'June'      => 'giugno',
				    'July'      => 'luglio',
				    'August'    => 'agosto',
				    'September' => 'settembre',
				    'October'   => 'ottobre',
				    'November'  => 'novembre',
				    'December'  => 'dicembre',
				);
				return strtr(date('F', mktime(0,0,0,$month,1)),$trans);
		}
		
		function getMonthMedNameFromNumber($month)
		{
				return substr($this->getMonthNameFromNumber($month),0,3) . ".";
		}


		function date2monthday($date){
			$out = "<span class='month'>". $this->getMonthMedNameFromNumber(date('m', strtotime($date)));
			$out = $out ."</span><br/><span class='day'>" . date('d', strtotime($date)) . "</span>";
			return $out;
		}

		/* returns the number of the month-schedule */
		function getThisMonthSchedule(){
			$today = strtotime(Date('Y-m-d'));
			$thimonth = date('m', $today);
			if($thimonth >= 7 && $thimonth <= 9)	/* september */
				$sched = $thimonth;
			else
				$sched = "10";
			return $sched;
		}

		/* returns the data of the next seminar to be held*/
		function getNextStageMMDD($dbconn)
		{
			$query = "SELECT startdate FROM seminar WHERE startdate >= DATE(NOW()) order by startdate asc LIMIT 1;";
			$dbconn->dbconnect();
			$result = $dbconn->qry($query);
			$rownum = mysql_num_rows($result);
	        while($row = mysql_fetch_assoc($result)){
	        	$shortdate = str_replace("-", "", $row['startdate']);
	   	        $mmdd = sprintf($shortdate,4,4);
				return $mmdd;
	        }
	        return null;
		}
		
		function existsInArray($arr, $value)
		{
			$n = count($arr);
			for($i = 0; $i < $n; $i++)
				if($arr[$i] == $value)
					return 1;
			return 0;
		}
	}
?>