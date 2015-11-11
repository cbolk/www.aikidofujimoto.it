<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
        <meta http-equiv="Content-Type" content="text/html" />
        <title>link</title>
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
            <div class="generic__title">Links</div>
			<div>
				<ul class='weblinks'>
					<li><a href='http://www.aikikai.it' target=_blank title='Aikikai Italia'>www.aikikai.it</a></li>
					<li><a href='http://www.aikikai.or.jp' target=_blank title='Aikikai Giappone'>www.aikikai.or.jp</a></li>
					<li><a href='http://www.aikidorenbukai.it' target=_blank title='Aikido Renbukai'>www.aikidorenbukai.it</a></li>
					<li><a href='http://www.fujinami.it/' target=_blank title='Aikido Fujinami Bologna'>www.fujinami.it</a></li>
				</ul>
				<h2>&nbsp;</h2>
				<ul class='weblinks'>
					<li>album foto su <a href='http://www.flickr.com/aikikaimilano/' target=_blank title='Flickr'>Flickr</a>&nbsp;<i class="fa fa-flickr"></i></li>
				</ul>
        <h2>&nbsp;</h2>
        <ul class='weblinks'>
          <li>seguici su <a href='http://www.facebook.com/aikikaimilano' target=_blank title='Facebook'><i class="fa fa-facebook-official"></i></a></li>
        </ul>


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
</html></script>
	</body>
</html>
