<?php
	setlocale(LC_TIME, 'ita');
	date_default_timezone_set('Europe/Rome');
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	include("./adm/class.seminar.php");

	$db = new dbaccess();
	$db->dbconnect();
	$seminar = new seminar();
	$util = new utils();

	$updateON = $seminar->lastUpdate($db);

	$today = Date('Y-m-d');
	$year = $util->getStartAcademicYear($today);
	$thisMonth = Date('m');

	$semMMDD = $util->getNextStageMMDD($db);

?>
<!DOCTYPE html>
<head lang="it">
	    <meta http-equiv="Content-Type" content="text/html" />
        <title>calendario seminari</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon-precomposed" href="assets/favicon_t.png" />
        <link rel="shortcut icon" href="assets/favicon.png">
		<link rel="stylesheet" media="screen" href="css/main.css" /> <!--Load CSS-->
	    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	    <link rel="stylesheet" href="css/slicknav.css" />
		<script src="js/jquery.slicknav.cb.js"></script>
		<script src="js/jquery.slicknav.menu.js"></script>
	</head>
<body>
	<div class="site_wrapper">
      	<?php include('./_head_banner.php'); ?>
     	<div class="sidebar">
	    	<?php include('./_menu.php'); ?>
		</div><!-- sidebar -->
		<div class="site_container">
	        <div class="seminar-list seminars-page">
    	    	<div class="seminar-list__title">Calendario<span class="nomobile"> </span><span class="mobile"><br/></span><?php echo "$year-" . ($year+1); ?></div>
				<!--div class="seminar-list__description"><p><span class="calendar__category_seminar_bk_past">&nbsp;&nbsp;&nbsp;&nbsp;</span> seminari passati&nbsp;&nbsp;<span class="calendar__category_seminar_bk">&nbsp;&nbsp;&nbsp;&nbsp;</span> seminari futuri.</p></div-->
        	    <div class="calendar">
					<?php
						for($i = 9; $i <= 12; $i++){
							$sem = $seminar->getStagesMonthYear($db,$i,$year);
							if(count($sem) > 0)
								$seminar->generateListMonthSeminars($db,$i, $year, $sem, $semMMDD);
						}
						$year++;
						for($i = 1; $i < 9; $i++){
							$sem = $seminar->getStagesMonthYear($db,$i,$year);		
							if(count($sem) > 0)
								$seminar->generateListMonthSeminars($db,$i, $year, $sem, $semMMDD);
						}
					?>
				</div><!-- calendar -->
			</div><!-- seminar-list -->
			<div class='note calnote'>Pagina soggetta a variazioni. Ultimo aggiornamento: <span class="black"><?php echo  $updateON; ?></span></div>
  		</div> <!--  site_container -->
  	</div> <!--  site_wrapper -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26921777-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>