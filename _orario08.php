<?php
	date_default_timezone_set('Europe/Rome');
	setlocale(LC_TIME, 'it_IT');
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	include("./adm/class.classinstructor.php");
	include("./adm/class.traininghour.php");

    $db = new dbaccess();
    $ci = new classinstructor();
    $jsonci = $ci->get($db);
	$instr = json_decode($jsonci, TRUE);

    $th = new traininghour();
    $jsonth = $th->getOrderByHourByMonth($db,8);
    $classes = json_decode($jsonth, TRUE);

	$util = new utils();

?>
  <head lang="it">
        <meta http-equiv="Content-Type" content="text/html" />
        <title>orario agosto</title>
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
    	    	<div class="schedule__title"><span class="nomobile">Orario&nbsp;&nbsp;&nbsp;</span>agosto</div>
              <div class="schedule">
                <table class="timetable">
                  <tr><th class='timeh'>ORA</th>
                    <th class='dayh'><span class='nomobile'>Luned&igrave;</span><span class='mobile'>Lu</span></th>
                    <th class='dayh'><span class='nomobile'>Marted&igrave;</span><span class='mobile'>Ma</span></th>
                    <th class='dayh'><span class='nomobile'>Mercoled&igrave;</span><span class='mobile'>Me</span></th>
                    <th class='dayh'><span class='nomobile'>Gioved&igrave;</span><span class='mobile'>Gi</span></th>
                    <th class='dayh'><span class='nomobile'>Venerd&igrave;</span><span class='mobile'>Ve</span></th>
                    <th class='dayh'><span class='nomobile'>Sabato</span><span class='mobile'>Sa</span></th>
                    <th class='nomobile'>ORA</th></tr>
                    <tbody>
                    <?php
                    	/* var_dump($classes); */
                    	$tags = array();
						$iter = 0; /* iterator for training hours*/
						for($hrs = 7; $hrs < 21; $hrs = $hrs+1){
                            $row = "<tr>";
                            $hourbox = "<td class='time'>";
                            if($hrs <= 9) $hourbox = $hourbox .  "0";
                            $hourbox = $hourbox .  $hrs . ":00<br/>|<br/>";
                            if($hrs <= 8) 
                            	$hourbox = $hourbox .  "0";
                            $hre = $hrs+1;
                            $hourbox = $hourbox .  $hre . ":00";
                            $hourbox = $hourbox .  "</td>";
                            $row = $row . $hourbox;
                            $rowempty = true;
							for($wid = 1; $wid < 7; $wid=$wid+1){
								if((substr($classes[$iter]['starttime'],0,2) == $hrs) && ($classes[$iter]['weekday'] == $wid)){
									$row = $row . "<td class='instructor " . $classes[$iter]['tag'] . "'><span class='nomobile'>" . strtoupper($classes[$iter]['tag']) . "</span>";
									if(substr($classes[$iter]['starttime'],3,2) != "00"){
										$row = $row .  " <span class='nomobile'>(" . substr($classes[$iter]['starttime'],0,5) . "-" . substr($classes[$iter]['endtime'],0,5) . ")</span>";
										$row = $row .  " <span class='mobile'>" . substr($classes[$iter]['starttime'],0,5) . "<br/>|<br/>" . substr($classes[$iter]['endtime'],0,5) . "</span>";
									}
									$row = $row .   "</td>";
									$iter++;
									$rowempty = false;
			                    	if($classes[$iter]['tag']!= '' && !$util->existsInArray($tags,$classes[$iter]['tag']))
				                    	array_push($tags, $classes[$iter]['tag']);
								} else {
									$row = $row . "<td class='hour empty'>&nbsp;</td>";
								} 
                            }
                            //only on full size
                            $row = $row . str_replace("time","time nomobile",$hourbox);
                            $row = $row .  "</tr>";
                            if(!$rowempty) 
                            	echo $row;
                          }
                      ?>
                      </tbody>
              </table>
              <div class='legenda mobile'><p>Legenda</p>
              <?php
                	$n = count($tags);
                	$strtag = "";
                	for($iter = 0; $iter < $n; $iter++)
                		$strtag = $strtag . "<div class='tagbox ".$tags[$iter] . "'>".$tags[$iter] . "</div>";
                	echo $strtag;
		      ?>
		      </div>
              </div>
			    </div><!-- schedule-page -->
				<div class='note calnote'>Per eventuali variazioni occasionali, consultare le <a href="./_news.php">news</a></div>
              	<?php include('./_closed.php'); ?>
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
