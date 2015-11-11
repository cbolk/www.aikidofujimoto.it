<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
  	<meta http-equiv="Content-Type" content="text/html" />
	<title>il dojo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon-precomposed" href="assets/favicon_t.png" />
	<link rel="shortcut icon" href="assets/favicon.png">
	<link rel="stylesheet" media="screen" href="css/main.css" /> <!--Load CSS-->
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
  	<link rel="stylesheet" href="css/slicknav.css" />
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
    		<div class="generic__title">Il D&#333;j&#333;</div>
        <div class="acenter">
          <img src="./images/dojo-3.jpg" width="440px" alt="il dojo" />&nbsp;<span class='mobile'><br/></span>  
          <img src="./images/dojo-1.jpg" width="440px" alt="il dojo" />
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
