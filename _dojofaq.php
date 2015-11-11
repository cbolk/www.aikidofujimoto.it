<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	$db = new dbaccess();
	$db->dbconnect();
?>
<head lang="it">
  <meta http-equiv="Content-Type" content="text/html" />
  <title>AIKIKAI MILANO: ETICHETTA</title>
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
    		<div class="generic__title">Etichetta per la pratica</div>
           <p class="question">Posso praticare presso il D&#333;j&#333; Fujimoto anche se non sono iscritto al D&#333;j&#333;?</p>
           <p class="answer">Si, se siete in regola con l'iscrizione all'Aikikai d'Italia o a qualsiasi federazione rispetto all'assicurazione.
             Quando arrivate, passate in segreteria.</p>

             <p class="question">Posso praticare anche solamente un giorno?</p>
             <p class="answer">Si, se siete in regola con l'Aikikai d'Italia o qualsiasi altra federazione
               rispetto all'assicurazione, &egrave; sufficiente pagare una quota giornaliera, che vi consente di praticare in tutte le lezioni
              per adulti della giornata.</p>

              <p class="question">Posso salire sul tatami in qualsiasi momento?</p>
              <p class="answer">No, si pu&ograve; salire sul tatami solamente prima che la lezione inizi. Consultate <a href="/<?php echo $currentSchedule; ?>.php">l'orario</a>.</p>

            <p class="question">Posso acquistare un keikogi (uniforme) presso il dojo?</p>
            <p class="answer">Si, &egrave; possibile acquistare un keikogi in segreteria. Tenete presente che la disponibilit&agrave; di taglie e quantit&agrave; &egrave; limitata.</p>

            <p class="question">Posso acquistare delle ciabatte/zatterine per accedere al tatami?</p>
            <p class="answer">No, non ci sono calzature da acquistare.</p>

            <p class="question">Posso affittare un keikogi (uniforme) presso il dojo?</p>
            <p class="answer">No, non si affittano keikogi. .</p>

            <p class="question">Posso indossare delle calze durante la pratica?</p>
            <p class="answer">In linea di massima no.</p>

            <p class="question">Posso indossare anelli, orecchini o altri accessori durante la pratica?</p>
            <p class="answer">No, come regola generale &egrave; necessario togliersi tutti gli accessori.</p>

            <p class="question">Posso andarmene durante una lezione?</p>
            <p class="answer">No, in generale si dovrebbe rimanere sul tatami fino al termine della lezione. Nel caso dobbiate andarvene
            prima, concordate la cosa con l'insegnante.</p>

            <p class="question">Posso partecipare ad una lezione principianti anche se ho un grado superiore?</p>
            <p class="answer">Come regola generale, no, potete praticare nelle lezioni per gli <a href="/<?php echo $currentSchedule; ?>.php">adulti</a>.</p>

            <p class="question">Posso fare foto/video durante la lezione?</p>
            <p class="answer">No, in linea di massima non &egrave; permesso fare foto/video.</p>

            <p class="question">Dove posso piegare l'hakama?</p>
            <p class="answer">&Egrave; possibile piegare l'hakama sul tatami dopo l'ultima ora di pratica, oppure nello spogliatoio al termine delle altre ore.</p>

            <p class="question">C'&egrave; qualcosa d'altro di cui essere consapevoli per non aver atteggiamenti scortesi durante la lezione?</p>
            <p class="answer">Mentre l'insegnante spiega, prestare attenzione in seiza.<br/>
            Inoltre, mentre l'insegnante spiega, evitare di:
            <ul>
              <li>utilizzare fazzoletti</li>
              <li>sistemarsi il keikogi, la cintura o l'hakama</li>
              <li>pettinarsi</li>
          </ul>
           </p>

          <p>Tratte dal <a target=_blank href="http://www.asahi-net.or.jp/~yp7h-td/regoleit.htm">sito</a> del Honbu Dojo di Tokyo.</p>
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
