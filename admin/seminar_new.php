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
	<link rel=stylesheet type="text/css" href="../css/jquery-ui-1.8.20.custom.css">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/dashboard.css" rel="stylesheet">
	<link href="../css/fileinput.css" rel="stylesheet">
	<link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="../css/admin.css" rel=stylesheet>
	<style>
		 .isHidden{display: none;}
	</style>

<script type='text/javascript' src='//code.jquery.com/jquery-2.1.1.min.js'></script>
<script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.20.custom.min.js" ></script>   

<script type="text/javascript">
	$(function () {
		$('#startdate').datetimepicker({
			format: "DD-MM-YYYY",
			locale: "it",
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		});
		$('#starttime').datetimepicker({
			format: "LT",
			locale: "it",
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar"
			}
		});
		$('#enddate').datetimepicker({
			format: "DD-MM-YYYY",
			locale: "it",
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		});
		$('#endtime').datetimepicker({
			format: "LT",
			locale: "it",
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		});
		$('#expires').datetimepicker({
			format: "DD-MM-YYYY",
			locale: "it",
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		});
        $("#startdate").on("dp.change", function (e) {
            $('#enddate').data("DateTimePicker").minDate(e.date);
        });
        $("#enddate").on("dp.change", function (e) {
            $('#startdate').data("DateTimePicker").maxDate(e.date);
        });	
	});
</script>

<script type="text/javascript">
	$(document).on('ready', function() {
    	$("#photo").fileinput({showCaption: false});
    	$("#image").fileinput({showCaption: false});
    	$("#pdf").fileinput({showCaption: false});
	    $('[data-toggle="popover"]').popover();
	});
	function toggle_visibility(divitem) {
    	var ne = document.getElementById(divitem);
        if(ne.style.display == 'none')
        	ne.style.display = 'block';
        else
           	ne.style.display = 'none';
    }
         
	$(function() {
	  $('#locationid').on('change', function(){
		var selected = $(this).find("option:selected").val();
		if(selected != "NULL"){
			$('#manuallocation').addClass('isHidden');					
		} else {
			$('#manuallocation').removeClass('isHidden');
		}
		//alert(selected);
	  });
	  $('#organizerfk').on('change', function(){
		var selected = $(this).find("option:selected").val();
		if(selected != "NULL"){
			$('#manualorganizer').addClass('isHidden');					
		} else {
			$('#manualorganizer').removeClass('isHidden');
		}
		//alert(selected);
	  });
  
	});
</script>

