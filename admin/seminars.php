<?php  session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8">
<title>Gestione seminari</title>
<?php  
	include("../admin/basic.php");
	include("../admin/class.db.php");
	include("../admin/class.login.php");
	include("./class.seminar.php");
	include("./class.utilities.php");
//	include("./class.SimpleICS.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login")	
?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon-precomposed" href="assets/favicon_t.png" />
	<link rel="shortcut icon" href="assets/favicon.png">
	<link rel=stylesheet type="text/css" href="../css/jquery-ui-1.8.20.custom.css">
	<link rel=stylesheet type="text/css" href="./css/adm.css">
	<style>
		.ui-datepicker-trigger{
    	border:none;
    	background:none;
		 }
		 .isHidden{display: none;}
		}
	</style>
	<script type='text/javascript' src='../js/jquery-1.7.2.min.js'></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.20.custom.min.js" ></script>   
    <script type="text/javascript">
        function toggle_visibility(divitem) {
           var ne = document.getElementById(divitem);
           if(ne.style.display == 'none')
           		ne.style.display = 'block';
           else
           		ne.style.display = 'none';
        }
        function text2date(day){
		  	var matches = /^(\d{2})[-\/](\d{2})[-\/](\d{4})$/.exec(day);
	    	var d = matches[1];
	    	var m = matches[2] - 1;
	    	var y = matches[3];
        	var composedDate = new Date(y, m, d);
        	return composedDate;
        }
        function date2text(d){
        	var strDate = ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +
    d.getFullYear();
        	return strDate;

        }
		function updateOrganizer() {
			if($('#organizerfk').val() != "NULL"){
				/*
			$('#phone').val($('#organizerid :selected').attr('optphone'));
			$('#email').val($('#organizerid :selected').attr('optemail'));
			$('#url').val($('#organizerid :selected').attr('opturl')); */
				$('#manualorganizer').addClass('isHidden');			
			} else {
				$('#manualorganizer').removeClass('isHidden');
			}
		}
		function updateLocation() {
			if($('#locationid').val() != "NULL"){
/*				$('#location').addClass('isHidden');
				$('#city').addClass('isHidden');
				$('#address').addClass('isHidden'); */
				$('#manuallocation').addClass('isHidden');					
/*				$('#city').val($('#locationid :selected').attr('city'));
*/				$('#address').val($('#locationid :selected').attr('address'));
			} else {
				$('#manuallocation').removeClass('isHidden');
/*				$('#location').removeClass('isHidden');
				$('#city').removeClass('isHidden');
				$('#address').removeClass('isHidden');*/
			}
		}
    </script>
  <script>
  $(function() {
    $( "#startdate" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      changeYear: true,
      numberOfMonths: 1,
      dateFormat: "dd-mm-yy",
      dayNamesMin: ['D', 'L', 'M', 'M', 'G', 'V', 'S'],
      onClose: function( selectedDate ) {
        $( "#enddate" ).datepicker( "option", "minDate", selectedDate );
        var day = text2date($( "#startdate" ).val());
        var wday = day.getDay();
        if(wday == 6){
        	var nextday = new Date(day.getTime() + (24 * 60 * 60 * 1000));
	        $( "#enddate" ).val(date2text(nextday));
	        $( "#startdate" ).datepicker( "option", "defaultDate", nextday );
        }
	    else if (wday == 7){
	        $( "#enddate" ).val(date2text(day));
	        $( "#startdate" ).datepicker( "option", "defaultDate", day );
	    }
      }
    });
    $( "#enddate" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      changeYear: true,
      dateFormat: "dd-mm-yy",
      dayNamesMin: ['D', 'L', 'M', 'M', 'G', 'V', 'S'],
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#startdate" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });  
  $(function() {
    $( "#expires" ).datepicker({
      changeMonth: true,
      dateFormat: "dd-mm-yy",
      dayNamesMin: ['D', 'L', 'M', 'M', 'G', 'V', 'S'],
      changeYear: true,
      defaultDate: "+1y"
    });
  });
  </script>
	<script type="text/javascript" >
		$(function() {
			$(".submit").click(function() {
				var parent = $(this).parent();
				var firstname = $("#firstname").val();
				var lastname = $("#lastname").val();
				var rank = $("#rank").val();
				var yudansha = $("#yudansha").is(":checked");
				var beginner = $("#beginner").is(":checked");
				var active = $("#active").is(":checked");
				var last_exam = $("#last_exam").val();
				var enrolled = $("#enrolled").val();
				var id = $("#id").val();

				var dataString = 'id='+ id + '&firstname='+ firstname + '&lastname=' + lastname + '&rank=' + rank + '&yudansha=' + yudansha;
				dataString = dataString + '&beginner=' + beginner + '&last_exam=' + last_exam + '&enrolled=' + enrolled + '&active=' + active;
				//alert(dataString);
			});
			$("#reset").click(function() {
				$("#newseminar")[0].reset();

			});
		});
	</script>


</head>
<body>
<!--?php
	if($isLogged == false) { 
		header("Location: index.php");
		exit;
	} 
?-->
<div class="site_wrapper">
 	<div class="sidebar">
 		<div class="sidebar__name">area riservata</div>
		<ul class="sidebar__link_list">
			<li class="sidebar__link_item"><a class="list-group-item" href="./index.php"><i class="fa fa-home"></i><br/>men&ugrave;</a></li>
			<li class="sidebar__link_item nomobile"></li>
			<li class="sidebar__link_item"><a class='list-group-item' href='./news.php'><i class='fa fa-newspaper-o'></i><span class='nomobile'><br/>news</span></a>
			<li class="sidebar__link_item"><a class='list-group-item' href='./shouts.php'><i class='fa fa-bullhorn'></i><span class='nomobile'><br/>strillo</span></a>
			<li class="sidebar__link_item"><a class='list-group-item' href='./orario.php'><i class='fa fa-clock-o'></i><span class='nomobile'><br/>orario</span></a>
			<li class="sidebar__link_item"><a class='list-group-item' href='./seminars.php'><i class='fa fa-calendar'></i><span class='nomobile'><br/>stage</span></a>
			<li class="sidebar__link_item"><a class='list-group-item' href='./instructors.php'><i class='fa fa-users'></i><span class='nomobile'><br/>maestri</span></a>
			<li class="sidebar__link_item"><a class='list-group-item' href='./locations.php'><i class='fa fa-university'></i><span class='nomobile'><br/>luoghi</span></a>
			<li class="sidebar__link_item"><a class='list-group-item' href='./presenze.php'><i class='fa fa-bar-chart-o'></i><span class='nomobile'><br/>presenze</span></a>
			<li class="sidebar__link_item nomobile"></li>
			<li class="sidebar__link_item"><a class="list-group-item" href="./form_action.php?action=logout"><i class="fa fa-sign-out"></i><br/>logout</a></li>
		</ul>
	</div><!-- sidebar -->
	<div class="site_container">
		<div class='actions aright'>
			<a title="elenco seminari" href="<?php echo $_SERVER['PHP_SELF']; ?>?act=list" alt="elenco"><i class="fa fa-align-justify"></i></a>&nbsp;
			<a title="nuovo seminario" href="<?php echo $_SERVER['PHP_SELF']; ?>?act=new" alt="nuovo"><i class="fa fa-plus"></i></a>
		</div>
	
<?php
	$db = new dbaccess();
	$sem = new seminar();

	if(isset($_REQUEST["act"])){
		switch($_REQUEST["act"]){
			case "new":
	?>
		<div id="seminardetail" class="details">	
			<h1>creazione nuovo seminario</h1>				
		<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=add" method="POST" id="newseminar" name="nuovo" onSubmit="return ValidateForm(this);">
		<ul class="meta">
			<li><label class=""><i class="fa fa-calendar"></i> dal giorno:</label><span><input name="startdate" type="text" class="inputField" maxlength="10" id="startdate" /></span> <span class="explanation">[gg-mm-aaaa]</span></li>
			<li><label class=""><i class="fa fa-clock-o"></i> ora:</label><span><input name="starttime" type="text" class="inputField" maxlength="5" id="starttime" /></span> <span class="explanation">[HH:MM]</span></li>
			<li><label class=""><i class="fa fa-calendar"></i> al giorno:</label><span><input name="enddate" type="text" class="inputField" maxlength="10" id="enddate" /></span> <span class="explanation">[gg-mm-aaaa]</span></li>
			<li><label class=""><i class="fa fa-clock-o"></i> ora:</label><span><input name="endtime" type="text" class="inputField" maxlength="5" id="endtime" /></span> <span class="explanation">[HH:MM]</span></li>
			<li><label class=""><i class="fa fa-university"></i> luogo:</label><span>
				<?php 
					echo $sem->getLocationDropdown($db); 
				?>
			</span>
			</li>
			<div id="manuallocation" class="isHidden">
				<li><label class=""></label><input name="location" type="text" class="inputField" maxlength="200" id="location" /></span> <span class="explanation">(es. Aikikai Milano - Dojo Fujimoto)</span></li>
				<li><label class=""></label><span><input name="shortcity" type="text" class="inputField" maxlength="200" id="shortcity" /></span> <span class="explanation">(es. Milano)</span></li>
				<li><label class=""></label><span><input name="address" type="text" class="inputField" maxlength="200" rows="2" id="address" /></span> <span class="explanation">(es. via Lulli, 30)</span></li>
				<li><label class=""></label><span><input name="city" type="text" class="inputField" maxlength="200" id="city" /></span> <span class="explanation">(es. 20131 Milano (MI))</span></li>
			</div>
			<li><label class=""><i class="fa fa-volume-up"></i> titolo:</label><span><textarea name="shortdescription" class="inputField" cols="31" rows="4"  maxlength="200"></textarea></span> <span class="explanation">(massimo 200 caratteri)</span></li>
			<li><label class=""><i class="fa fa-file-text-o"></i> descrizione estesa:</label><span><textarea name="description" class="inputField" cols="31" rows="6"  maxlength="400"></textarea></span> <span class="explanation">(massimo 400 caratteri)</span></li>
			<li><label class=""><i class="fa fa-group"></i> diretto da:</label><span>
				<?php
					echo $sem->getStageInstructorsDropdown($db,1,NULL); echo "<br/>";
					echo $sem->getStageInstructorsDropdown($db,2,NULL); echo "<br/>";
					echo $sem->getStageInstructorsDropdown($db,3,NULL); echo "<br/>";
				?>
			</span> <span class="explanation">i nomi verranno visualizzati con l'ordine indicato</span></li>
			<li><label class=""><i class="fa fa-flag-o"></i> tipo di seminario:</label><span>
				<?php 
					echo $sem->getTypeDropdown($db,NULL); 
				?>				
				</span> <span class="explanation"></span></li>
			<li><label class=""><i class="fa fa-volume-up"></i> organizzato da:</label><span>
				<?php 
					echo $sem->getOrganizerDropdown($db,NULL); 
				?>			
				</span></li>	
			<div id="manualorganizer" class="isHidden">
			<li><label class=""></label><input name="organizer" type="text" class="inputField" maxlength="200" id="organizer" /></span> <span class="explanation">(massimo 200 caratteri)</span></li>
			<li><label class=""><i class="fa fa-phone"></i> telefono:</label><span><input name="phone" type="text" class="inputField" maxlength="15" id="phone" /></span> <span class="explanation"></span></li>
			<li><label class=""><i class="fa fa-envelope"></i> email:</label><span><input name="email" type="email" class="inputField" maxlength="30" id="email" /></span> <span class="explanation"></span></li>
			<li><label class=""><i class="fa fa-globe"></i> web:</label><span><input name="url" type="text" class="inputField" maxlength="100" id="url" /></span> <span class="explanation"></span></li>
			<li><label class=""><i class="fa fa-external-link"></i> link a pagina esterna:</label><span><input name="link" type="text" class="inputField" maxlength="100" id="link" /></span> <span class="explanation"></span></li>
			</div>
			<li><label class=""><i class="fa fa-file-pdf-o"></i> locandina (pdf):</label><span class='fileupload'><input name="pdf" type="file" class="inputField" maxlength="100" id="pdf" /></span> <span class="explanation">(file stampabile dimensione A4)</span></li>
			<li><label class=""><i class="fa fa-picture-o"></i> miniatura (png/jpg):</label><span class='fileupload'><input name="png" type="file" class="inputField" maxlength="100" id="png" /></span> <span class="explanation">(file immagine dimensione 150px &#735; 200px)</span></li>
			<li><label class=""><i class="fa fa-picture-o"></i> foto (png/jpg):</label><span class='fileupload'><input name="photo" type="file" class="inputField" maxlength="100" id="photo" /></span> <span class="explanation">(file immagine elenco stage 140px &#735; 100px)</span></li>
			<li><label class=""><i class="fa fa-flag"></i> tags:</label><span><input name="tags" type="text" class="inputField" maxlength="100" id="tags" /></span> <span class="explanation">(ad es. armi, yudansha, ...)</span></li>
			<li></li>
			<hr/>
			<li><label class=""><i class="fa fa-pencil-square-o"></i> note:</label><span><textarea name="notes" type="text" class="inputField" maxlength="500" cols="31" rows="4" id="notes"></textarea></span> <span class="explanation">(max 400 caratteri)</span></li>
			<li><label class=""><i class="fa fa-cogs"></i> orari:</label><span><textarea name="schedule" type="text" class="inputField" cols="31" rows="8" id="schedule"></textarea></span> <span class="explanation">(sab. 14:00 registrazione ...)</span></li>
			<hr/>
			<li></li>
			<li><label class=""><i class="fa fa-hourglass-end"></i> visibile fino al:</label><span><input name="expires" type="text" class="inputField" maxlength="10" id="expires" value="00-00-0000"/></span> <span class="explanation">(data dopo la quale non comparir&agrave; sul sito, 00-00-0000 non scade mai)</span></li>
		</ul>
			<div class='buttons acenter'>
				<input type="submit" id="invia" value="aggiungi" class="submit"/>&nbsp;<input name="reset" id="reset" type="submit" value="ripulisci" class="submit">
			</div>
		</form>
	</div>
			<?php
				break;
			/* EDIT */
			case "edit":
			$sid = $_REQUEST["sid"];
			$s = new seminar();
			$s->get($db,$sid);
	?>
		<div id="seminardetail" class="wrapper">	
			<h3 class=''>aggiorna seminario</h3>				
		<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=upd" method="POST" id="editseminar" name="update" onSubmit="return ValidateForm(this);">
			<input name="id" type="hidden" value="<?php echo $s->id?>">
		<ul class="meta">
			<li><label class=""><i class="fa fa-calendar"></i> dal giorno:</label><span><input name="date" type="text" class="inputField" maxlength="10" id="startdate" value="<?php echo $db->db_to_date($s->fromdate); ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='label'>al:</span>&nbsp;<input name="date" type="text" class="inputField" maxlength="10" id="enddate" value="<?php echo $db->db_to_date($s->todate); ?>"/></span> <span class="explanation">[gg-mm-aaaa]</span> </li>
			<li><label class=""><i class="fa fa-university"></i> luogo:</label><span>
				<?php 
					echo $sem->getLocationDropdown($db,$s->locationfk); 
				?>
				<span class='label'>oppure</span> <input name="location" type="text" class="inputField" maxlength="200" id="location" value="<?php if($s->locationfk == 0) echo $s->location; ?>"/></span> <span class="explanation">(es. Aikikai Milano - Dojo Fujimoto)</span></li>
			<li><label class=""></label><span><input name="city" type="text" class="inputField" maxlength="200" id="city" value="<?php echo $s->city; ?>"/></span> <span class="explanation">(es. Milano)</span></li>
			<li><label class=""></label><span><input name="address" type="text" class="inputField" maxlength="200" rows="2" id="address" value="<?php echo $s->address; ?>"/></span> <span class="explanation">(es. via Lulli, 30)</span></li>
			<li><label class=""><i class="fa fa-volume-up"></i> descrizione sintetica:</label><span><textarea name="shortdescription" class="inputField" cols="40" rows="3"  maxlength="200"><?php echo $s->title; ?></textarea></span> <span class="explanation">(massimo 200 caratteri)</span></li>
			<li><label class=""><i class="fa fa-file-text-o"></i> descrizione estesa:</label><span><textarea name="description" class="inputField" cols="40" rows="3"  maxlength="400"><?php echo $s->description; ?></textarea></span> <span class="explanation">(massimo 400 caratteri)</span></li>
			<li><label class=""><i class="fa fa-group"></i> diretto da:</label><span>
				<?php
					echo $sem->getStageInstructorsDropdown($db,1,$s->instructors[0]['id']); echo "<br/>";
					echo $sem->getStageInstructorsDropdown($db,2,$s->instructors[1]['id']); echo "<br/>";
					echo $sem->getStageInstructorsDropdown($db,3,$s->instructors[2]['id']); echo "<br/>";
				?>
			</span> <span class="explanation">i nomi verranno visualizzati con l'ordine indicato</span></li>
			<li><label class=""><i class="fa fa-flag-o"></i> tipo di seminario:</label><span>
				<?php 
					echo $sem->getTypeDropdown($db,$s->seminartype); 
				?>				
				</span> <span class="explanation"></span></li>
			<li><label class=""><i class="fa fa-volume-up"></i> organizzato da:</label><span>
				<?php 
					echo $sem->getOrganizerDropdown($db,$organizerid); 
				?>				
			<span class='label'>oppure</span> <input name="organizer" type="text" class="inputField" maxlength="200" id="organizer" value="<?php if($s->organizerid == 0) echo $s->organizer; ?>"/></span> <span class="explanation">(massimo 200 caratteri)</span></li>
			<li><label class=""><i class="fa fa-phone"></i> telefono:</label><span><input name="phone" type="text" class="inputField" maxlength="15" id="phone" value="<?php echo $s->phone; ?>"/></span> <span class="explanation"></span></li>
			<li><label class=""><i class="fa fa-envelope"></i> email:</label><span><input name="email" type="email" class="inputField" maxlength="30" id="email" value="<?php echo $s->email; ?>"/></span> <span class="explanation"></span></li>
			<li><label class=""><i class="fa fa-globe"></i> web:</label><span><input name="url" type="text" class="inputField" maxlength="100" id="url" value="<?php echo $s->url; ?>"/></span> <span class="explanation"></span></li>
			<li><label class=""><i class="fa fa-external-link"></i> link a pagina esterna:</label><span><input name="link" type="text" class="inputField" maxlength="100" id="link" value="<?php echo $s->pagelink; ?>"/></span> <span class="explanation"></span></li>
			<li></li>
			<li><label class=""><i class="fa fa-file-pdf-o"></i> locandina attuale (pdf):</label><span><a href="<?php echo $uploadurl . $s->pdf; ?>"><?php echo $s->pdf; ?></a></span> <span class="explanation">(file stampabile dimensione A4)</span></li>
			<li><label class=""><i class="fa fa-picture-o"></i> miniatura attuale (png):</label><span><a href="<?php echo $uploadurl . $s->image; ?>"><?php echo $s->image; ?></a></span> <span class="explanation">(file immagine dimensione 150px*200px)</span></li>
			<hr/>
			<li><label class=""><i class="fa fa-file-pdf-o"></i> sostituisci locandina (pdf):</label><span><input name="pdf" type="file" class="inputField" maxlength="100" id="pdf" /></span> <span class="explanation">(file stampabile dimensione A4)</span></li>
			<li><label class=""><i class="fa fa-picture-o"></i> sostituisci miniatura (png):</label><span><input name="png" type="file" class="inputField" maxlength="100" id="png" /></span> <span class="explanation">(file immagine dimensione 150px*200px)</span></li>
			<li><label class=""><i class="fa fa-flag"></i> tags:</label><span><input name="tags" type="text" class="inputField" maxlength="100" id="tags" value="<?php echo $s->tags; ?>"/></span> <span class="explanation">(ad es. armi, yudansha, ...)</span></li>
			<li></li>
			<hr/>
			<li><label class=""><i class="fa fa-pencil-square-o"></i> note:</label><span><textarea name="notes" type="text" class="inputField" maxlength="500" cols="40" rows="3" id="notes"><?php echo $s->notes; ?></textarea></span> <span class="explanation">(max 400 caratteri)</span></li>
			<li><label class=""><i class="fa fa-cogs"></i> orari:</label><span><textarea name="schedule" type="text" class="inputField" cols="40" rows="5" id="schedule"><?php echo $s->schedule; ?></textarea></span> <span class="explanation">(sab. 14:00 registrazione ...)</span></li>
			<hr/>
			<li></li>
			<li><label class=""><i class="fa fa-hourglass-end"></i> visibile fino al:</label><span><input name="expires" type="text" class="inputField" maxlength="10" id="expires" value="<?php echo $db->db_to_date($s->expires); ?>"/></span> <span class="explanation">(data dopo la quale non comparir&agrave; sul sito)</span></li>
		</ul>
			<div class='buttons acenter'>
				<input type="submit" id="invia" value="aggiungi" class="submit"/>&nbsp;<input name="reset" id="reset" type="submit" value="ripulisci" class="submit">
			</div>
		</form>
		</div>
			<?php
				break;
					case "add":
					/* do the insertion */
					$ns = new seminar();
					$ns->fromdate = $db->date_to_db($_POST["startdate"]);
					$ns->fromtime = $_POST["starttime"] . ":00";
			  		$ns->shortdate = date("Ymd", strtotime($ns->fromdate));
					$ns->dtstart = date("Ymd", strtotime($ns->fromdate)) . "T" . str_replace(":", "", $ns->fromtime) . "Z";
					$ns->todate = $db->date_to_db($_POST["enddate"]);
					$ns->totime = $_POST["endtime"] . ":00";
			  		$ns->dtend = date("Ymd", strtotime($ns->todate)) . "T" . str_replace(":", "", $ns->totime) . "Z";
					$ns->title = convertCRBR($_POST["shortdescription"]);		
					$ns->description = convertCRBR($_POST["description"]);		
					$ns->locationfk = $_POST["locationid"];
					if($_POST["locationid"] === NULL){
						$ns->location = $_POST["location"];
						$ns->shortcity = convertCRBR($_POST["shortcity"]);
						$ns->address = convertCRBR($_POST["address"]);
						$ns->city = convertCRBR($_POST["city"]);
					} else {
			    		$loc = $ns->getLocation($db, $ns->locationfk);
						$ns->location = $loc[0]['name'];
						$ns->address = $loc[0]['address'];
						$ns->city = $loc[0]['city'];
						$ns->shortcity =$loc[0]['shortcity'];
					    $ns->long = $loc[0]['longitude'];
					    $ns->lat = $loc[0]['latitude'];						
					}
					$ns->seminartype = $_POST["seminartype"];
					if(!($_POST["seminarinstructor1"]===NULL))
						$ns->instructors[0]['id'] = $_POST["seminarinstructor1"];
					if(!($_POST["seminarinstructor2"]===NULL))
						$ns->instructors[1]['id'] = $_POST["seminarinstructor2"];
					if(!($_POST["seminarinstructor3"]===NULL))
						$ns->instructors[2]['id'] = $_POST["seminarinstructor3"];

					$ns->organizerfk = $_POST["organizerid"];
					if($_POST["organizerid"] === NULL){
						$ns->organizer = $_POST["organizer"];
						$ns->phone = $_POST["phone"];
						$ns->email = $_POST["email"];
						$ns->url = $_POST["url"];
					}
					$ns->pagelink = $_POST["link"];
					$ns->tags = $_POST["tags"];
					$ns->pdf =	$_FILES['pdf']['name'];
					$ns->image =	$_FILES['png']['name'];
					$ns->photo =	$_FILES['photo']['name'];
					$ns->notes	= convertCRBR($_POST["notes"]);
					$ns->schedule	= convertCRBR($_POST["schedule"]);
					$ns->expires	= $db->date_to_db($_POST["expires"]);
					//$ns->setGCal();

					/**/
					if($ns->locationfk){
						$ns->location = NULL;
						$ns->address = NULL;
						$ns->city = NULL;
						$ns->shortcity = NULL;						
					}
					
					$ris =  $ns->add($db);

					if ($ns->pdf != ""){
						$srcfile = $_FILES['pdf']['tmp_name'];
						$dstfile =  $uploadpath . $_FILES['pdf']['name'];
						if (!move_uploaded_file($srcfile, $dstfile)) {
       						echo('locandina non caricata!');
    					}
					}
					if ($ns->image != ""){
						$srcfile = $_FILES['png']['tmp_name'];
						$dstfile =  $uploadpath . $_FILES['png']['name'];
						if (!move_uploaded_file($srcfile, $dstfile)) {
       						echo('miniatura non caricata!');
    					}
					}
					if ($ns->photo != ""){
						$srcfile = $_FILES['photo']['tmp_name'];
						$dstfile =  $uploadpath . $_FILES['photo']['name'];
						if (!move_uploaded_file($srcfile, $dstfile)) {
       						echo('foto per elenco seminari non caricata!');
    					}
					}
					$srcfile = $ns->shortdate . "_" . $ns->instructortag . ".ics";
					$dstfile =  $uploadpath . $srcfile;
					$ns->createICS();
					if (!move_uploaded_file($srcfile, $dstfile)) {
   						echo('file ICS non creato!');
					}
					break;
				case "update":
					/* do the update */
					$ns = new seminar();
					$us->fromdate = $db->date_to_db($_POST["startdate"]);
					$us->fromtime = $_POST["starttime"] . ":00";
			  		$us->shortdate = date("Ymd", strtotime($us->fromdate));
					$us->dtstart = date("Ymd", strtotime($us->fromdate)) . "T" . str_replace(":", "", $us->fromtime) . "Z";
					$us->todate = $db->date_to_db($_POST["enddate"]);
					$us->totime = $_POST["endtime"] . ":00";
			  		$us->dtend = date("Ymd", strtotime($us->todate)) . "T" . str_replace(":", "", $us->totime) . "Z";
					$us->title = convertCRBR($_POST["shortdescription"]);		
					$us->description = convertCRBR($_POST["description"]);		
					$us->locationfk = $_POST["locationid"];
					if($_POST["locationid"] === NULL){
						$us->location = $_POST["location"];
						$us->shortcity = convertCRBR($_POST["shortcity"]);
						$us->address = convertCRBR($_POST["address"]);
						$us->city = convertCRBR($_POST["city"]);
					} else {
			    		$loc = $us->getLocation($db, $us->locationfk);
						$us->location = $loc[0]['name'];
						$us->address = $loc[0]['address'];
						$us->city = $loc[0]['city'];
						$us->shortcity =$loc[0]['shortcity'];
					    $us->long = $loc[0]['longitude'];
					    $us->lat = $loc[0]['latitude'];						
					}
					$us->seminartype = $_POST["seminartype"];
					if(!($_POST["seminarinstructor1"]===NULL))
						$us->instructors[0]['id'] = $_POST["seminarinstructor1"];
					if(!($_POST["seminarinstructor2"]===NULL))
						$us->instructors[1]['id'] = $_POST["seminarinstructor2"];
					if(!($_POST["seminarinstructor3"]===NULL))
						$us->instructors[2]['id'] = $_POST["seminarinstructor3"];

					$us->organizerfk = $_POST["organizerid"];
					if($_POST["organizerid"] === NULL){
						$us->organizer = $_POST["organizer"];
						$us->phone = $_POST["phone"];
						$us->email = $_POST["email"];
						$us->url = $_POST["url"];
					}
					$us->pagelink = $_POST["link"];
					$us->tags = $_POST["tags"];
					$us->pdf =	$_FILES['pdf']['name'];
					$us->image =	$_FILES['png']['name'];
					$us->photo =	$_FILES['photo']['name'];
					$us->notes	= convertCRBR($_POST["notes"]);
					$us->schedule	= convertCRBR($_POST["schedule"]);
					$us->expires	= $db->date_to_db($_POST["expires"]);
					//$us->setGCal();

					/**/
					if($us->locationfk){
						$us->location = NULL;
						$us->address = NULL;
						$us->city = NULL;
						$us->shortcity = NULL;						
					}
					
					$ris = $us->update($db);

					if ($us->pdf != ""){
						$srcfile = $_FILES['pdf']['tmp_name'];
						$dstfile =  $uploadpath . $_FILES['pdf']['name'];
						if (!move_uploaded_file($srcfile, $dstfile)) {
       						echo('locandina non caricata!');
    					}
					}
					if ($us->image != ""){
						$srcfile = $_FILES['png']['tmp_name'];
						$dstfile =  $uploadpath . $_FILES['png']['name'];
						if (!move_uploaded_file($srcfile, $dstfile)) {
       						echo('miniatura non caricata!');
    					}
					}
					if ($us->photo != ""){
						$srcfile = $_FILES['photo']['tmp_name'];
						$dstfile =  $uploadpath . $_FILES['photo']['name'];
						if (!move_uploaded_file($srcfile, $dstfile)) {
       						echo('foto per elenco seminari non caricata!');
    					}
					}
					$srcfile = str_replace("-", "", $us->fromdate) . ".ics";
					$dstfile =  $uploadpath . $srcfile;
					$us->createICS();
					if (!move_uploaded_file($srcfile, $dstfile)) {
   						echo('file ICS non creato!');
					}
					break;
				case "del":
					$ds = new seminar();
					$sid = $_REQUEST["sid"];
					$ds->id = $sid;
					$ds->del($db);
					$ds->clear();
					echo $ds->id;
					$ds->get($db,$sid);
					if($ds->id === NULL)
						echo "<span class='adm_message'>Seminario eliminato</span>";
					else
						echo "<span class='adm_message'>Seminario " . $ds->id . " ancora esistente</span>";
					break;
				case "list": /* list */
					$all = new seminar();
					?>
					<div id="seminardetail" class="details">	
						<h1>elenco seminari</h1>				
						<?php
							$out = $all->adminStageList($db,$_SERVER['PHP_SELF']);
							echo $out;
						?>
					</div>
					<?php
				}	// fine switch
			} // fine if
	?>
	</div><!-- wrapper -->
	<!--div id="footer">
		<?php echo "uploaddir: ". $uploaddir . "<br/>" . "uploadpath: " . $uploadpath; ?>		
	</div-->	
</div>
</body>
</html>