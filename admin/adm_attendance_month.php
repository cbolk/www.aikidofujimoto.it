<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="it">
  <head>
<?php  
	setlocale(LC_TIME, 'it_IT');
	date_default_timezone_set('Europe/Rome');
	include("./class.login.php");
	include("./class.db.php");
	include("./class.aikidoka.php");
	include("./class.utilities.php");
	$db = new dbaccess();

	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	

	if (!isset($_GET) || empty($_GET)) {
		$theday = date('Y-m-d');
	} else {
		$time = strtotime($_GET["day"]);
		$theday = date('Y-m-d', $time);
	}
	$currday = strtotime($theday);
	$curmonth = date('m', $currday);
	$lastdaymonth = date('t',$currday);
	$lastdateofmonth = mktime(23, 59, 59, $curmonth, $lastdaymonth, date('Y', $currday));
	$lastdaynextmonth = date('t',strtotime(date('Y-m-d', $lastdateofmonth+1)));
	$firstdatethismonth = mktime(0, 0, 0, $curmonth, 1, date('Y', $currday));
	$lastdayprevmonth = date('t',strtotime(date('Y-m-d', $firstdatethismonth-1)));
	$nextmonth = date('Y-m-t', mktime(0, 0, 0, $curmonth+1, $lastdaynextmonth, date('Y', $currday)));
	if($curmonth == 1)
		$prevmonth = date('Y-m-t', mktime(0, 0, 0, 12, $lastdayprevmonth, date('Y', $currday)-1));
	else
		$prevmonth = date('Y-m-t', mktime(0, 0, 0, $curmonth-1, $lastdayprevmonth, date('Y', $currday)));

?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="admin website">
    <meta name="author" content="cbolk">
    <link rel="icon" href="../assets/favicon.png">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,400italic,700,300,300italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oxygen+Mono' rel='stylesheet' type='text/css'>
	<title>presenze mensili</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.20.custom.css">
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
    <link href="../css/dashboardAF.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type='text/javascript' src='//code.jquery.com/jquery-2.1.1.min.js'></script>
    <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.20.custom.min.js" ></script>   
	<script type="text/javascript" src="../js/presenze.js"></script>
	<script>
		$(function(){
			//acknowledgement message
			var message_status = $("#status");
			$("td[contenteditable=true]").blur(function(){
				var field_userid = $(this).attr("id") ;
				var value = $(this).text();
				$.ajax({
					type: 'post',
					url: 'adm_attendance_month_update.php',
					data: field_userid + "=" + value,
					beforeSend: function() {
			            //alert("aggiorno");
			          },
					success: function(response) {
						//alert(response);
					}
				});
			});	
		});
	</script>
</head>
<body>
<?php
	if($isLogged == false) { 
		header("Location: adm_index.php");
		exit;
	} 
?>
   <?php include('./_nav_top.htm'); ?>

    <div class="container-fluid">
      <div class="row">
        <?php include('./_nav_main.php'); ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php
  $aiki = new aikidoka();
  $people = $aiki->rawlist($db,true);
  $datahrs = $aiki->getTotHoursMonthAll($db,$lastdateofmonth);
?>
          <h1 class="page-header">Presenze del mese di <?php echo $db->monthname($curmonth) . " " . date('Y', $lastdateofmonth); ?>          
          </h1>

          <div class="row">
          	<div class="pull-left"><a class="back" href="adm_attendance_month.php?day=<?php echo $prevmonth; ?>"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> <?php if($curmonth == 1) echo $db->monthname(12); else echo $db->monthname($curmonth - 1); ?></a></div>
          	<div class="pull-right"><a class="forth" href="adm_attendance_month.php?day=<?php echo $nextmonth; ?>"><?php echo $db->monthname(($curmonth + 1) % 12); ?> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></div>
         </div>
          <div class="table-responsive">
			<table class="table table-striped" id="ajaxtable">
				<thead>
				  <tr>
						<th>nominativo</th>
						<th class='cntr'>P</th>
						<th class='cntr'>ore</th>
						<th class='cntr'>iscritto</th>
						<th class='cntr'>anno</th>
						<th class='cntr'>da esame</th>
				  </tr>
				</thead>
				<tbody>
				  <?php
				while($row = mysql_fetch_array($people)) {
					echo "<tr>";
					echo "<td>" . $row['lastname'] . " " . $row['firstname'] . "</td>";
					echo "<td  class='tableicon cntr'>";
					if($row['beginner'] == 1) echo "<i class='fa fa-check-square-o fa-fw'></i>";
					echo "</td>";
					$nh = 0;
					$i = count($datahrs);
					for($j = 0; $j < $i; $j++)
						if($datahrs[$j]['id'] === $row['id']){
							$nh = $datahrs[$j]['monthhrs'];
							break;
						} 
					echo "<td class='tableicon cntr' id=" . $row['id'] . ":" . date('Y-m-d', $lastdateofmonth) . " contenteditable='true' class='icon'>" . $nh . "</td>";
					if(intval($curmonth) < 9)
						$y = intval(date('Y', $lastdateofmonth)) - 1;
					else
						$y = date('Y', $lastdateofmonth);
					echo "<td class='tableicon cntr'><a href='./adm_aikidoka_view.php?aid=" . $row['id'] . "'><i class='fa fa-user fa-fw'></i></a></td>";
//					echo "<td class='tableicon cntr'><a href='./usr_attendance_monthly.php?aid=" . $row['id'] . "&day=" . date('Y-m-t',$currday) . "'><i class='fa fa-calendar fa-fw'></i></a></td>";
					echo "<td class='tableicon cntr'><a href='./adm_attendance_yearly.php?aid=" . $row['id'] . "&y=" . $y . "'><i class='fa fa-area-chart fa-fw'></i></a></td>";
					echo "<td class='tableicon cntr'><a href='./adm_attendance_yearly.php?aid=" . $row['id'] . "'><i class='fa fa-bar-chart fa-fw'></i></a></td>";
					echo "</tr>";
				}
				  ?>
				</tbody>
			</table>		

          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="./js/jquery-1.7.2.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-checkbox.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/fileinput.js"></script>
  </body>
</html>
