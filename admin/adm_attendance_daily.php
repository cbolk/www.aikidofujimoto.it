<?php 
	setlocale(LC_TIME, 'ita');
	date_default_timezone_set('Europe/Rome');
	include("./class.db.php");
	include("./class.login.php");
	include("./class.utilities.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	
	
	if(isset($_GET["aid"]))
		$aid = $_GET["aid"];
	else
		$aid = -1;
	if(isset($_GET["day"]))	
	{
		$time = strtotime($_GET["day"]);
		$theday = date('Y-m-d', $time);		
	} else {
		$theday = date('Y-m-d');
		$time = strtotime($theday);
		$theday = date('Y-m-d', $time);	
	}

	$today = date('Y-m-d');
	$month = date('m');
	if($month < 9){
		$year = date('Y') - 1;
	}else{
		$year = date('Y');
	}
	
	$util = new utils();
	$currday = strtotime($theday);
	$smartdate = $util->MedDate($theday);
	$nextday = date('Y-m-d', $currday + 86400);
	$prevday = date('Y-m-d', $currday - 86400);
?>
<!DOCTYPE html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <link rel="apple-touch-icon-precomposed" href="../assets/favicon_t.png" />
  		<link rel="shortcut icon" href="../assets/favicon.png">
 	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>keiko</title>
		<link rel="stylesheet" href="../css/stats.css" /> 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />  
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script>
		function updateUser(hours,theday,id) {
		  if (window.XMLHttpRequest) {
		    // code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp=new XMLHttpRequest();
		  } else {  // code for IE6, IE5
		    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
		    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		      document.getElementById("PeopleList").innerHTML=xmlhttp.responseText;
		    }
		  }
		  //alert("./giorno_upd.php?id="+id+"&day="+theday+"&init="+init+"&hrs="+hours);
		  xmlhttp.open("GET","./attendance_daily_upd.php?id="+id+"&day="+theday+"&hrs="+hours,true);
		  xmlhttp.send();
		}
		</script>
</head>
<body>
<?php
	if($isLogged == false) { 
		header("Location: adm_index.php");
		exit;
	} 
?>
<div id="wrapper">
  <div class="top-bar">
    <div>
    <?php 
		$sql="SELECT aikidoka.id, aikidoka.lastname, aikidoka.firstname from aikidoka WHERE id=" . $aid .";";
		$dbconn = new dbaccess();
		$dbconn->dbconnect();
		$people = $dbconn->qry($sql);
		if(count($people) == 1){
			$row = mysql_fetch_array($people);
			echo "<h2>" . $row['firstname'] . " " . $row['lastname'] . "</h2>";
		}
    ?>
    </div>
  </div>
  <div style="clear: both;"></div>

  <div class="content">
	<h3><?php echo $smartdate; ?></h3>
  </div>
  <!-- This space is for the app's content -->
  <div class="content">
  	<div class="nav-left">
  		<a class="back" href="adm_attendance_daily.php?aid=<?php echo $aid; ?>&day=<?php echo $prevday; ?>">&#9001;</a>
  	</div>
  	<div class="box">
	  	<form>
				<?php
					$sqlh = "SELECT attendance.aikidoka_fk as id, attendance.date, attendance.hours FROM attendance WHERE attendance.aikidoka_fk=" . $aid ." AND date = '" . $theday . "'";
					$hours = $dbconn->qry($sqlh);
					if(mysql_num_rows($hours) == 1){
						$row = mysql_fetch_assoc($hours); 
						$nh = $row['hours'];
					} else
						$nh = 0;
					echo "<div class='row'><input type='radio' name='radioO' id='" . $aid . "_0' class='radioO' value='0' ";
					if($nh===0 || $nh==='0') echo "checked";
					echo " onclick='updateUser(this.value,\"" . $theday . "\"," . $aid . ")'/><span></span><label for='radio0'>0</label></div>\n";
					echo "<div class='row'><input type='radio' name='radioO' id='" . $aid . "_1' class='radioO' value='1' ";
					if($nh==='1') echo "checked";
					echo " onclick='updateUser(this.value,\"" . $theday . "\"," . $aid . ")'/><span></span><label for='radio1' class='keiko_1'>1</label></div>\n";
					echo "<div class='row'><input type='radio' name='radioO' value='2' id='" . $aid . "_2' class='radioO'"; 
					if($nh==='2') echo "checked";
					echo " onclick='updateUser(this.value,\"" . $theday . "\"," . $aid . ")'/><span></span><label for='radio2' class='keiko_2'>2</label></div>\n";
					echo "<div class='row'><input type='radio' name='radioO' value='3' id='" . $aid . "_3' class='radioO'";
					if($nh==='3') echo "checked";
					echo " onclick='updateUser(this.value,\"" . $theday . "\"," . $aid . ")'/><span></span><label for='radio3' class='keiko_3'>3</label></div>\n";
					echo "<div class='row'><input type='radio' name='radioO' value='4' id='" . $aid . "_4' class='radioO'";
					if($nh==='4') echo "checked";
					echo " onclick='updateUser(this.value,\"" . $theday . "\"," . $aid . ")'/><span></span><label for='radio4' class='keiko_4'>4</label></div>\n";
					echo "<div class='row'><input type='radio' name='radioO' value='5' id='" . $aid . "_5' class='radioO'";
					if($nh==='5') echo "checked";
					echo " onclick='updateUser(this.value,\"" . $theday . "\"," . $aid . ")'/><span></span><label for='radio5' class='keiko_5'>5</label></div>\n";
					echo "";
				?>
	  	</form>
	</div>
  	<div class="nav-right">
		<a class="forth" href="adm_attendance_daily.php?aid=<?php echo $aid; ?>&day=<?php echo $nextday; ?>">&#9002;</a>  		
  	</div>		
  </div>

  <div class="nav">
		<a class="nav-button" href="adm_attendance_daily.php?aid=<?php echo $aid; ?>&day=<?php echo $theday; ?>"><i class="fa fa-flag fa-fw"></i><br/>oggi</a>
		<a class="nav-button" href="adm_attendance_monthly.php?aid=<?php echo $aid; ?>"><i class="fa fa-calendar fa-fw"></i><br/>mese</a>
		<a class="nav-button" href="adm_attendance_yearly.php?aid=<?php echo $aid; ?>&y=<?php echo $year; ?>"><i class="fa fa-area-chart fa-fw"></i><br/>anno</a>
		<a class="nav-button" href="adm_attendance_yearly.php?aid=<?php echo $aid; ?>"><i class="fa fa-bar-chart fa-fw"></i><br/>da esame</a>
  </div>
</div>
</body>
</html>