<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="it">
  <head>
<?php  
	include("./class.login.php");
	include("./class.db.php");
	include("./class.aikidoka.php");
	include("./class.utilities.php");
	setlocale(LC_TIME, 'ita');
	date_default_timezone_set('Europe/Rome');
	$db = new dbaccess();

	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	


?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="admin website">
    <meta name="author" content="cbolk">
    <link rel="icon" href="../assets/favicon.png">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,400italic,700,300,300italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oxygen+Mono' rel='stylesheet' type='text/css'>
	<title>iscritti </title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.20.custom.css">
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
    <link href="../css/dashboardAF.css" rel="stylesheet">
	<!-- link  href="../css/presenze.css" rel="stylesheet" -->   

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type='text/javascript' src='//code.jquery.com/jquery-2.1.1.min.js'></script>
    <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.20.custom.min.js" ></script>   
	<script type="text/javascript" src="../js/presenze.js"></script>
	<script>
		$(document).ready(function() {
			$('a.del').click(function(e) {
				e.preventDefault();
				var parent = $(this).parent();
				var row = parent.parent();
				var value = parent.attr('id').replace('record-','');
				$.ajax({
					type: 'post',
					url: 'adm_aikidoka_del.php',
					data: 'del=' + value,
					beforeSend: function() {
			            row.css('background-color', '#ff4d4d').animate({
			              backgroundColor: '#ff4d4d'
			            }, 500);
			          },
					success: function() {
						row.slideUp(300,function() {
							row.remove();
						});
					}
				});
			});
		});
		</script>

		<script>
		$(function(){
			//acknowledgement message
		    var message_status = $("#status");
		    $("td[contenteditable=true]").blur(function(){
		        var field_userid = $(this).attr("id") ;
		        var value = $(this).text();
		        $.post('adm_aikidoka_list_update.php' , field_userid + "=" + value, function(data){
						
		        });
			});	
			$(':checkbox').checkboxpicker();
			$(':checkbox').checkboxpicker().change(function() {
		        var field_userid = $(this).attr("id") ;
		        var value = $(this).prop('checked');
		        $.post('adm_aikidoka_list_update.php' , field_userid + "=" + value, function(data){
						
		        });
			});
		});
		</script>
</head>
<body>
<?php
	if($isLogged == false) { 
		header("Location: adm_index.php");
		exit;
	} 
?>
   <?php include('./_nav_top.htm'); ?>

    <div class="container-fluid">
      <div class="row">
        <?php include('./_nav_main.php'); ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php
  $aiki = new aikidoka();
  $cu = new utils();
  $num = $aiki->numActiveAikidoka($db);
  $numYud = $aiki->numActiveYudansha($db);
  $numYou = $aiki->numActiveYoungster($db);
  $numB = $aiki->numActiveBeginner($db);
  $list = $aiki->rawlist($db,$activeonly);
?>
          <h1 class="page-header">Iscritti 
          
          <button type="button" class="btn btn-primary btn-circle btn-xl"><?php echo $numYud; ?></button>
          <button type="button" class="btn btn-info btn-circle btn-xl"><?php echo $numB; ?></button>
          <button type="button" class="btn btn-warning btn-circle btn-xl"><?php echo $numYou; ?></button>
          <button type="button" class="btn btn-success btn-circle btn-xl"><?php echo $num; ?></button>
          <button type="button" class="btn btn-default btn-circle btn-xl"><?php echo mysql_num_rows($list); ?></button>
          
          </h1>
          <div class="row">
            <div class=" actions aright">
				<a href="./adm_aikidoka_new.php"><i class="fa fa-user-plus fa-fw"></i>&nbsp; nuovo</a>
            </div>
          </div>
          <div class="table-responsive">
			<table class="table table-striped"  id="ajaxtable">
				<thead>
				  <tr>
					<th>cognome</th>
					<th>nome</th>
					<th>grado</th>
					<th>data&nbsp;iscrizione</th>
					<th>data&nbsp;esame</th>
					<th>yudansha</th>
					<th>principiante</th>
					<th>ragazzi</th>
					<th>attivo</th>
					<th>dettagli</th>
					<th>elimina</th>
				  </tr>
				</thead>
				<tbody>
				  <?php
						while($row = mysql_fetch_array($list)) {
							echo "<tr id='" . $row['id'] . "' ";
							echo "class='isact" . $row['active'];
							echo "'><a name='" . $row['id']  . "'></a>";
							echo "<td id='lastname:" . $row['id'] . "' contenteditable='true'>" . str_replace(" ","&nbsp;",$row['lastname']) . "</td>";
							echo "<td id='firstname:" . $row['id'] . "' contenteditable='true'>" . str_replace(" ","&nbsp;",$row['firstname']) . "</td>";
							echo "<td id='rank:" . $row['id'] . "' contenteditable='true'>" . $row['rank'] . "</td>";
							echo "<td id='enrolled:" . $row['id'] . "' contenteditable='true'>" . $db->db_to_date($row['enrolled']) . "</td>";
							echo "<td id=last_exam:" . $row['id'] . "' contenteditable='true'>" . $db->db_to_date($row['last_exam']) . "</td>";
							echo "<td class='cntr' id='yudansha:" . $row['id'] . "' contenteditable='true'>";
							echo "<input data-style='btn-group-xs' class='form-control' name='yudansha' id='yudansha:" . $row['id'] . "' type='checkbox' data-off-title='NO' data-on-title='SI' data-on-class='btn-primary' data-off-class='btn-default' ";
							if($row['yudansha'] == "1")
								echo " checked "; 
							echo " />";
							echo "</td>";
							echo "<td class='cntr' id='beginner:" . $row['id'] . "' contenteditable='true'>";
							echo "<input data-style='btn-group-xs' class='form-control' name='beginner' id='beginner:" . $row['id'] . "' type='checkbox' data-off-title='NO' data-on-title='SI' data-on-class='btn-info' data-off-class='btn-default' ";
							if($row['beginner'] == "1")
								echo " checked "; 
							echo " />";
							echo "</td>";
							echo "<td class='cntr' id='youngster:" . $row['id'] . "' contenteditable='true'>";
							echo "<input data-style='btn-group-xs' class='form-control' name='youngster' id='youngster:" . $row['id'] . "' type='checkbox' data-off-title='NO' data-on-title='SI' data-on-class='btn-warning' data-off-class='btn-default' ";
							if($row['youngster'] == "1")
								echo " checked "; 
							echo " />";
							echo "</td>";
							echo "<td class='cntr' id='active:" . $row['id'] . "' contenteditable='true'>";
							echo "<input data-style='btn-group-xs' class='form-control' name='active' id='active:" . $row['id'] . "' type='checkbox' data-off-title='NO' data-on-title='SI' data-on-class='btn-success' data-off-class='btn-danger' ";
							if($row['active'] == "1")
								echo " checked "; 
							echo " />";
							echo "</td>";
							echo "<td class='cntr' id='record-" . $row['id'] . "'><a href='./adm_aikidoka_view.php?aid=" . $row['id'] . "'><i class='fa fa-user fa-fw'></i></a></td>";
							echo "<td class='cntr' id='record-" . $row['id'] . "'><a href='#' class='del'><i class='fa fa-trash fa-fw'></i></a></td>";
							echo "</tr>";
						}
				  ?>
				</tbody>
			</table>		

          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="./js/jquery-1.7.2.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-checkbox.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/fileinput.js"></script>
  </body>
</html>
