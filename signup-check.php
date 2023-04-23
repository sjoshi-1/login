<?php 

/**session gets started and connection to db file gets included */
session_start(); 
include "db_conn.php";

/**here isset function along with post is used to check _post data exist or not
 */
/**post used to send data to server */
if (isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	/**every validated value will get stored into their respective variables */
	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	$re_pass = validate($_POST['re_password']);
	$name = validate($_POST['name']);

	$user_data = 'uname='. $uname. '&name='. $name;

	/* if there is data present for every filed or not if there is any field empty it will show error
	*/
	if (empty($uname)) {
		header("Location: signup.php?error=User Name is required&$user_data");
	    exit();
	}else if(empty($pass)){
        header("Location: signup.php?error=Password is required&$user_data");
	    exit();
	}
	else if(empty($re_pass)){
        header("Location: signup.php?error=Re Password is required&$user_data");
	    exit();
	}

	else if(empty($name)){
        header("Location: signup.php?error=Name is required&$user_data");
	    exit();
	}

	/*check whether password and re password is same or not*/ 
	else if($pass !== $re_pass){
        header("Location: signup.php?error=The confirmation password  does not match&$user_data");
	    exit();
	}

	else{

		// hashing the password 
		/**no one can see the user password in db */
        $pass = md5($pass);

		//prepare sql statement
	    $sql = "SELECT * FROM users WHERE user_name='$uname' ";

		//result will be stored in $result variable
		$result = mysqli_query($conn, $sql);

		//if result has value more than zero thta means username already exist and it will show error
		if (mysqli_num_rows($result) > 0) {
			header("Location: signup.php?error=The username is taken try another&$user_data");
	        exit();

			//if result has no value in then the new user will get created in the db
		}else {
			//value get inserted in db using the query
           $sql2 = "INSERT INTO users(user_name, password, name) VALUES('$uname', '$pass', '$name')";
           $result2 = mysqli_query($conn, $sql2);
         //if everything goes well it will show success message otherwise send error 
		   if ($result2) {
           	 header("Location: signup.php?success=Your account has been created successfully");
	         exit();
           }else {
	           	header("Location: signup.php?error=unknown error occurred&$user_data");
		        exit();
           }
		}
	}
	
}else{
/*redirect to signup page after validating the form input
 */
	header("Location: signup.php");
	exit();
}