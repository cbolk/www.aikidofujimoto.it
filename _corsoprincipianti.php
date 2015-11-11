<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
  <meta http-equiv="Content-Type" content="text/html" />
  <title>corso principianti</title>
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
    		<div class="generic__title">Il corso principianti</div>
        <p>Il corso principianti &egrave; aperto a tutti coloro che non conoscono e che non hanno mai praticato Aikido.</p>
        <p>L'et&agrave; minima per l'iscrizione &egrave; di 15 anni.</p>
        <p>Il corso prevede l'insegnamento dell'etichetta, dei movimenti di base e delle cadute propedeutici all'apprendimento
        delle tecniche di Aikido, con l'obiettivo di portare l'allievo al successivo
        inserimento nel <a href='./_corsoadulti.php' title="corso avanzati">corso adulti</a>.</p>
        <p>Il corso inizia ai primi di ottobre e termina a fine giugno con un esame che permette l'accesso al corso adulti.</p>
        <p>Ci sono diversi orari a disposizione per gli allievi principianti, tutti frequentabili liberamente.
        Per ottimizzare la pratica e garantire un buon apprendimento,
        si consiglia di frequentare almeno 2 lezioni alla settimana, a scelta tra i vari orari.</p>
        <p>L'inserimento nel corso principianti pu&ograve; avvenire durante tutto l'anno accademico,
        venendo inizialmente seguiti individualmente per portarsi al livello del resto
        del gruppo che ha iniziato da ottobre.</p>
        <p>Per motivi burocratici e di sicurezza non &egrave; possibile fare lezioni di prova.<br/>&Egrave; invece
        caldamente consigliato assistere a tutte le lezioni che si desidera prima dell'iscrizione.</p>
        <p>Per chi fosse interessato o volesse ulteriori informazioni &egrave; pregato gentilmente di contattare
        la segreteria o di venirci a trovare personalmente al D&#333;j&#333; (vedi <a href='./_info.php'>informazioni</a>).</p>
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
