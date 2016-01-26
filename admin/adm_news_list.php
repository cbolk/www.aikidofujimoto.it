<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="it">
  <head>
<?php  
  include("./class.db.php");
  include("./class.login.php");
  include("./class.news.php");
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

    <title>notizie</title>

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
    <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.20.custom.min.js" ></script>   

    <script>
    $(document).ready(function() {
        var hash = window.location.hash;
        $(hash).css('background-color', '#d7e7f4').animate({
            backgroundColor: '#d7e7f4'
        }, 2000);

      $('a.del').click(function(e) {
        e.preventDefault();
        var parent = $(this).parent();
        var row = parent.parent();
        var value = parent.attr('id').replace('record-','');
        $.ajax({
          type: 'post',
          url: 'adm_news_del.php',
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
  $n = new news();
  $cu = new utils();
  $num = $n->numActiveNews($db);
  $list = $n->rawlist($db,false,false);
?>
          <h1 class="page-header">Notizie 
          <button type="button" class="btn btn-success btn-circle btn-xl"><?php echo $num; ?></button>
          <button type="button" class="btn btn-default btn-circle btn-xl"><?php echo mysql_num_rows($list) ?></button>
          </h1>
          <div class="row">
            <div class=" actions aright">
              <a href="./adm_news_new.php" alt="aggiungi una nuova notizia"><i class="fa fa-file-text-o"></i> nuova</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>data</th>
                  <th>titolo</th>
                  <th>testo</th>
                  <th>scadenza</th>
                   <th>edit</th>
                  <th>del</th>
               </tr>
              </thead>
              <tbody>
<?php while($row = mysql_fetch_assoc($list)){
      $sid = $row['id'];

      echo "<tr id='" . $sid . "' ><a name='" . $sid . "'/>";
      echo "<td class='seminar_data'>" . $cu->date2monthday($row['date']) . "</td>";
      echo "<td class='seminar_title'>" . $row["title"] . "</td>";
      echo "<td class='seminar_title'>" . $row["description"] . "</td>";
      echo "<td class='seminar_data'>" . $db->db_to_date($row['expires']) . "</td>";
      echo "<td class='seminar_info' id='record-" . $sid . "'><a class='edit' href='adm_news_edit.php?edit=" . $sid . "'><i class='fa fa-pencil-square-o'></i></a></td>";
      echo "<td class='seminar_info' id='record-" . $sid . "'><a class='del' href='#'><i class='fa fa-trash'></i></a></td>";

      echo "</tr>";
    }
    echo "</div>";
  
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
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/fileinput.js"></script>
  </body>
</html>
