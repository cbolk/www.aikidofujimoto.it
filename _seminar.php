<?php
	setlocale(LC_TIME, 'ita');
	date_default_timezone_set('Europe/Rome');
  	include("./adm/class.utilities.php");
  	include("./adm/class.db.php");
	include("./adm/class.seminar.php");

  $db = new dbaccess();
  $db->dbconnect();
  $seminar = new seminar();
  $semID = $_GET["sid"];
  $seminario = $seminar->get($db,$semID);
  $from = medDate($seminario->fromdate);
  $fromMob = medDate($seminario->fromdate);
  $to = medDate($seminario->todate);
  $toMob = medDate($seminario->todate);
  $istruttori = $seminar->getStageInstructors($db,$semID);
?>
<!DOCTYPE html>
    <head>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html" />
        <title>dettagli seminario</title>
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

        <div class="post_container">
          <div class="post_container__post__title"><? echo $seminario->title; ?></div>
        <!-- ?php if (strpos($seminario->title,"Maestro") == FALSE && strpos($seminario->title,"M&deg;") == FALSE && strpos($seminario->title,"M°") == FALSE ){ ? -->
          <!-- div class="post_container__post__title"><? echo $seminario->title . '<br/>' . $seminario->instructorlabel; ?></div -->
        <!-- ?php } else { ? -->
          <!-- div class="post_container__post__title"><? echo $seminario->title; ?></div -->
        <!-- ?php } ? -->
          <div class="post_container__post__subtitle">
            <div class="post_container__divider"><hr/></div>
            <div class="post_container__post__date"> <i class="fa fa-calendar-o"> </i>
              <div class="post_container__post__date_value nomobile"><em>da</em> <? echo $from; ?> <em>a</em> <? echo $to; ?></div>
              <div class="post_container__post__date_value mobile"><em>da</em> <? echo $fromMob; ?> <em>a</em> <? echo $toMob; ?></div>
            </div>
            <div class="post_container__post__category"> <i class="fa fa-flag-o seminar_<? echo $seminario->seminartype; ?>"> </i>
              <div class="post_container__post__category_value seminar_<? echo $seminario->seminartype; ?>"><? echo $seminario->seminartype; ?></div>
            </div>
            <div class="post_container__post__tags"> <i class="fa fa-tags"></i>
              <div class="post_container__post__tag"><? echo $seminario->tags; ?></div>
            </div>
            <?php
              if($seminario->pdf != '') { ?>
              <div class="post_container__post__pdf"> <i class="fa fa-file-pdf-o"></i>
                <div class="post_container__post__pdf_value"><a class="anoborder" title="scarica la locandina" href="./stages/<?php echo $seminario->pdf; ?>">locandina</a></div>
              </div>
            <?php
              } else { ?>
              <div class="post_container__post__pdf"> <i class="fa fa-file-pdf-o"></i>
                <div class="post_container__post__pdf_value">(disponibile a breve)</div>
              </div>

<?php
              }
            ?>
            <div class="post_container__divider"><hr/></div>
          </div><!-- post_container__post__subtitle -->
          <div class="post_text">
            <?php if(strlen(trim($seminario->image)) > 0) {?>
            <div class="miniature">
              <a class="anoborder" title="scarica la locandina" href="./stages/<?php echo $seminario->pdf; ?>"><img class="noborder" width="100px" src="stages/<?php echo $seminario->image?>"/></a>
            </div>
            <?php }?>
            <div class="seminar_data">
                <!--div class="seminar_data__detail">
                  <div class="seminar_data__key">Descrizione</div>
                  <div class="seminar_data__value"><? echo $seminario->description; ?></div>
                </div-->
                <?php
                  $num = count($istruttori);
                  if($num > 0){
                  ?>
                  <div class="seminar_data__detail">
                    <div class="seminar_data__key">Diretto
                      <?php                       
                       if($num == 1)
                          echo "dal Maestro";
                       else
                          echo "dai Maestri";
                       echo "</div>";
                       for($i = 0; $i < $num; $i++){
                            echo "<div class='seminar_data__value'>&nbsp;";
                            echo $istruttori[$i]['lastname'] . " " . $istruttori[$i]['firstname'] . ", " . $istruttori[$i]['rank'];
                            echo "</div>";
                            if($i < $num - 1)
                              echo "<div class='seminar_data__key nomobile'></div>";
                       }
                    ?>
                </div>
                <?php } /* if $num > 0 */ ?>
                <div class="seminar_data__detail">
                  <div class="seminar_data__key">Luogo</div>
                  <div class="seminar_data__value"><? echo $seminario->location; ?><br/><? echo $seminario->address; ?><br/><? echo $seminario->city; ?></div>
                </div>
                <div class="seminar_data__detail">
                <?php if($seminario->schedule != '') {?>
                    <div class="seminar_data__key">Orario</div>
                    <div class="seminar_data__value"><span class="emp"><? echo $seminario->schedule; ?></span></div>
                <?php } ?>
                </div>
                <div class="seminar_data__detail">
                  <div class="seminar_data__key">Organizzazione</div>
                  <div class="seminar_data__value"><? echo $seminario->organizer; ?></div>
                  <?php if($seminario->phone != '') { ?>
                    <div class="seminar_data__key nomobile">&nbsp;</div>
                    <div class="seminar_data__value indent"><i class="fa fa-phone"> </i> <? echo $seminario->phone; ?> </div>
                  <?php } ?>
                  <?php if($seminario->email != '') { ?>
                    <div class="seminar_data__key nomobile">&nbsp;</div>
                    <div class="seminar_data__value indent"><i class="fa fa-envelope"> </i> <? echo $seminario->email; ?></div>
                  <?php } ?>
                  <?php if($seminario->opening != '') { ?>
                    <div class="seminar_data__key nomobile">&nbsp;</div>
                    <div class="seminar_data__value indent"><i class="fa fa-clock-o"> </i> <? echo $seminario->opening; ?></div>
                  <?php } ?>
                  <?php if($seminario->url != '') { ?>
                    <div class="seminar_data__key nomobile"></div>
                    <div class="seminar_data__value indent"><i class="fa fa-home"> </i> <a target=_blank alt='apre una nuova finestra' href='<? echo $seminario->url; ?>'><? echo $seminario->url; ?></a></div>
                  <?php } ?>
                </div>
                <?php
                  if($seminario->notes != ''){
                    ?>
                      <div class="seminar_data__detail">
                        <div class="seminar_data__key">Note</div>
                        <div class="seminar_data__value last"><? echo $seminario->notes; ?></div>
                      </div>
                    <?php
                    }
                ?>
            </div>
            <p class='mobile'>&nbsp;</p>
          </div>
        </div>
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
