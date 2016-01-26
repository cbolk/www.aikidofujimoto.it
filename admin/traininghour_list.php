<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="UTF-8">
<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
<title>Aikido Fujimoto | Elenco insegnanti</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php  
	include("../admin/basic.php");
	include("../admin/class.db.php");
	include("./class.classinstructor.php");
	include("./class.traininghour.php");

    $db = new dbaccess();
    $ci = new classinstructor();
    $jsonci = $ci->get($db);
	$instr = json_decode($jsonci, TRUE);

	$month = $_GET['month'];

    $th = new traininghour();
    $jsonth = $th->getOrderByHourByMonth($db,$month);
    $hours = json_decode($jsonth, TRUE);

/*	include("class.login.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login")
*/
?>
	<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/main.css" />
	<link rel="stylesheet" href="css/adm.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
	<script>
	$(function(){

		$('a.delete').click(function(e) {  
			e.preventDefault();
			var clickedID = this.id.split(':');
			var recid = clickedID[1];
			var datum = "lid=" + recid;
			$('#' + recid).addClass("sel");
			// $(this).hide(); useless here ...
			// alert(datum);
			jQuery.ajax({
				type: "POST",
				url: "classinstructor_del.php",
				data: datum,
	        	cache: false,
	        	success: function(response){
			   		if(response!='error'){
			      		$('#ajaxtable').html(response);
			     	}
				},
				error: function(xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
			});
		});
		$('a.addnew').click(function(e) {  
			e.preventDefault();
			$('.addnew').hide();
			$('.hiddenspace').show();
			$('#newinstructor').show();
		});
		$(".submit").click(function(e) {
			e.preventDefault();
			var fullname = $("#fullname-add").val();
			var lastname = $("#lastname-add").val();
			var rank = $("#rank-add").val();
			var shortbio = $("#shortbio-add").val();

			var dataString = 'fullname='+ fullname + '&lastname=' + lastname + '&rank=' + rank + '&shortbio=' + shortbio;
			alert(dataString);
			$.ajax({
				type: "POST",
				url: "classinstructor_create.php",
				data: dataString,
				success: function(response){
					$('.success').fadeIn(200).show();
					$('.error').fadeOut(200).hide();
					$('#newinstructor').hide();
					$('.addnew').show();
					$('.hiddenspace').hide();
					},
				error: function(xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
			});
			return false;
		});
	});
	$(function(){
    	$("[contenteditable=true]").blur(function(){
	       	var field_userid = $(this).attr("id") ;
	       	var split_data = field_userid.split("|");
	       	var hour_id = split_data[0];
        	var value = $(this).val();
        	var dataString = field_userid + "=" + value;
        	//alert(dataString);
			$.ajax({
				type: "POST",
				url: "traininghour_list_upd.php",
				data: dataString,
				success: function(response){
					
				},
				error: function(xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
			});
/*        	$.post('traininghour_list_upd.php' , field_userid + "=" + value, function(data){
				
        	});*/
    	});	

	});
	</script>

</head>
<body>
<?php
/*
	if($isLogged == false) { 
		header("Location: index.php");
		exit;
	} 
*/
?>
<div class="site_wrapper">
		<div class="header">
		</div>
		<div class="site_container">
			<div class="page__title">Ore di pratica</div>
			<div class="admin_table">
		        	<p class="acenter"><a class="addnew" href="#">Aggiungi ora di pratica <i class='fa fa-calendar-plus-o'></i></a><p>
					<p class="hiddenspace" style="display:none">&nbsp;</p>
				<div class="weekdaytitle">Luned&igrave;</div>
				<div class="weekdaytitle">Marted&igrave;</div>
				<div class="weekdaytitle">Mercoled&igrave;</div>
				<div class="weekdaytitle">Gioved&igrave;</div>
				<div class="weekdaytitle">Venerd&igrave;</div>
				<div class="weekdaytitle">Sabato</div>
				<div class="clear"></div>
				<?php
					$iter = 0; /* iterator for training hours*/
					for($hrs = 7; $hrs < 21; $hrs = $hrs+1){
						for($wid = 1; $wid < 7; $wid=$wid+1){
							if((substr($hours[$iter]['starttime'],0,2) == $hrs) && ($hours[$iter]['weekday'] == $wid)){
								echo "<div class='hour'>";
								echo "<input type='hidden' name='id' id='id' value='" . $hours[$iter]['id'] . "'/>";
								echo "<div class='checkbox' contenteditable='true'>";
								echo "<input type='radio' value='1' name='" . $hours[$iter]['id'] . "|1' class='css-checkbox' "; if($hours[$iter]['weekday'] == 1) echo "checked"; echo "/><label for='" . $hours[$iter]['id'] . "|1' class='css-label'>L</label>";
								echo "<input type='radio' value='2' name='" . $hours[$iter]['id'] . "|2' class='css-checkbox' "; if($hours[$iter]['weekday'] == 2) echo "checked"; echo "/><label for='" . $hours[$iter]['id'] . "|2' class='css-label'>M</label>";
								echo "<input type='radio' value='3' name='" . $hours[$iter]['id'] . "|3' class='css-checkbox' "; if($hours[$iter]['weekday'] == 3) echo "checked"; echo "/><label for='" . $hours[$iter]['id'] . "|3' class='css-label'>M</label>";
								echo "<input type='radio' value='4' name='" . $hours[$iter]['id'] . "|4' class='css-checkbox' "; if($hours[$iter]['weekday'] == 4) echo "checked"; echo "/><label for='" . $hours[$iter]['id'] . "|4' class='css-label'>G</label>";
								echo "<input type='radio' value='5' name='" . $hours[$iter]['id'] . "|5' class='css-checkbox' "; if($hours[$iter]['weekday'] == 5) echo "checked"; echo "/><label for='" . $hours[$iter]['id'] . "|5' class='css-label'>V</label>";
								echo "<input type='radio' value='6' name='" . $hours[$iter]['id'] . "|6' class='css-checkbox' "; if($hours[$iter]['weekday'] == 6) echo "checked"; echo "/><label for='" . $hours[$iter]['id'] . "|6' class='css-label'>S</label>";
								echo "</div>";
								echo "<div class='times'>";
								echo "<div class='time start'>";
								echo "da: <input contenteditable='true' size='4' type='text' name='starttime' id='" . $hours[$iter]['id'] . "|starttime' value='" . substr($hours[$iter]['starttime'],0,5) . "'/>";
								echo "</div>";
								echo "<div class='time end'>";
								echo "&nbsp;a: <input contenteditable='true' size='4' type='text' name='endtime' id='" . $hours[$iter]['id'] . "|endtime' value='" . substr($hours[$iter]['endtime'],0,5) . "'/>";
								echo "</div>";
								echo "</div>";
								echo "<div class='fullrow'>ins.: <select name='" . $hours[$iter]['id'] . "|leaderid'><option value='0' selected='selected'> libero </option>";
								foreach($instr as $in){
									echo "<option value=" . $in['id']. " "; 
									if($hours[$iter]['leaderid'] == $in['id']) 
										echo "selected='selected'"; 
									echo ">" . $in['lastname'] . "</option>";
								}
								echo "</select></div>";
								echo "<div class='fullrow'>ins. alt.: <select name='" . $hours[$iter]['id'] . "|leaderid_alt'><option value='0' selected='selected'> nessuno </option>";
								foreach($instr as $in){
									echo "<option contenteditable='true' value=" . $in['id']. " "; 
									if($hours[$iter]['leaderid_alt'] == $in['id']) 
										echo "selected='selected'"; 
									echo ">" . $in['lastname'] . "</option>";
								}
								echo "</select></div>";
								echo "<div class='fullrow'>tipo: <input contenteditable='true' size='15' type='text' name='tag' id='" . $hours[$iter]['id'] . "|tag' value='" . $hours[$iter]['tag'] . "'/></div>";
								echo "</div><!--hour-->";
								$iter++;
							} else {
								echo "<div class='hour empty'>&nbsp;</div>";
							} 
						}

					}
				?>

			</div>
		</div> <!--  site_container -->
  	</div> <!--  site_wrapper -->
</div>
</body>