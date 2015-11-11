<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
  <meta http-equiv="Content-Type" content="text/html" />
  <title>il Maestro Fujimoto</title>
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
    		<div class="generic__title">Il Maestro Fujimoto</div>
				<div class='w60 fleft'>
					<p>Fujimoto Yoji Sensei 8&deg; Dan ha dato vita alla scuola di 
						Aikido Aikikai Milano - D&#333;j&#333; Fujimoto.</p>
					<div class='acenter mobile'>
					  <img src='./images/fuji_01.jpg' alt='Il Maestro Fujimoto' /> 
					</div>
					<p>Nato a Yamaguchi, nel sud del Giappone, nel 1948, Fujimoto Sensei ricevette 
						una formazione marziale impostata sul kendo, passando poi per un intenso 
						impegno sportivo (laureato a pieni voti presso la facolt&agrave; di Scienze Motorie Nittaidai di Tokyo), 
						fino a scoprire ed approfondire quella che sarebbe stata l'arte della sua vita: l'Aikido.</p>
					<p>Durante l'universit&agrave; ha la possibilit&agrave; di frequentare la scuola del fondatore di Aikido, 
						Ueshiba Morihei, a Tokyo e di praticare sotto la guida dei pi&ugrave; grandi Maestri della prima 
						generazione dopo la scomparsa del fondatore.</p>
					<p>Il suo impegno nella pratica dell'Aikido &egrave; cos&igrave; intenso che in brevissimo tempo riesce a 
						raggiungere un notevole livello, che, unito alla sua curiosit&agrave; verso il mondo al di fuori 
						del Giappone, lo fanno emergere come un candidato perfetto per la campagna di divulgazione 
						dell'Aikido nel mondo, fortemente voluta dal fondatore.</p>
					<p>&Egrave; cos&igrave; che un ancor giovane Fujimoto, nel 1970 si trova a Los Angeles, 
						San Francisco e poi Chicago a gestire dei D&#333;j&#333; per diffondere la conoscenza dell'Aikido.</p>
					<p>Nel 1971 viene mandato in "missione" in Italia, per approfondire l'opera compiuta da Tada Sensei 
						nel fondare l'Aikikai d'Italia. In particolare Fujimoto Sensei arriva a Milano, nel gennaio 1971, 
						e qui vi rimane per tutta la sua vita, consolidando una delle scuole di Aikido pi&ugrave; importanti d'Europa.</p>
					<p>In oltre 40 anni di permanenza in Italia, Fujimoto Sensei ha contribuito notevolmente alla 
						crescita dell'Aikido sul territorio, spaziando anche oltre confine in tutta Europa, 
						in tutta la Russia (fino al di l&agrave; della Siberia) e in Sud Africa.</p>
					<p>Fujimoto Sensei ha dedicato tutta la sua vita all'Aikido, sviluppando una didattica efficace e 
						incisiva che ha lasciato il segno in migliaia di praticanti. 
						Il conferimento dell'8° Dan (gennaio 2011) ne &egrave; stato sicuramente una conferma.</p>
					<p>Purtroppo Fujimoto Sensei si &egrave; spento prematuramente nel febbraio 2012, garantendo 
						la continuit&agrave; del suo Aikido nella pratica di ciascuno dei suoi innumerevoli allievi.</p>
					<p class='mobile'>&nbsp;</p>
				</div><!-- w70 -->
      			<div class='fright nomobile'>
		 			<p class='acenter'><img src="./images/fuji_01.jpg" /></p>
		 			<p>&nbsp;</p>
		 			<p class='acenter'><iframe src="http://www.youtube.com/embed/Eee2Gc4D_XY" frameborder="0" /></p>

				</div>
				<div class='acenter mobile'>
				  <iframe src="http://www.youtube.com/embed/Eee2Gc4D_XY" frameborder="0" /> 
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

