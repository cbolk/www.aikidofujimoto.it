<?php
	date_default_timezone_set('Europe/Rome');
	setlocale(LC_TIME, 'it_IT');
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	include("./adm/class.classinstructor.php");
	include("./adm/class.traininghour.php");

	if (!empty($_GET)){
		if(isset($_GET["day"]))
			$day = $_GET["day"];
		else
			$day = Date('Y-m-d');
		if(isset($_GET["n"]))
			$wname = true;
		else
			$wname = false;
	} else {
		$day = Date('Y-m-d');
		$wname = false;
	}

    $db = new dbaccess();
    $ci = new classinstructor();
    $jsonci = $ci->get($db);
	$instructors = json_decode($jsonci, TRUE);

	$prevday = date('Y-m-d', strtotime('-1 day', strtotime($day)));
	$nextday = date('Y-m-d', strtotime('+1 day', strtotime($day)));
  	$month = date('m', strtotime($day));


    $th = new traininghour();
    $jsonth = $th->getDay($db,$day);
    $classes = json_decode($jsonth, TRUE);
    
    $util = new utils();

?>
<head lang="it">
    <meta http-equiv="Content-Type" content="text/html" />
    <title>orario</title>
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
	        <div class="schedule-page">
    	    	<div class="schedule__title"><span class="nomobile"><span class="fleft"><a href="./_day.php?day=<?php echo $prevday; ?>"><i class="fa fa-angle-double-left"></i></a></span><?php echo $util->longDate($day); ?><span class="fright"><a href="./_day.php?day=<?php echo $nextday; ?>"><i class="fa fa-angle-double-right"></i></a></span></span>
    	    	<span class="mobile"><span class="fleft"><a href="./_day.php?day=<?php echo $prevday; ?><?php if($wname) echo "&n"; ?>"><i class="fa fa-angle-double-left"></i></a></span><?php echo $util->shortDate($day); ?><span class="fright"><a href="./_day.php?day=<?php echo $nextday; ?><?php if($wname) echo "&n"; ?>"><i class="fa fa-angle-double-right"></i></a></span></span></div>
	              <div class="schedule">
                    <?php
                    	$tags = array();

                    	$nclasses = count($classes);
                    	if($nclasses > 0){
	                    	for($iter = 0; $iter < $nclasses-1; $iter++){
	                    	  	echo "<div class='traininghour'>";
	                    	  	echo "<div class='time " . $classes[$iter]['tag'] . "'>" . substr($classes[$iter]['starttime'],0,5) . "<br/>|<br/>" . substr($classes[$iter]['endtime'],0,5) . "</div>";
	                    	  	
	                    	  	echo "<div class='instructor " . $classes[$iter]['tag'] . "'><br/>";
	                    	  	if($wname){
		                    	  	$in = $ci->findInstructor($instructors,$classes[$iter]['leaderid']);
		                    	  	$in2 = null;
		                    	  	if($classes[$iter]['leaderid_alt'] != '')
	    	                	  		$in2 = $ci->findInstructor($instructors,$classes[$iter]['leaderid_alt']);
	                    	  		echo $in['lastname'];
		                    	  	if($in2 != null)
		                    	  		echo " | " . $in2['lastname'];
	                    	  	} else 
	                    	  		echo strtoupper($classes[$iter]['tag']);
	                    	  	echo "<br/>&nbsp;</div>";
	                    	  	echo "</div>";
	                    	  	if($classes[$iter]['endtime'] != $classes[$iter+1]['starttime'])
	                    	  		echo "<div class='class__spacer'>&nbsp;</div>";
	                    	  	if($classes[$iter]['tag'] != "allenamento libero")
		                    	  	if(!$util->existsInArray($tags,$classes[$iter]['tag']))
			                    	  	array_push($tags, $classes[$iter]['tag']);
	                    	}
                    	  	echo "<div class='traininghour'>";
                    	  	echo "<div class='time " . $classes[$iter]['tag'] . "'>" . substr($classes[$iter]['starttime'],0,5) . "<br/>|<br/>" . substr($classes[$iter]['endtime'],0,5) . "</div>";
                    	  	
                    	  	echo "<div class='instructor " . $classes[$iter]['tag'] . "'><br/>";
	                    	  	if($wname){
		                    	  	$in = $ci->findInstructor($instructors,$classes[$iter]['leaderid']);
		                    	  	$in2 = null;
		                    	  	if($classes[$iter]['leaderid_alt'] != '')
	    	                	  		$in2 = $ci->findInstructor($instructors,$classes[$iter]['leaderid_alt']);
	                    	  		echo $in['lastname'];
		                    	  	if($in2 != null)
		                    	  		echo " | " . $in2['lastname'];
	                    	  	} else 
	                    	  		echo strtoupper($classes[$iter]['tag']);
                    	  	echo "<br/>&nbsp;</div>";
                    	  	echo "</div>";
                    	  	if($classes[$iter]['tag'] != "allenamento libero")
	                    	  	if(!$util->existsInArray($tags,$classes[$iter]['tag']))
		                    	  	array_push($tags, $classes[$iter]['tag']);

		                   	if($wname){
		                    	echo "<div class='legenda'><p>Legenda</p>";
		                    	$n = count($tags);
		                    	$strtag = "";
		                    	for($iter = 0; $iter < $n; $iter++)
		                    		$strtag = $strtag . "<div class='tagbox ".$tags[$iter] . "'>".$tags[$iter] . "</div>";

		                    	echo $strtag ."</div>";
	                    	}
	                    } else 
                    		echo "<span class='noclasses'>Nessuna lezione</span>";
                    ?>
    	          </div>
			    </div><!-- schedule-page -->
			<div class='note calnote'>Quella indicata &egrave; la pianificazione abituale,<span class="mobile"><br/></span><span class="nomobile"> </span>per eventuali variazioni consultare le ultime <a href="./_news.php">notizie</a>.</div>
			<div class='note calnote'><span class="mobile"><br/></span></div>
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
