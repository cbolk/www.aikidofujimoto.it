<?php
//start session
if(!isset($_SESSION['loggedin']))
    session_start();
    //$_SESSION['loggedin'] = '';
class logmein {
 
    //table fields
    var $user_table = 'user_t';          //Users table name
    var $user_column = 'login';     //USERNAME column (value MUST be valid email)
    var $pass_column = 'passwd';      //PASSWORD column
 
    //encryption
    var $encrypt = true;       //set to true to use md5 encryption for the password
    var $dbconn;
  
    function getdb() {
        $this->dbconn = new dbaccess();
    }

    //login function
    function login($table, $username, $password){       
        //make sure table name is set
        if($this->user_table == ""){
            $this->user_table = $table;
        }
        //check if encryption is used
        if($this->encrypt == true){
            $password = md5($password);
        }
        //execute login via qry function that prevents MySQL injections
        if(!$this->dbconn)
            $this->getdb();
        $result = $this->dbconn->qry("SELECT * FROM ".$this->user_table." WHERE ".$this->user_column."='?' AND ".$this->pass_column." = '?';" , $username, trim($password));
        $row=mysql_fetch_assoc($result);
        if($row != "Error"){
            if($row[$this->user_column] !="" && $row[$this->pass_column] !=""){
                //register sessions
                //you can add additional sessions here if needed
                $_SESSION['loggedin'] = $row[$this->pass_column];
                return true;
            }else{
                session_destroy();
                return false;
            }
        }else{
            return false;
        }
 
    }

    //logout function
    function logout(){
        session_destroy();
        return;
    }
 
    //check if loggedin
    function logincheck($logincode, $user_table, $pass_column, $user_column){
        //make sure password column and table are set
        if($this->pass_column == ""){
            $this->pass_column = $pass_column;
        }
        if($this->user_column == ""){
            $this->user_column = $user_column;
        }
        if($this->user_table == ""){
            $this->user_table = $user_table;
        }
        //exectue query
        if(!$this->dbconn)
            $this->getdb();
        $result = $this->dbconn->qry("SELECT * FROM ".$this->user_table." WHERE ".$this->pass_column." = '?';" , $logincode);
//        $row=mysql_fetch_assoc($result);
        $rownum = mysql_num_rows($result);
        //return true if logged in and false if not
//        if($row != "Error"){
            if($rownum > 0){
                return true;
            }else{
                return false;
            }
 //       }
    }


    //login form
    function loginform($formname, $formclass, $formaction){
    
        $html = '<div class="container-fluid">
        		<div class="row">
        		<center>
                        <div class="col-sm-4 col-sm-offset-4 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>autenticazione</h3>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
    <form id="'.$formname.'" method="POST" class="'.$formclass.'" enctype="application/x-www-form-urlencoded" action="'.$formaction.'">       
      <input type="text" class="form-control" name="utente" placeholder="nome utente" required="" autofocus="" />
      <input type="password" class="form-control" name="password" placeholder="password" required=""/>  
      <input name="action" id="action" value="login" type="hidden">    
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>   
    </form>
    </div>
    </div>
    </center>
    </div>
  </div>';
 
        echo $html;    
    
    }

  
  }
?>


