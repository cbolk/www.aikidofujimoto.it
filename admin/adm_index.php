<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="admin website">
    <meta name="author" content="cbolk">
    <link rel="icon" href="../assets/favicon.png">
    <title>area privata</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.20.custom.css">
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
    <link href="../css/dashboardAF.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type='text/javascript' src='//code.jquery.com/jquery-2.1.1.min.js'></script>
    <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.20.custom.min.js" ></script>   <?php
	include("./class.db.php");
	include("./class.login.php");
	include("./class.aikidoka.php");
	include("./class.seminar.php");
	include("./class.news.php");
	include("./class.utilities.php");

	$db = new dbaccess();
	$log = new logmein();
	$log->getdb();
	$log->dbconn->dbconnect();
	$myconn = $log->dbconn->dbconn;
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login") 
?>
</head>
<body>
		<?php
			if(!$isLogged){
		  		$log->loginform("loginf", "loginf", "form_action.php");
			} else {
			?>

    <?php include('./_nav_top.htm'); ?>

    <div class="container-fluid">
      <div class="row">
        <?php include('./_nav_main.php'); ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php
  $db = new dbaccess();
  $sem = new seminar();
  $ne = new news();
  $people = new aikidoka();
  $cu = new utils();
  $numActSem = $sem->numActiveSeminars($db);
  $numSem = $sem->numSeminars($db);
  
  $numAiki = $people->numActiveAikidoka($db);
  $numAikiYud = $people->numActiveYudansha($db);
  $numAikiYou = $people->numActiveYoungster($db);
  $numAikiBeg = $people->numActiveBeginner($db);
  $numNews = $ne->numNews($db);
  $numActNews = $ne->numActiveNews($db);
?>
          <h1 class="page-header">Riepilogo</h1>
          <div class="row">
	          <div class="col-md-6">
				    <div class="panel panel-default">
        	          <div class="panel-heading"><div class="panel-title"><h4>Notizie</h4></div></div>
            	      <div class="panel-body">	
                	   	<div class="col-xs-6 text-center"><label>in elenco</label><br/>
                	   		<button type="button" class="btn btn-primary btn-circle btn-xl"><?php echo $numNews; ?>
                	   	</div>
                    	<div class="col-xs-6 text-center"><label>attive</label><br/>
                    		<button type="button" class="btn btn-success btn-circle btn-xl"><?php echo $numActNews; ?>
                    	</div>
	                  </div>
    	           </div><!--/panel-->
	       	  </div>
	          <div class="col-md-6">
				<div class="panel panel-default">
        	          <div class="panel-heading"><div class="panel-title"><h4>Seminari</h4></div></div>
            	      <div class="panel-body">	
                	   	<div class="col-xs-6 text-center"><label>in elenco</label><br/>
                	   		<button type="button" class="btn btn-primary btn-circle btn-xl"><?php echo $numSem; ?>
                	   	</div>
                    	<div class="col-xs-6 text-center"><label>futuri</label><br/>
                    	<button type="button" class="btn btn-success btn-circle btn-xl"><?php echo $numActSem; ?></div>
	                  </div>
    	           </div><!--/panel-->
	       	  </div>
	       	  </div>
       	  <div class="row">
	          <div class="col-md-12">
				<div class="panel panel-default">
        	          <div class="panel-heading"><div class="panel-title"><h4>Iscritti</h4></div></div>
            	      <div class="panel-body">	
                	   	<div class="col-xs-3 text-center">
                	   		<label>attivi</label><br/>
                	   		<button type="button" class="btn btn-success btn-circle btn-xl"><?php echo $numAiki; ?>&nbsp;</button>
						</div>
                    	<div class="col-xs-3 text-center"><label>yudansha</label><br/>
                    		<button type="button" class="btn btn-primary btn-circle btn-xl"><?php echo $numAikiYud; ?></button>
						</div>
                    	<div class="col-xs-3 text-center"><label>principianti</label><br/>
                    		<button type="button" class="btn btn-info btn-circle btn-xl"><?php echo $numAikiBeg; ?></button>
						</div>
                    	<div class="col-xs-3 text-center"><label>ragazzi / bambini</label><br/>
                    		<button type="button" class="btn btn-warning btn-circle btn-xl"><?php echo $numAikiYou; ?></button>
						</div>
	                  </div>
    	           </div><!--/panel-->
	       	  </div>
	       </div>
        </div>
      </div>
    </div>
		<?php
			}
		?>    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="./js/jquery-1.7.2.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/fileinput.js"></script>

</body>
</html>