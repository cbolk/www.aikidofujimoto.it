<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="it">
  <head>
<?php  
  include("./basic.php");
  include("./class.db.php");
  include("./class.login.php");
  include("./class.aikidoka.php");
  $log = new logmein();
  $log->encrypt = true; //set encryption 
  $isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login"); 

	if(isset($_GET["aid"]))
		$aid = $_GET["aid"];
	else
		$aid = -1;

	$dbconn = new dbaccess();
	$dbconn->dbconnect();

	$ai = new aikidoka();
    $p = $ai->get($dbconn, $aid);

?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="admin website">
    <meta name="author" content="cbolk">
    <link rel="icon" href="../assets/favicon.png">

    <title><?php echo $p->firstname . " " . $p->lastname; ?></title>

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

<script type="text/javascript">
  $(function () {
    $('#enrolled').datetimepicker({
      format: "DD-MM-YYYY",
      locale: "it",
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
      }
    });
    $('#lastexam').datetimepicker({
      format: "DD-MM-YYYY",
      locale: "it",
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
      }
    });
    $(':checkbox').checkboxpicker();
  });
</script>


<script type="text/javascript" >
  $(function() {
    $("#submit").click(function() {
      var passed = true;
      var enrolled = $('#enrolled').val();
      var firstname = $("#firstname").val();
      var lastname = $("#lastname").val();
      var rank = $("#rank").val();
      if(enrolled === "" || firstname === "" || lastname === "" || rank === "") passed = false;
      
      if(!passed){
        alert("campi obbligatori non completati ... impossibile proseguire!");
        return;
      }

      var form = $('form')[0]; 
      var formData = new FormData(form);


      $.ajax({
        type: 'post',
        url: 'adm_aikidoka_update.php',
        data: formData, 
        processData: false,
            contentType: false,
            beforeSend: function() {
          	//alert(formData);
        },
        success: function(response){
          var aid = response;
          var dest = "adm_aikidoka_list.php"
          if(aid != "")
            dest = dest + "#" + aid; 
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
          <h1 class="page-header">
<?php
		 echo $p->firstname . " " . $p->lastname;
?>
          </h1>
          <div class="row">
            <div class=" actions pull-right">
              <a href="./adm_aikidoka_list.php" alt="elenco iscritti"><i class="fa fa-bars"></i> elenco</a>
            </div>
          </div>

    <div class="panel panel-default">
          <div class="panel-heading">
        <div class="panel-title">
                  <i class="fa fa-user-plus pull-right"></i>
                   <i class="fa fa-asterisk asterisc"></i> <small>campi obbligatori</small>
                </div>
            </div>
            <div class="panel-body">
              <form class="form form-vertical" enctype="multipart/form-data" method="post" name="semform" id="semform"> 
                    <div class="row"> 
                      <div class="control-group col-md-6" >
                        <label>nome <i class="fa fa-asterisk asterisc"></i></label>
                          <div class="controls">
                              <input class="form-control" name="firstname" id="firstname" type="text" maxlength="200" value="<?php echo $p->firstname; ?>" /> 
                              <input class="form-control" name="id" id="id" type="hidden" maxlength="200" value="<?php echo $p->id; ?>" />
                          </div>
                      </div> 
                       <div class="control-group col-md-6" >
                        <label>cognome  <i class="fa fa-asterisk asterisc"></i></label>
                          <div class="controls">
                              <input class="form-control" name="lastname" id="lastname" type="text" maxlength="200" value="<?php echo $p->lastname; ?>"/> 
                          </div>
                      </div> 
                  </div>
                    <hr>
                <div class="row">         
                  <div class="control-group col-sm-6">
                    <label>grado </label>
                    <div class="form-group">
                      <div class="controls">
                          <select class='form-control' name='rank' id='rank'>       
				                <option <?php if($p->rank=='') echo "selected"; ?> value='NULL'></option>
				                <option <?php if($p->rank=='mu') echo "selected"; ?> value='mu'>mu</option>
				                <option <?php if($p->rank=='rokudan') echo "selected"; ?> value='rokudan'>rokudan</option>
				                <option <?php if($p->rank=='godan') echo "selected"; ?> value='godan'>godan</option>
				                <option <?php if($p->rank=='yondan') echo "selected"; ?> value='yondan'>yondan</option>
				                <option <?php if($p->rank=='sandan') echo "selected"; ?> value='sandan'>sandan</option>
				                <option <?php if($p->rank=='nidan') echo "selected"; ?> value='nidan'>nidan</option>
				                <option <?php if($p->rank=='shodan') echo "selected"; ?> value='shodan'>shodan</option>
				                <option <?php if($p->rank=='1 kyu') echo "selected"; ?> value='1:kyu'>1 kyu</option>
				                <option <?php if($p->rank=='2 kyu') echo "selected"; ?> value='2:kyu'>2 kyu</option>
				                <option <?php if($p->rank=='3 kyu') echo "selected"; ?> value='3:kyu'>3 kyu</option>
				                <option <?php if($p->rank=='4 kyu') echo "selected"; ?> value='4:kyu'>4 kyu</option>
				                <option <?php if($p->rank=='5 kyu') echo "selected"; ?> value='5:kyu'>5 kyu</option>
				                <option <?php if($p->rank=='6 kyu') echo "selected"; ?> value='6:kyu'>6 kyu</option>
				                <option <?php if($p->rank=='7 kyu') echo "selected"; ?> value='7:kyu'>7 kyu</option>
				                <option <?php if($p->rank=='8 kyu') echo "selected"; ?> value='8:kyu'>8 kyu</option>
				                <option  value='9:kyu'>9 kyu</option>
				                <option  value='10:kyu'>10 kyu</option>
                			</select>
                      </div>
                    </div>
                  </div>      

                  <div class="control-group col-xs-6">
                      <label>data ultimo esame (gg/mm/aaaa)</label>
                      <div class="form-group">
                        <div class='input-group date'>
                          <input type='text' class="form-control" name='lastexam' id='lastexam' value="<?php echo $dbconn->db_to_date($p->lastexam); ?>"/>
                          <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                      </div>
                  </div>      
                </div>
              <hr>

                    <div class="row"> 
                      <div class="control-group col-md-3" >
                        <label>principiante </label>
                          <div class="controls">
                              <input class="form-control" name="beginner" id="beginner" type="checkbox" data-off-title="NO" data-on-title="SI" data-on-class="btn-info" data-off-class="btn-default" <?php if($p->beginner) echo "checked"; ?> /> 
                          </div>
                      </div> 
                       <div class="control-group col-md-3" >
                        <label>ragazzi / bambini</label>
                          <div class="controls">
                              <input class="form-control" name="youngster" id="youngster" type="checkbox"  data-off-title="NO" data-on-title="SI" data-off-class="btn-default" data-on-class="btn-warning" <?php if($p->youngster) echo "checked"; ?> /> 
                          </div>
                      </div> 
                       <div class="control-group col-md-3" >
                        <label>yudansha</label>
                          <div class="controls">
                              <input class="form-control" name="yudansha" id="yudansha" type="checkbox" data-off-class="btn-default" data-on-class="btn-primary" data-off-title="NO" data-on-title="SI" <?php if($p->yudansha) echo "checked"; ?> /> 
                          </div>
                      </div> 
                       <div class="control-group col-md-3" >
                        <label>attivo</label>
                          <div class="controls">
                              <input class="form-control" name="active" id="active" type="checkbox" checked  data-off-title="NO" data-on-title="SI" <?php if($p->active) echo "checked"; ?> /> 
                          </div>
                      </div> 
                  </div>
                    <hr>
                <div class="row">         
                  <div class="control-group col-xs-6">
                      <label>data iscrizione (gg/mm/aaaa)  <i class="fa fa-asterisk asterisc"></i></label>
                      <div class="form-group">
                        <div class='input-group date'>
                          <input type='text' class="form-control" name='enrolled' id='enrolled' value="<?php echo $dbconn->db_to_date($p->enrolled); ?>"/>
                          <span class="input-group-addon"><span class="fa fa-calendar" ></span></span>
                        </div>
                      </div>
                  </div>      
                  <div class="control-group col-sm-6">
                    <label>&nbsp;</label>
                  </div>      
                </div>
                    <hr>

          <div class="control-group col-md-12">
                    <label><br/></label>
                        <div class="controls">
                          <center>
                          <input type="submit" value="aggiorna" id="submit" name="aggiorna" class="btn btn-primary">
                          <input type="submit" value="cancella" id="reset" name="abbandona" class="btn btn-primary">
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
