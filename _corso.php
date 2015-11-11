<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
        <meta http-equiv="Content-Type" content="text/html" />
        <title>i corsi</title>
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
    	    	<div class="generic__title">I corsi</div>
				<p>Presso il D&#333;j&#333; Fujimoto &egrave; possibile frequentare corsi di Aikido a diversi
					livelli, in base alla propria preparazione e all'et&agrave;.<br/>
					I corsi offerti sono:
					<ul class="lessspace">
						<li>corsi per bambini e ragazzi, di et&agrave; inferiore ai 14 anni: 
							<a href="./_corsoragazzi.php">maggiori informazioni</a> e <a href='./_orario10.php'>orario</a> (da ottobre a giugno)</li>
						<li>corso per principianti, dedicato a coloro che non hanno mai praticato Aikido 
							(di et&agrave; superiore ai 14 anni): 
							<a href="./_corsoprincipianti.php">maggiori informazioni</a> e <a href='./_orario10.php'>orario</a> (da ottobre a giugno)</li>
						<li>corso per adulti, aperto a tutti coloro che praticano abitualmente o hanno praticato
							in passato Aikido: 
							<a href="./_corsoadulti.php">maggiori informazioni</a> e <a href='./<?php echo $currentSchedule; ?>.php'>orario</a></li>
					</ul>
					</p>
			</div><!-- generic-page -->
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