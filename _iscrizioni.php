<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
        <meta http-equiv="Content-Type" content="text/html" />
        <title>iscrizioni</title>
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
            <div class="generic__title">Iscrizioni &amp; quote</div>
				<div class='w70 fleft'>
				<p>Per le iscrizioni occorre presentarsi al D&#333;j&#333; negli
					orari di segreteria (<a title='informazioni' href='./_info.php'>info</a>), portando:
     				<ul class='bullet'>
     					<li>2 fototessera;</li>
     					<li>certificato medico per attivit&agrave; non agonistica in originale;</li>
     					<li>il codice fiscale;</li>
     					<li>attestato di versamento in favore dell'Aikikai d'Italia che comprende
     						l'assicurazione infortuni (<em>il bollettino precompilato
     							&egrave; disponibile presso il D&#333;j&#333;</em>)
     							<ul class='bullet'>
     								<li>adulti: 35 &euro;</li>
									<li>yudansha: 45 &euro;</li>
									<li>ragazzi fino a 14 anni: 21 &euro;</li>
  							    </ul>
     					</li>
     				</ul>
          </p>
        	<p>Quota mensile (da versare in anticipo)
     			    <ul class="bullet"><li><em>adulti</em>
     							<ul class="bullet">
     								<li>1 mese: 60 &euro;</li>
     								<li>3 mesi: 165 &euro;</li>
     								<li>6 mesi: 315 &euro;</li>
     								<li>1 anno: 530 &euro; (da settembre a luglio)</li>
     							</ul>
     							</li>
     							<li><em>bambini e ragazzi</em>: 250 &euro; (da ottobre a maggio)</li>
    							<li><em>pre-aikido</em>: 200 &euro; (da ottobre a maggio)</li>
     						</ul>
     				</p>
     			<p>Quota giornaliera ("tatami fee"): 10 &euro;</p>
           <p class='mobile'>&nbsp;</p>
       			</div>
       			<div class='fright acenter nomobile'>
         				    <img src="./images/scrittaaikido.gif" alt="aikido"/>

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
