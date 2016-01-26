<?php
if($_POST){
 
    // include database connection
    include("../admin/class.db.php");
    include("./class.classinstructor.php");
    $db = new dbaccess();
    $ci = new classinstructor();
    echo $_POST;
    $ci->add($db,$_POST);
}
?>