<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="it">
  <head>
<?php  
  include("./basic.php");
  include("./class.db.php");
  include("./class.login.php");
  include("./class.instructor.php");
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

    <title>istruttore stage</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.20.custom.css">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">

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
    <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.20.custom.min.js" ></script>   


<script type="text/javascript" >
  $(function() {
    $("#submit").click(function() {
      var passed = true;
      var firstname = $("#firstname").val();
      var lastname = $("#lastname").val();
      var rank = $("#rank").val();
      var sorting = $('#sorting').val();
      if(firstname === "" || lastname === "" || rank === "") passed = false;
      
      if(!passed){
        alert("campi obbligatori non completati ... impossibile proseguire!");
        return;
      }

      var form = $('form')[0]; 
      var formData = new FormData(form);


      $.ajax({
        type: 'post',
        url: 'adm_instructor_add.php',
        data: formData, 
        processData: false,
            contentType: false,
            beforeSend: function() {
          	//alert(formData);
        },
        success: function(response){
          var newID = response;
          var dest = "adm_seminar_new.php"
          location.href = dest;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert("Status: " + textStatus); alert("Error: " + errorThrown); 
        }
      });
      return false;
    });
    $("#reset").click(function() {
      $("#semform")[0].reset();
      header("Location: adm_seminar_new.php");
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
  $db = new dbaccess();
  $elem = new instructor();
?>
          <h1 class="page-header">Nuovo istruttore di seminario</h1>
          <div class="row">
            <div class=" actions pull-right">
              <!--a href="./adm_instructor_list.php" alt="elenco istruttori"><i class="fa fa-bars"></i> elenco</a-->
            </div>
          </div>

    <div class="panel panel-default">
          <div class="panel-heading">
        <div class="panel-title">
                  <i class="fa fa-calendar-plus-o pull-right"></i>
                   <i class="fa fa-asterisk asterisc"></i> <small>campi obbligatori</small>
                </div>
            </div>
            <div class="panel-body">
              <form class="form form-vertical" enctype="multipart/form-data" method="post" name="semform" id="semform"> 
                    <div class="row"> 
                      <div class="control-group col-md-6" >
                        <label>nome <i class="fa fa-asterisk asterisc"></i></label>
                          <div class="controls">
                              <input class="form-control" name="firstname" id="firstname" type="text" maxlength="200" /> 
                          </div>
                      </div> 
                       <div class="control-group col-md-6" >
                        <label>cognome  <i class="fa fa-asterisk asterisc"></i></label>
                          <div class="controls">
                              <input class="form-control" name="lastname" id="lastname" type="text" maxlength="200" /> 
                          </div>
                      </div> 
                  </div>
                    <hr>
                <div class="row">         
                  <div class="control-group col-sm-6">
                    <label>grado <i class="fa fa-asterisk asterisc"></i></label>
                    <div class="form-group">
                      <div class="controls">
                        <select class='form-control' name='rank' id='rank'>       
                        <option  value='shichidan'>7&deg; dan Aikikai</option>
				                <option  value='rokudan'>6&deg; dan Aikikai</option>
				                <option  value='godan'>5&deg; dan Aikikai</option>
				                <option  value='yondan'>4&deg; dan Aikikai</option>
				                <option  value='sandan'>3&deg; dan Aikikai</option>
				                <option  value='nidan'>2&deg; dan Aikikai</option>
                			</select>
                      </div>
                    </div>
                  </div>     
                 <div class="control-group col-sm-6">
                    <!--label>ordine di presentazione</label-->
                    <div class="form-group">
                      <div class="controls">
                        <input class="form-control" name="sorting" id="sorting" type="hidden" value="10" />
                      </div>
                    </div>
                  </div>     
                </div>
                <hr>

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
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="./js/jquery-1.7.2.min.js"><\/script>')</script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/moment-with-locales.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/bootstrap-checkbox.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </body>
</html>
