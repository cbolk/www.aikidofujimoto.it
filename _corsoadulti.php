<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
  <meta http-equiv="Content-Type" content="text/html" />
  <title>corso adulti</title>
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
    		<div class="generic__title">Il corso adulti</div>
					<p>Il corso adulti &egrave; aperto a tutti coloro che praticano gi&agrave; Aikido o che lo hanno praticato
        in passato, e quindi conoscono la disciplina; nel caso non si abbia alcuna esperienza,
        &egrave; necessario frequentare
        	il <a href='./_corsoprincipianti.php' alt='corso principianti'>corso principianti</a> per apprendere le basi, avendo poi accesso al corso adulti.<br/>
        L'et&agrave; minima per l'iscrizione &egrave; 14 anni: per i pi&ugrave; giovani ci sono
        i corsi <a href='_corsoragazzi.php' alt='corso giovani'>bambini e ragazzi</a>.</p>
        <p>Il corso inizia il primo di settembre e termina a fine agosto.<br/>
        Si pu&ograve; iniziare a frequentare in qualsiasi momento dell'anno.</p>
        <p>Per motivi burocratici e di sicurezza (personale e del D&#333;j&#333;) non &egrave;
        possibile fare la lezione di prova.
        &Egrave; per&ograve; possibile assistere a tutte le lezioni che si
        desidera fino al momento dell'iscrizione.</p>
        <p>Per chi fosse interessato o volesse ulteriori informazioni &egrave; pregato
        gentilmente di contattare la segreteria o di venirci a trovare personalmente
        al D&#333;j&#333;.</p>
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
