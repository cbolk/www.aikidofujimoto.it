<?php
	setlocale(LC_TIME, 'ita');
	date_default_timezone_set('Europe/Rome');
	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
	$util = new utils();
	$currentSchedule = $util->getThisMonthSchedule();
?>
<html>
  <head lang="it">
		<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>AIKIKAI MILANO - DOJO FUJIMOTO</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon-precomposed" href="assets/favicon_t.png" />
        <link rel="shortcut icon" href="assets/favicon.png">
		<link rel="stylesheet" media="screen" href="css/main.css" /> <!--Load CSS-->
		<link rel="stylesheet" href="css/slicknav.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
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
			<div class="main__img">
				<img class="nomobile" src="./images/main.jpg" alt='' width='690px'/>			
				<img class="mobile" src="./images/main.jpg" alt='' width='320px'/>			
			</div>
		</div><!-- site_container -->
	</div><!-- site_wrapper -->
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