<?php
/*
Ghalia Alrajbn
JUL, 2011
*/
/*
	$DB_HostName = "localhost";
	$DB_Name = "moodle";
	$DB_User = "root";
	$DB_Pass = "";
	$DB_Table = "mdl_notes";
	
	if (isset ($_GET["name"]))
		$name = $_GET["name"];
	else
		$name = "Ghalia";
		
	$con = mysql_connect($DB_HostName,$DB_User,$DB_Pass) or die(mysql_error()); 
	mysql_select_db($DB_Name,$con) or die(mysql_error()); 

	$sql = "insert into $DB_Table (name) values('$name');";
	$res = mysql_query($sql,$con) or die(mysql_error());
	
	mysql_close($con);
	if ($res) {
		echo "success";
	}else{
		echo "faild";
	}// end else
	*/
	
	require_once(DIRNAME(DIRNAME(DIRNAME(__FILE__))).'/config.php');
	
	if ((isset ($_GET["user"])) && (isset ($_GET["pass"])))
	{
		$name = $_GET["user"];
		$pass = $_GET["pass"];
		//Checks if user exists
		$auth = authenticate_user_login($name, $pass);
		if($auth == true){
                    //print_object($auth);
                    //echo $name . " valid";
                    //return true;
                    echo "true";
		} else {
                    //echo $name . " invald";
                    //return false; 
                    echo "false";
                    echo "YAY";
		}
	}		
	//echo "SUCCESS@!!";
	/*
		if ((isset ($_POST["user"])) && (isset ($_POST["pass"])))
	{
		$user = $_POST["user"];
		$pass = $_POST["pass"];
		//Checks if user exists
		$auth = authenticate_user_login($user, $pass);
		if($auth == true){
			//print_object($auth);
			echo "TRUE";
		} else {
		echo "FALSE";
		}
	}	*/
		/*
		$record = new stdClass();
		$record->name = $name;
	$DB->insert_record('aaaaaa', $record);
	*/
	
?>