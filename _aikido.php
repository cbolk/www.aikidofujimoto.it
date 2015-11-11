<?php 
	setlocale(LC_TIME, 'ita');
	date_default_timezone_set('Europe/Rome');
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
  <meta http-equiv="Content-Type" content="text/html" />
  <title>l'aikido</title>
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
            <div class="generic__title">L'Aikido -  &#x5408;&#x6C17;&#x9053;</div>

  			<div class='w70 fleft'>
      				<p>L'Aikido &egrave; un'arte 
              marziale tradizionale giapponese fondata dal Maestro Morihei Ueshiba (1883-1969) 
              come disciplina del corpo, della mente e dello spirito.</p>
              <div class='acenter mobile'>
                <img src='./images/ueshiba.jpg' alt='Maestro Morihei Ueshiba' /> 
              </div>
            <p>L'ideogramma D&#333; (&#x9053;) che compare nel nome dell'Arte 
              si pu&ograve; infatti tradurre con Via, cammino spirituale, mentre Ai (&#x5408;) significa 
              Armonia e Ki (&#x6C17;) energia, spirito.</p>
            <p>Bench&eacute; infatti sia un'Arte basata sulla pratica 
              fisica essa insegna una filosofia di vita che tramanda gli elementi essenziali 
              della tradizione e della cultura del Giappone dei samurai.</p>
            <p>A differenza di altre arti marziali, per diretto 
              volere del fondatore, non si &egrave; trasformata in uno sport competitivo mantenendosi 
              fedele alle caratteristiche originali.</p>
            <p>Come ogni disciplina del Budo l'Aikido non &egrave; praticato 
              per affermare il proprio ego sugli altri ma per sviluppare, attraverso 
              lo studio continuo ed il sacrificio della pratica costante, la parte migliore 
              della natura umana.</p>
            <p>Viene data molta importanza all'etichetta da tenere 
              nel d&#333;j&#333; ed al rispetto reciproco tra praticanti con il fine di creare 
              un'atmosfera che ci aiuti nell'apprendimento di uno stile di vita positivo 
              e corretto.</p>
            <p>Essendo una pratica tecnica senza finalit&agrave; agonistiche 
              &egrave; possibile vedere in un d&#333;j&#333; di Aikido (si chiamano così i luoghi dove 
              si praticano le Arti tradizionali) persone di tutte le et&agrave;. Il tipo di 
              pratica sviluppa tra gli allievi una forma di cooperazione per cui i praticanti 
              si aiutano vicendevolmente, progredendo insieme.</p>
            <p>L'Aikido &egrave; soprattutto una pratica marziale dedicata 
              all'apprendimento delle techiche ma le lezioni non si limitano a questo 
              aspetto, vengono curati anche gli aspetti "interiori" dell'Arte finalizzati 
              al raggiungimento dell'equilibrio psicofisico del praticante.</p>
            <p>Diverse sono le motivazioni che possono spingere 
              una persona alla pratica dell'Arte, alcuni saranno interessati alla sua 
              filosofia, alcuni alla sua applicazione pratica o alcuni semplicemente 
              saranno desiderosi di fare dell'esercizio fisico.</p>
            <p>In ogni caso l'Aikido &egrave; un Budo aperto ad ogni 
              persona che aspiri a cercare l'equilibrio e l'armonia, senza discriminazioni 
              o pregiudizi, e che voglia cogliere i frutti che questa disciplina pu&ograve; 
              offrire lungo il cammino.</p>
            <p class='mobile'>&nbsp;</p>
         			</div>
            <div class='fright nomobile'>
                  <p class='acenter'><img src='./images/ueshiba.jpg' alt='Maestro Morihei Ueshiba' /></p> 
                  <p class='acenter'><img src='./images/scrittaaikido.gif' alt='Kanji Aikido' /></p>
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

