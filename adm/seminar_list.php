<?php  session_start(); ?>
<html lang="it">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Aikido Fujimoto << Gestione seminari >></title>
<?php  
	include("basic.php");
	include("class.db.php");
	include("class.login.php");
	include("../adm/class.seminar.php");
	include("../adm/class.utilities.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	
?>
	<link rel="shortcut icon" href="../assets/favicon.ico">
	<link rel=stylesheet type="text/css" href="../css/admin.css">
	<link rel=stylesheet type="text/css" href="../css/jquery-ui-1.8.20.custom.css">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/dashboard.css" rel="stylesheet">
	<link href="../css/bootstrap-tags.css" rel="stylesheet">
	<link href="../css/fileinput.css" rel="stylesheet">
	<link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">
	<style>
		:target{background-color: red};
	</style>

	<script type='text/javascript' src='//code.jquery.com/jquery-2.1.1.min.js'></script>
	<script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.20.custom.min.js" ></script>   
	<script>
		$(document).ready(function() {
		    var hash = window.location.hash;
		    $(hash).css('background-color', '#B2CCDA').animate({
		        backgroundColor: '#fff'
		    }, 2000);

			$('a.del').click(function(e) {
				e.preventDefault();
				var parent = $(this).parent();
				var row = parent.parent();
				var value = parent.attr('id').replace('record-','');
				$.ajax({
					type: 'post',
					url: 'seminar_del.php',
					data: 'del=' + parent.attr('id').replace('record-',''),
					beforeSend: function() {
						row.animate({'backgroundColor':'red'},300);
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
</head>


<body>
<?php
	if($isLogged == false) { 
		header("Location: index.php");
		exit;
	} 
?>
<div id="wrapper">
	
	<div id="header">
		<h1>area riservata: gestione seminari</h1>
		<div id="usrnav">
			<a class="btn-fuji adm-home" href="./index.php">home</a>
			<a class="btn-fuji adm-logout" href="./form_action.php?action=logout">logout</a>
		</div>
	</div>
	<div id="main">	
		<div class='actions aright'>
			<a href="./seminar_list.php" alt="elenco seminari"><i class="fa fa-bars"></i> elenco</a>&nbsp;
			<a href="./seminar_new.php" alt="aggiungi un nuovo seminario"><i class="fa fa-calendar-plus-o"></i> nuovo</a>
		</div>
	
<?php
	$db = new dbaccess();
	$sem = new seminar();
?>

		<h2>Lista seminari</h2>
		<!-- list of all stages -->
	<?php
		$list = $sem->rawlist($db,false,false);
		$cu = new utils();
		$counter = 1;
		?>
		<div class='table-responsive'>
			<table class="table table-striped">
    	      <thead>
        	  	<tr>
        	    	<th>dal</th>
        	        <th>al</th>
        	        <th>luogo</th>
        	        <th>titolo</th>
        	        <th>diretto da</th>
        	        <th>pdf</th>
        	        <th>min</th>
        	        <th>img</th>
        	        <th>edit</th>
        	        <th>del</th>
        	    </tr>
			  </thead>
              <tbody>
<?php	while($row = mysql_fetch_assoc($list)){
			$sid = $row['id'];
			$s = new seminar();
			$loc = $s->getStageLocation($db,$sid);
			$instr = $s->getStageInstructors($db,$sid);
			$nin = count($instr);

			$mod = fmod($counter,2);
			if ($mod == 1)
				$class = 'todd';
			else
				$class = 'teven';		
			echo "<tr id='" . $sid . "' ><a name='" . $sid . "'/>";
			echo "<td class='seminar_data'>" . $cu->date2monthday($row['startdate']) . "</td>";
			echo "<td class='seminar_data'>" . $cu->date2monthday($row['enddate']) . "</td>";
			echo "<td  class='seminar_info'>";
			if($loc[0]['name'] != "")
				echo $loc[0]['name']  . "<br/>" . $loc[0]['shortcity'];
			else
				echo $row['location']. "<br/>" . $row['shortcity'];
			echo  "</td>";
			echo "<td class='seminar_title'>" . $row["shortdescription"] . "</td>";
			echo "<td class='seminar_info'>";
			for($i = 0; $i < $nin; $i++){
				echo "M&deg;&nbsp;" . $instr[$i]['lastname'];
				if($i < $nin - 1)
					echo "<br/>";
			}
			
			echo "</td>";
			echo "<td class='seminar_info'>";
			if($row['pdf'] != "")				
				echo "<i class='fa fa-file-pdf-o'></i>";
			echo "</td>";

			echo "<td class='seminar_info'>";
			if($row['image'] != "")				
				echo "<i class='fa fa-file-image-o'></i>";
			echo "</td>";

			echo "<td class='seminar_info'>";
			if($row['photo'] != "")				
				echo "<i class='fa fa-picture-o'></i>";
			echo "</td>";

			echo "<td class='seminar_info' id='record-" . $sid . "'><a class='edit' href='#'><i class='fa fa-pencil-square-o'></i></a></td>";
			echo "<td class='seminar_info' id='record-" . $sid . "'><a class='del' href='#'><i class='fa fa-trash'></i></a></td>";

			echo "</tr>";
		}
		echo "</div>";
	
		//echo $sem->listall($db, curPageName(), curPageName() . '?act=modifica', curPageName() . '?act=del', $uploaddir);
	?>
		</tbody>
		</table>
	<div class="clearall"></div>
	</div><!-- main -->
	<div id="footer">
	<?php echo "i file caricati vengono messi nel folder: ". $uploaddir ; ?>	
	</div>	
</div>
</body>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.js"></script>
	<script src="../js/fileinput.js"></script>
	<script src="../js/moment-with-locales.js"></script>
	<script src="../js/bootstrap-datetimepicker.min.js"></script>
	<script src="../js/bootstrap-tags.min.js"></script>
</html>