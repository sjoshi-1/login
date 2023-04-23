<?php

//session starrt and database connection file included
session_start(); 
include "db_conn.php";

//check whether the variables are empty or declared
if (isset($_POST['uname']) && isset($_POST['password'])) {


	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
//values of username and password gets validate dand stored in the respective variables
	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	//if the variables are empty it will throw an error
	if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{

		// hashing the password
        $pass = md5($pass);

        //sql statement prepared to check username and password values in database
		$sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";

		//$result will store the values of the result of query
		$result = mysqli_query($conn, $sql);

		//result of query must contain only one value in db thats why ===1 is used
		if (mysqli_num_rows($result) === 1) {
			//$row Fetch a result row as an associative array:
			$row = mysqli_fetch_assoc($result);
            
			//check whether the database username and form's username is same and database password and form password same
			if ($row['user_name'] === $uname && $row['password'] === $pass) {

            	$_SESSION['user_name'] = $row['user_name'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: home.php");
		        exit();
            }else{
				//if anything does not matchit will throw an error
				header("Location: index.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: index.php?error=Incorect User name or password");
	        exit();
		}
	}
	
}else{
	//redirected to index page
	header("Location: index.php");
	exit();
}
