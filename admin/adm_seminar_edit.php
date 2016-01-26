<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="it">
  <head>
<?php  
  include("./basic.php");
  include("./class.db.php");
  include("./class.login.php");
  include("./class.seminar.php");
  include("./class.utilities.php");
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

    <title>seminari</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.20.custom.css">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
    <link href="../css/dashboardAF.css" rel="stylesheet">
    <link href="../css/fileinput.css" rel="stylesheet">

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
//      if(startdate === enddate && endtime <= starttime) passed = false;
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
        url: 'adm_seminar_update.php',
        data: formData, 
        processData: false,
            contentType: false,
            beforeSend: function() {
          //alert(formData);
        },
        success: function(response){
          var newID = response;
          var dest = "adm_seminar_list.php"
          if(newID != "")
            dest = dest + "#" + newID; 
          location.href = dest;
        }
      });
      return false;
    });
    $("#reset").click(function() {
       location.href = 'adm_seminar_list.php';

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
  $s = new seminar();
  $sid = $_REQUEST["edit"];
  $s->get($db,$sid);
  $cu = new utils();
?>
          <h1 class="page-header">Modifica seminario</h1>
          <div class="row">
            <div class=" actions pull-right">
              <a href="./adm_seminar_list.php" alt="elenco seminari"><i class="fa fa-bars"></i> elenco</a>
            </div>
          </div>

    <div class="panel panel-default">
          <div class="panel-heading">
        <div class="panel-title">
                  <i class="fa fa-edit pull-right"></i>
                  <h4>Modifica seminario</h4>
                  <i class="fa fa-asterisk asterisc"></i> <small>campi obbligatori</small>
                </div>
            </div>
            <div class="panel-body">
              <form class="form form-vertical" enctype="multipart/form-data" method="post" name="semform" id="semform"> 
                <div class="row">   
                <input name="id" type="hidden" value="<?php echo $s->id?>">      
              <div class="control-group col-sm-6">
                        <label>dal giorno (gg/mm/aaaa) <i class="fa fa-asterisk asterisc"></i></label>
                  <div class="form-group">
                      <div class='input-group date'>
                          <input type='text' class="form-control" id='startdate' name='startdate' value="<?php echo $db->db_to_date($s->fromdate); ?>"/>
                          <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                  </div>
                      </div>      
            <div class="control-group col-sm-6">
                        <label>ora d'inizio (hh:mm)</label>
                  <div class="form-group">
                      <div class='input-group date'>
                          <input type='text' class="form-control" name='starttime' id='starttime' value="<?php echo $s->fromtime; ?>"/>
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
                        <input type='text' class="form-control" name='enddate' id='enddate'  value="<?php echo $db->db_to_date($s->todate); ?>"/>
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                  </div>
                      </div>      
                      
            <div class="control-group col-xs-6">
                        <label>ora di fine (hh:mm)</label>
                <div class="form-group">
                    <div class='input-group date' >
                        <input type='text' class="form-control" name='endtime' id='endtime' value="<?php echo $s->totime; ?>"/>
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
                              <textarea class="form-control" id='shortdescription' name="shortdescription" maxlength="400"><?php echo $s->title; ?></textarea>
                          </div>
                      </div> 
                  </div>
                  <div class="row"> 
                      <div class="control-group col-md-12" >
                        <label>descrizione</label>
                          <div class="controls">
                              <textarea class="form-control" name="description" id="description" maxlength="400"><?php echo $s->description; ?></textarea>
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
                    echo $s->getStageInstructorsOptions($db,$s->instructors[0]['id']); 
                ?>        
                </select>
                <br/>
                              <select class='form-control seminardd' name='seminarinstructor2' id='seminarinstructor2'>       
                <?php
                    echo $s->getStageInstructorsOptions($db,$s->instructors[1]['id']); 
                ?>        
                </select>
                <br/>
                              <select class='form-control seminardd' name='seminarinstructor3'  id='seminarinstructor3'>        
                <?php
                    echo $s->getStageInstructorsOptions($db,$s->instructors[2]['id']); 
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
                    echo $s->getTypeOptions($db,$s->typefk); 
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
                  echo $s->getLocationOptions($db, $s->locationfk); 
              ?>        
              </select>
                        </div>
                    </div> 

                    <div class="control-group col-xs-6  isHidden"  id="manuallocation">
                      <label>&nbsp;</label>
                        <div class="controls">
                          <input class="form-control" placeholder="luogo" name="location" id="location" type="text" maxlength="200" value="<?php echo $s->location; ?>"/>
              <input class="form-control" placeholder="citt&agrave;" name="shortcity" id="shortcity" type="text" maxlength="200" /value="<?php echo $s->shortcity; ?>">
              <input class="form-control" placeholder="indirizzo" name="address" id="address" type="text" maxlength="200" value="<?php echo $s->address; ?>"/>
              <input class="form-control" placeholder="CAP citt&agrave; (provincia)" name="city" id="city" type="text" maxlength="200" value="<?php echo $s->city; ?>"/> 
                        </div>
                    </div> 

                   
                    <div class="control-group col-xs-6">
                      <label>organizzato da <i class="fa fa-asterisk asterisc"></i></label>
                        <div class="controls">
                          <select class='form-control seminardd' name='organizerfk'>
              <?php
                  echo $s->getOrganizerOptions($db,$s->organizerfk); 
              ?>        
              </select>
                        </div>
                    </div> 

                    <div class="control-group col-xs-6 isHidden" id="manualorganizer">
                      <label>&nbsp;</label>
                        <div class="controls">
                          <input class="form-control" placeholder="associazione organizzatrice" name="organizer" id="organizer" type="text" maxlength="200" value="<?php echo $s->organizer; ?>"/>
              <input class="form-control" placeholder="telefono" name="phone" id="phone" type="text" maxlength="200" value="<?php echo $s->phone; ?>"/>
              <input class="form-control" placeholder="indirizzo email" name="email" id="email" type="text" maxlength="200" value="<?php echo $s->email; ?>"/> 
              <input class="form-control" placeholder="sito web" name="url" id="url" type="text" maxlength="200" value="<?php echo $s->url; ?>"/> 
                        </div>
                    </div> 

                    </div>
                    <hr>

                    <div class="row">
                      <div class="control-group col-xs-6 " >
                        <label>orario</label>
                          <div class="controls">
                              <textarea class="form-control" name="schedule" id="schedule" maxlength="400" rows="6"><?php echo $s->schedule; ?></textarea>
                          </div>
                      </div> 

            <div class="control-group col-md-6" >
                        <label>tags</label>
                        <div class="controls" >
                            <input class="form-control" placeholder="tags" type="text" name="tags" id="tags" value="<?php echo $s->tags; ?>">
                          </div>
                      </div>  

            <div class="control-group col-md-6">
                        <label>note</label>
                        <div class="controls" >
                            <textarea class="form-control" name="notes" id="notes" maxlength="200" rows="3"><?php echo $s->notes; ?></textarea>
                          </div>
                      </div> 
        </div>                    
                <hr>
                 <div class="row">
          <div class="control-group col-md-4">
                      <label>locandina<br/>(pdf)</label>
                  <input id="pdf" name="pdf" type="file" class="file-loading" uploadUrl='/<?php echo $uploaddir; ?>' >

                    </div>  
                    
          <div class="control-group col-md-4">
                      <label>miniatura locandina<br/>(dim. max: 200px &times; 300px)</label>
                      <input id="image" name="image" type="file" class="file-loading" uploadUrl='/<?php echo $uploaddir; ?>' >
                    </div>
                    
          <div class="control-group col-md-4">
                      <label>immagine pagina seminari<br/>(dim. max: 140px &times; 100px)</label>
                      <input id="photo" name="photo" type="file" class="file-loading" uploadUrl='/<?php echo $uploaddir; ?>' >
                    </div>

                    </div>
                    <hr>
 


          <div class="control-group col-xs-6">
                      <label>data in cui non mostrare pi&ugrave; sul sito (gg/mm/aaaa)</label>
                  <div class="form-group">
                      <div class='input-group date'>
                          <input type='text' class="form-control"  id='expires' name='expires' value="<?php echo $db->db_to_date($s->expires); ?>"/>
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
                          <input type="submit" value="aggiorna" id="submit" name="aggiorna" class="btn btn-primary">
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
    <script src="../js/fileinput.js"></script>
    <script src="../js/moment-with-locales.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script>
  $(document).on('ready', function() {
      $("#pdf").fileinput({browseLabel: ' Scegli',removeLabel: 'Elimina',uploadLabel: 'Carica',showCaption: false,defaultPreviewContent: '<img src="<?php echo $uploadurl . $s->pdf; ?>" />'});
      $("#image").fileinput({browseLabel: ' Scegli',removeLabel: 'Elimina',uploadLabel: 'Carica',overwriteInitial: true,showCaption: false,defaultPreviewContent: '<img src="<?php echo $uploadurl . $s->image; ?>" />'});
      $("#photo").fileinput({showCaption: false, defaultPreviewContent: '<img src="<?php echo $uploadurl . $s->photo; ?>" />'});
      $('[data-toggle="popover"]').popover();
  });
    </script>
  </body>
</html>
