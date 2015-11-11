<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
  <meta http-equiv="Content-Type" content="text/html" />
  <title>la scuola del Maestro Fujimoto</title>
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
	    		<div class="generic__title">La scuola del<span class='mobile'><br/></span><span class='mobile'> </span>Maestro Fujimoto</div>
							<p>Aikikai Milano - D&#333;j&#333; Fujimoto &egrave; una delle scuole di Aikido pi&ugrave; 
								consolidate d'Italia, con 40 anni di storia sotto il diretto insegnamento
								 del Maestro Fujimoto (scomparso prematuramente a febbraio 2012).</p>
							<p>Generazioni di allievi hanno praticato su questo tatami. Tanti sono diventati Maestri 
								di propri D&#333;j&#333; in giro per l'Italia. Altrettanti sono rimasti al fianco del Maestro, 
								venendo man mano inseriti nell'insegnamento all'interno del D&#333;j&#333; Fujimoto stesso.</p>
							<p>Oggi la Scuola mantiene la linea didattica indicata dal Maestro Fujimoto, avvalendosi della guida 
								di una squadra di validi insegnanti, i quali si suddividono i vari corsi, dai bambini, 
								ai principianti, agli adulti.</p>
							<p>I fondamenti dell'Aikido e la sua etichetta, trasmessi dal Maestro Fujimoto, sono la 
								struttura su cui si basa l'insegnamento di ogni lezione all'interno della Scuola.</p>
							<p>La squadra di insegnanti &egrave; composta da cinture nere di vari gradi (da 1&deg; a 4&deg; Dan) 
								ed et&agrave; che offrono un'importante guida nella pratica degli allievi a tutti i livelli.
							</p>
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

