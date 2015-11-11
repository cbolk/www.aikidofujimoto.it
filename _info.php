<?php 
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
  	$db = new dbaccess();
  	$db->dbconnect();
?>
<head lang="it">
        <meta http-equiv="Content-Type" content="text/html" />
        <title>informazioni e contatti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon-precomposed" href="assets/favicon_t.png" />
        <link rel="shortcut icon" href="assets/favicon.png">
    <link rel="stylesheet" media="screen" href="css/main.css" /> <!--Load CSS-->
	    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	    <link rel="stylesheet" href="css/slicknav.css" />
		<script src="js/jquery.slicknav.cb.js"></script>
		<script src="js/jquery.slicknav.menu.js"></script>
    <script type="text/javascript">
    <!--
        function select_language(visible,notvisible) {
           var ne = document.getElementById(notvisible);
           ne.style.display = 'none';
           var ve = document.getElementById(visible);
           ve.style.display = 'block';
        }
    //-->
    </script>
</head>
<body onLoad="select_language('italian','english');">
    <div class="site_wrapper">
      <?php include('./_head_banner.php'); ?>
      <div class="sidebar">
        <?php include('./_menu.php'); ?>
      </div><!-- sidebar -->
      <div class="site_container">
        <div class="generic-page">
          <div id="italian">
            <div class="generic__title">Informazioni &nbsp;&nbsp;<a href="#" onclick="select_language('english','italian');"><img src='./images/en.png'  width='24px' title='in English'/></a></div>
            <table width="100%">
            <tr>
                <td>
                  <img class="nomobile" src="images/dojoesterno.jpg" name="dojoesterno" width="250" height="166" hspace="0" vspace="0" border="0" align="top" id="dojoesterno">
                  <img class="mobile" src="images/dojoesterno.jpg" name="dojoesterno" width="350" height="200" hspace="0" vspace="0" border="0" align="top" id="dojoesterno">
                  <p class='h130'><strong>Aikikai Milano - Dojo Fujimoto</strong><br/>
                    via Lulli 30 b<br/>
                    <em>ingresso via Porpora 43-47<br/>angolo farmacia</em><br/>
                    20131 Milano - Italia<br/>
                    Tel: (+39)3479510436<br/>
                    scarica le informazioni: <a href='./public/AikidoFujimoto.vcf' title='scarica vcard'><img src='./images/downloadvcard.jpg'/></a><br>

                    <br/>
                    <strong>Orario Segreteria</strong><br/>
                    da luned&igrave; a venerd&igrave; dalle 16 alle 20<br/>
                    email: segreteria _AT_ aikidofujimoto.it
                    <br/><br/>
                    sito web: webmaster _AT_ aikidofujmoto.it
                    </p>
                </td>
                <td >
                  <iframe class="nomobile" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2797.1850784337016!2d9.221094115866347!3d45.486217639994415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4786c6e43344fc8f%3A0xc819df66fb04af4b!2sDojo+Fujimoto+-+Aikikai+Milano!5e0!3m2!1sen!2sit!4v1447169578310" width="576" height="372" frameborder="0" style="border:0" allowfullscreen></iframe>
                  <!--img class="nomobile" src="images/cartina.jpg" name="cartina" width="576" height="372" hspace="0" vspace="0" border="0" id="cartina"-->
              </td>
              </tr>
            </table>
            <div>
              <iframe class="mobile" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2797.1850784337016!2d9.221094115866347!3d45.486217639994415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4786c6e43344fc8f%3A0xc819df66fb04af4b!2sDojo+Fujimoto+-+Aikikai+Milano!5e0!3m2!1sen!2sit!4v1447169578310" width="95%" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <div id="english">
            <div class="generic__title">Information &nbsp;&nbsp;<a href="#" onclick="select_language('italian','english');"><img src='./images/it.png' width='24px' title='in Italiano'/></a></div>
            <table width="100%">
  					<tr>
  				    	<td>
                  <img class="nomobile" src="images/dojoesterno.jpg" name="dojoesterno" width="250" height="166" hspace="0" vspace="0" border="0" align="top" id="dojoesterno">
                  <img class="mobile" src="images/dojoesterno.jpg" name="dojoesterno" width="350" height="200" hspace="0" vspace="0" border="0" align="top" id="dojoesterno">
  				    		<p class="h130"><strong>Aikikai Milano - Dojo Fujimoto</strong><br/>
  				        	via Lulli 30 b<br/><em>entrance from via Porpora 43-47,<br/>near the Pharmacy</em><br/>
  				        	20131 Milano - Italy<br/>
  				        	Tel: (+39)3479510436<br/>
  				        	download infos: <a href='./public/AikidoFujimoto.vcf' title='download vcard'><img src='./images/downloadvcard.jpg'/></a><br>

  				        	<br/>
  				        	<strong>Information Desk</strong><br/>
  				        	Monday to Friday, 4:00PM to 8:00PM<br/>
  				        	email: segreteria _AT_ aikidofujimoto.it
                    <br/><br/>
                    web contact: webmaster _AT_ aikidofujmoto.it
  				       		</p>
  				    	</td>
  					    <td>
                  <iframe class="nomobile" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2797.1850784337016!2d9.221094115866347!3d45.486217639994415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4786c6e43344fc8f%3A0xc819df66fb04af4b!2sDojo+Fujimoto+-+Aikikai+Milano!5e0!3m2!1sen!2sit!4v1447169578310" width="576" height="372" frameborder="0" style="border:0" allowfullscreen></iframe>
  					    	<!--img class="nomobile" src="images/cartina.jpg" name="cartina" width="576" height="372" hspace="0" vspace="0" border="0" id="cartina"-->
  						</td>
  				  	</tr>
  				  </table>
            <div>
              <iframe class="mobile" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2797.1850784337016!2d9.221094115866347!3d45.486217639994415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4786c6e43344fc8f%3A0xc819df66fb04af4b!2sDojo+Fujimoto+-+Aikikai+Milano!5e0!3m2!1sen!2sit!4v1447169578310" width="95%" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <p class="mobile">&nbsp;</p>
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