<script type="text/javascript" >
	$(function() {
		$("#submit").click(function() {
			var passed = true;
			var startdate = $('#startdate').val();
			var enddate = $("#enddate").val();
			var title = $("#shortdescription").val();
			var seminartype = $("#seminartype").val();
			if(startdate === "" || enddate === "") passed = false;
//			if(startdate === enddate && endtime <= starttime) passed = false;
			if(title === "") passed = false;
			if(seminartype === "") passed = false;
			if($("#seminarinstructor1").val() === "NULL")
				passed = false;
			
			if(!passed){
				alert("campi obbligatori non completati ... impossibile proseguire!");
				return;
			}

			var form = $('form')[0]; 
			var formData = new FormData(form);


			$.ajax({
				type: 'post',
				url: 'seminar_add.php',
				data: formData, 
				processData: false,
       			contentType: false,
       			beforeSend: function() {
					//alert(formData);
				},
				success: function(response){
					var newID = response;
					var dest = "seminar_list.php"
					if(newID != "")
						dest = dest + "#" + newID; 
					location.href = dest;
				}
			});
			return false;
		});
		$("#reset").click(function() {
			$("#semform")[0].reset();

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
		<div class="panel panel-default">
        	<div class="panel-heading">
				<div class="panel-title">
                	<i class="glyphicon glyphicon-wrench pull-right"></i>
                	<h4>Nuovo seminario</h4>
                	<i class="fa fa-asterisk asterisc"></i> <small>campi obbligatori</small>
                </div>
            </div>
            <div class="panel-body">
            	<form class="form form-vertical" enctype="multipart/form-data" method="post" name="semform" id="semform"> 
            		<div class="row">         
	    				<div class="control-group col-sm-6">
		                   	<label>dal giorno (gg/mm/aaaa) <i class="fa fa-asterisk asterisc"></i></label>
	        				<div class="form-group">
	            				<div class='input-group date'>
	                				<input type='text' class="form-control" id='startdate' name='startdate'/>
	                				<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
	    					    </div>
					        </div>
	                    </div>      
						<div class="control-group col-sm-6">
	                    	<label>ora d'inizio (hh:mm)</label>
	       					<div class="form-group">
	           					<div class='input-group date'>
	               					<input type='text' class="form-control" name='starttime' id='starttime'/>
	               					<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
	   					        </div>
					        </div>
	                    </div>      
                    </div>
                    <hr>
					<div class="row">                 
						<div class="control-group col-xs-6">
	                    	<label>al giorno (gg/mm/aaaa) <i class="fa fa-asterisk asterisc"></i></label>
	    					<div class="form-group">
	        					<div class='input-group date'>
	            					<input type='text' class="form-control" name='enddate' id='enddate'/>
	            					<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
						        </div>
					        </div>
	                    </div>      
	                    
						<div class="control-group col-xs-6">
	                    	<label>ora di fine (hh:mm)</label>
	    					<div class="form-group">
	        					<div class='input-group date' >
	            					<input type='text' class="form-control" name='endtime' id='endtime'/>
	            					<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
						        </div>
					        </div>
	                    </div>   
	                </div>
                    <hr>

                    <div class="row"> 
	                    <div class="control-group col-md-12" >
		                    <label>titolo (max 400 car.) <i class="fa fa-asterisk asterisc"></i></label>
	                        <div class="controls">
	                          	<textarea class="form-control" id='shortdescription' name="shortdescription" maxlength="400">Seminario di aikido</textarea>
	                        </div>
	                    </div> 
	                </div>
	                <div class="row"> 
	                    <div class="control-group col-md-12" >
		                    <label>descrizione</label>
    	                    <div class="controls">
        	                  	<textarea class="form-control" name="description" id="description" maxlength="400"></textarea>
            	            </div>
                	    </div> 
                	</div>
                    <hr>
                    <div class="row">
	                    <div class="control-group col-xs-6">
		                    <label>diretto da <i class="fa fa-asterisk asterisc"></i></label>
	                        <div class="controls">
	                          	<select class='form-control seminardd' name='seminarinstructor1' id='seminarinstructor1'>				
								<?php
										echo $sem->getStageInstructorsOptions($db,$s->instructors[0]['id']); 
								?>				
								</select>
								<br/>
	                          	<select class='form-control seminardd' name='seminarinstructor2' id='seminarinstructor2'>				
								<?php
										echo $sem->getStageInstructorsOptions($db,$s->instructors[1]['id']); 
								?>				
								</select>
								<br/>
	                          	<select class='form-control seminardd' name='seminarinstructor3'  id='seminarinstructor3'>				
								<?php
										echo $sem->getStageInstructorsOptions($db,$s->instructors[2]['id']); 
								?>				
								</select>
							 <span class="explanation">i nomi verranno visualizzati con l'ordine indicato</span></li>
	                        </div>
	                    </div> 

	                    <div class="control-group col-xs-6">
		                    <label>tipo di seminario <i class="fa fa-asterisk asterisc"></i></label>
	                        <div class="controls">
	                          	<select class="form-control seminardd" name='seminartype'  id='seminartype'>				
	                          		<?php 
										echo $sem->getTypeOptions($db,$s->seminartype); 
									?>				
								</select>
	                        </div>
	                    </div> 
                    </div>
                    
                    <hr>

					<div class="row">
                    <div class="control-group col-xs-6">
	                    <label>luogo <i class="fa fa-asterisk asterisc"></i></label>
                        <div class="controls">
                        	<select class='form-control seminardd' name='locationid' id='locationid'>
							<?php
									echo $sem->getLocationOptions($db); 
							?>				
							</select>
                        </div>
                    </div> 

                    <div class="control-group col-xs-6  isHidden"  id="manuallocation">
	                    <label>&nbsp;</label>
                        <div class="controls">
                        	<input class="form-control" placeholder="luogo" name="location" id="location" type="text" maxlength="200"/>
							<input class="form-control" placeholder="citt&agrave;" name="shortcity" id="shortcity" type="text" maxlength="200" />
							<input class="form-control" placeholder="indirizzo" name="address" id="address" type="text" maxlength="200" />
							<input class="form-control" placeholder="CAP citt&agrave; (provincia)" name="city" id="city" type="text" maxlength="200" /> 
                        </div>
                    </div> 

                   
                    <div class="control-group col-xs-6">
	                    <label>organizzato da <i class="fa fa-asterisk asterisc"></i></label>
                        <div class="controls">
                        	<select class='form-control seminardd' name='organizerfk'>
							<?php
									echo $sem->getOrganizerOptions($db,NULL); 
							?>				
							</select>
                        </div>
                    </div> 

                    <div class="control-group col-xs-6 isHidden" id="manualorganizer">
	                    <label>&nbsp;</label>
                        <div class="controls">
                        	<input class="form-control" placeholder="associazione organizzatrice" name="organizer" id="organizer" type="text" maxlength="200" />
							<input class="form-control" placeholder="telefono" name="phone" id="phone" type="text" maxlength="200"/>
							<input class="form-control" placeholder="indirizzo email" name="email" id="email" type="text" maxlength="200"/> 
							<input class="form-control" placeholder="sito web" name="url" id="url" type="text" maxlength="200" /> 
                        </div>
                    </div> 

                    </div>
                    <hr>

                    <div class="row">
	                    <div class="control-group col-xs-6 " >
		                    <label>orario</label>
	                        <div class="controls">
	                          	<textarea class="form-control" name="schedule" id="schedule" maxlength="400" rows="6">sabato   ore 15:30 - 16:00 iscrizioni
sabato   ore 16:00 - 18:00 lezione
domenica ore 09:00 - 12:00 lezione
domenica ore 14:00 - 16:00 lezione</textarea>
	                        </div>
	                    </div> 

						<div class="control-group col-md-6" >
	                    	<label>tags</label>
	                    	<div class="controls" >
	                        	<input class="form-control" placeholder="tags" type="text" name="tags" id="tags">
	                        </div>
	                    </div>  

						<div class="control-group col-md-6">
	                    	<label>note</label>
	                    	<div class="controls" >
	                        	<input class="form-control" placeholder="Note e commenti" type="text" name="notes" id="notes">
	                        </div>
	                    </div> 
				</div>                    
                <hr>
                 <div class="row">
					<div class="control-group col-md-4">
                    	<label>locandina<br/>(pdf)</label>
		            	<input id="pdf" name="pdf" type="file" class="file-loading" uploadUrl='/<?php echo $uploaddir; ?>'>

                    </div>  
                    
					<div class="control-group col-md-4">
                    	<label>miniatura locandina<br/>(dim. max: 200px &times; 300px)</label>
                    	<input id="image" name="image" type="file" class="file-loading" uploadUrl='/<?php echo $uploaddir; ?>'>
                    </div>
                    
					<div class="control-group col-md-4">
                    	<label>immagine pagina seminari<br/>(dim. max: 140px &times; 100px)</label>
                    	<input id="photo" name="photo" type="file" class="file-loading" uploadUrl='/<?php echo $uploaddir; ?>'>
                    </div>

                    </div>
                    <hr>
 


					<div class="control-group col-xs-6">
                    	<label>data in cui non mostrare pi&ugrave; sul sito (gg/mm/aaaa)</label>
        					<div class="form-group">
            					<div class='input-group date' id='expires'>
                					<input type='text' class="form-control" name='expires'/>
                					<span class="input-group-addon">
                    					<span class="fa fa-calendar"></span>
		            			    </span>
    					        </div>
					        </div>
                    </div>      

					<div class="control-group col-md-12">
     	           		<label><br/></label>
                        <div class="controls">
                        	<center>
                        	<input type="submit" value="inserisci" id="submit" name="inserisci" class="btn btn-primary">
                       		<input type="submit" value="cancella" id="reset" name="cancella" class="btn btn-primary">
							</center>
                        </div>
                    </div>
                       
                </form>
            </div><!--/panel content-->
        </div><!--/panel-->

	</div><!-- main -->
	<div id="footer">
	<?php echo "i file verranno caricati nel folder: ". $uploaddir; ?>	
	</div>	
</div><!-- wrapper -->
</body>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.js"></script>
	<script src="../js/fileinput.js"></script>
	<script src="../js/moment-with-locales.js"></script>
	<script src="../js/bootstrap-datetimepicker.min.js"></script>
	<script src="../js/bootstrap-tags.min.js"></script>
</html>