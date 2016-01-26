<?php
	setlocale(LC_TIME, 'ita');
	date_default_timezone_set('Europe/Rome');
	include("./class.db.php");
	include("./class.login.php");
	$log = new logmein();
	$log->encrypt = true; //set encryption 
	$isLogged = $log->logincheck($_SESSION['loggedin'], "user_t", "passwd", "login");	
?>
<!DOCTYPE html>
<html>
<head>
			<?php
				$aid = $_GET['id'];
				$h = $_GET['hrs'];
				$day = $_GET['day'];
				$sqlold = "SELECT attendance.hours FROM attendance WHERE date = '" . $day . "' AND aikidoka_fk = " . $aid;
				$db = new dbaccess();
				$db->dbconnect();
				$oldh = $db->qry($sqlold);
				if(mysql_num_rows($oldh) == 0)
					$sqlalter = "INSERT INTO attendance (date,hours,aikidoka_fk) VALUES (\"" . $day . "\"," . $h . "," . $aid . ");";
				else 
					$sqlalter = "UPDATE attendance SET hours = " . $h . " WHERE date = \"" . $day . "\" AND aikidoka_fk = " . $aid . ";";
				$update = mysql_query($sqlalter);
			?>
</body>
</html>