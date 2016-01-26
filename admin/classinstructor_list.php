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

    $db = new dbaccess();
    $ci = new classinstructor();
    $json = $ci->get($db);

	$list = json_decode($json, TRUE);

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
/*		
		$('a.update').click(function(e) {  
			e.preventDefault();
			var clickedID = this.id.split(':');
			var recid = clickedID[1];
			$("#id-edit").html(recid);
			$('#editinstructor').show();
			$("#id-edit").val() = ;
			$("#fullname-edit").val() = ;
			$("#lastname-edit").val() = ;
			$("#rank-edit").val() = ;
			$("#shortbio-edit").val() = ;
		});
*/
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
    	$("td[contenteditable=true]").blur(function(){
	       	var field_userid = $(this).attr("id") ;
        	var value = $(this).text();
        	$.post('classinstructor_list_upd.php' , field_userid + "=" + value, function(data){
				
        	});
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
			<div class="page__title">Lista degli insegnanti</div>
			<div class="admin_table">
		        	<p class="acenter"><a class="addnew" href="./classinstructor_add.php">Aggiungi insegnante <i class='fa fa-user-plus'></i></a><p>
					<p class="hiddenspace" style="display:none">&nbsp;</p>
					<table class="admin__table" id="ajaxtable">
						<thead>
						  <tr>
							<th>nome completo</th>
							<th>cognome</th>
							<th>grado</th>
							<!--th>aggiorna</th--> 
							<th>elimina</th>
						  </tr>
						</thead>
						<tbody>
							<?php
						  		$alt = true;
								foreach ($list AS $d){
									echo "<tr id='" . $d['id'] . "' ";
									if ($alt) echo "class='odd'";
									echo ">";
									echo "<td id=fullname:" . $d['id'] . " contenteditable='true'>" . $d['fullname'] . "</td>";
									echo "<td id=lastname:" . $d['id'] . " contenteditable='true'>" . $d['lastname'] . "</td>";
									echo "<td class='center' id=rank:" . $d['id'] . " contenteditable='true'>" . $d['rank'] . "</td>";
/*									echo "<td class='center'><a href='#' class='update' id='update:" . $d['id'] . "'><i id='instructoredit' class='fa fa-pencil-square-o'></i></a></td>"; */
									echo "<td class='center'><a href='#' class='delete' id='delete:" . $d['id'] . "'><i class='fa fa-trash fa-fw'></i></a></td>";
									echo "</tr>";
									$alt = !$alt;
								}
							?>
						</tbody>
					</table>		
					<p class="acenter"><a class="addnew" href="./classinstructor_add.php">Aggiungi insegnante <i class='fa fa-user-plus'></i></a><p>
					<p class="hiddenspace" style="display:none">&nbsp;</p>
					<div id="newinstructor" style="display:none">
						<hr/>
							<table class="admin__table ui-state-default" id="addtable">
								<thead>
								  <tr>
									<th>nome completo</th>
									<th>cognome</th>
									<th>grado</th>
								  </tr>
								</thead>
								<tbody>
									<tr>
							            <td><input size="30" type='text' name='fullname' id='fullname-add'/></td>
							            <td><input size="18" type='text' name='lastname' id='lastname-add' /></td>
							            <td><input size="4" type='text' name='rank' id='rank-add' value='_&deg; dan'/></td>
									</tr>
						        </tr>
						        <tr>
						            <td colspan="3">Descrizione</td>
						        </tr>
						        <tr>
						            <td colspan="3"><textarea rows="20" cols="50" name='shortbio-add' id='shortbio'></textarea></td>
						        </tr>
						        <tr>
						        	<td class='center' colspan="3">
					                	 <a href='#' class='submit btn'>Salva <i class='fa fa-floppy-o'></i></a>
					                	<span class="error" style="display:none">Attenzione ai dati inseriti</span>
					                </td>
						        </tr>
						    </tbody>
						    </table>
						<hr/>				
					</div>
					<!--div id="editinstructor" style="display:none">
						<hr/>
							<table class="admin__table ui-state-default" id="addtable">
								<thead>
								  <tr>
									<th>nome completo</th>
									<th>cognome</th>
									<th>grado</th>
								  </tr>
								</thead>
								<tbody>
									<tr>
							            <td><input size="30" type='text' name='fullname' id='fullname-edit'/></td>
							            <td><input size="18" type='text' name='lastname' id='lastname-edit' /></td>
							            <td><input size="4" type='text' name='rank' id='rank-edit' value='_&deg; dan'/></td>
									</tr>
						        </tr>
						        <tr>
						            <td colspan="3">Descrizione</td>
						        </tr>
						        <tr>
						            <td colspan="3"><textarea rows="20" cols="50" name='shortbio-edit' id='shortbio'></textarea></td>
						        </tr>
						        <tr>
						        	<td class='center' colspan="3">
						        		 <input size="4" type='text' name='id-edit' id='id-edit' value=''/>
					                	 <a href='#' class='submit btn'>Salva <i class='fa fa-floppy-o'></i></a>
					                	<span class="error" style="display:none">Le modifiche non sono state salvate</span>
					                </td>
						        </tr>
						    </tbody>
						    </table>
						<hr/>				
					</div-->
			</div>
		</div> <!--  site_container -->
  	</div> <!--  site_wrapper -->
</div>
</body>