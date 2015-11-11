<?php
	include("./admin/class.db.php");
	include("./admin/class.news.php");
	include("./adm/class.utilities.php");
	$db = new dbaccess();
	$db->dbconnect();
	$allnews = new news();
	$newslist = $allnews->rawlist($db, true);
?>
<head lang="it">
        <meta http-equiv="Content-Type" content="text/html" />
        <title>notizie</title>
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
    <div class="generic-page">
            <div class="generic__title">News</div>
						<div class='w70 fleft'>
							<?php
				    		while ($row = mysql_fetch_array($newslist)){
				    			?>
				    				<div class='piecenews'>
				    				<p class="testosx"><span class='newsdate'><i class="fa fa-calendar"></i> <?php echo substr($row["date"],8,2) . ' ' . $db->monthname(substr($row["date"],5,2)) . ' '. substr($row["date"],0,4); ?></span><br/>
				    				<strong><?php echo $row["title"];?></strong><br/>
				    				<?php echo $row["description"];?></p>
				    				</div>
				    			<?php
				    		}
				    	?>
				    	<p class='mobile'>&nbsp;</p>
						</div>
						<div class='fright nomobile'>
		 					<p class='acenter'><img src="./images/fotonews.jpg" /></p>
		 					<p>&nbsp;</p>
						</div>

					</div><!-- generic-page -->
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
