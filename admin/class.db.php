<?php
class dbaccess {
    //database setup
    //local
    var $hostname_logon = '127.0.0.1'; //Database server LOCATION
    var $database_logon = 'af';       //Database NAME
    var $username_logon = 'root';       //Database USERNAME
    var $password_logon = '';       //Database PASSWORD
    	
    //connect to database
    function dbconnect(){
        $this->dbconn = mysql_connect($this->hostname_logon, $this->username_logon, $this->password_logon, true) or die ('Unable to connect to the database');
        mysql_select_db($this->database_logon) or die ('Unable to select database!');
        return;
    }

    //prevent injection
    function qry($query) {
	  $this->dbconnect();
      $args  = func_get_args();
      $query = array_shift($args);
      $query = str_replace("?", "%s", $query);
      $args  = array_map('mysql_real_escape_string', $args);
      array_unshift($args,$query);
      $query = call_user_func_array('sprintf',$args);
      $result = mysql_query($query) or die(mysql_error());
      if($result){
        return $result;
      }else{
         $error = "Error";
         return $result;
      }
    }
 
	function date_to_db($strdate){
		if($strdate == '') return $strdate;
		if(strrpos($strdate,'-') >= 0)
			$dpart = split('-',$strdate);
		else if(strrpos($strdate,'/') >= 0)
			$dpart = split('/',$strdate);
		
		$strdatedb = $dpart[2] . '-' . $dpart[1] . '-' . $dpart[0];
		return $strdatedb;
	}
	
	function monthname($month){
		switch ($month) {
			case 1: return 'gennaio';
			case 2: return 'febbraio';
			case 3: return 'marzo';
			case 4: return 'aprile';
			case 5: return 'maggio';
			case 6: return 'giugno';
			case 7: return 'luglio';
			case 8: return 'agosto';
			case 9: return 'settembre';
			case 10: return 'ottobre';
			case 11: return 'novembre';
			case 12: return 'dicembre';
			default: return 'errore - mese sconosciuto ' . $month;
		}
/*		return date('F', mktime(0,0,0,$month,1)); */
	}

	function db_to_date($strdate){
		if($strdate == '') return $strdate;
		if(strrpos($strdate,'-') >= 0)
			$dpart = split('-',$strdate);
		else if(strrpos($strdate,'/') >= 0)
			$dpart = split('/',$strdate);
		
		$strdatedb = $dpart[2] . '-' . $dpart[1] . '-' . $dpart[0];
		return $strdatedb;
	}

	function onoff_to_db($val){
		if($val == '' || $val === null) return 0;
		if($val == 'on' || $val == 'true') return 1; else return 0;
	}

	function db_to_onoff($val){
		if($val == 1 || $val == '1' || $val == true) return 'checked';
		return '';
	}

    function close() {
	  mysql_close();
    }

	
}
?>