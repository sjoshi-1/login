<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <!--form gets validated using login.php-->
<form action="login.php" method="post">
<h2>LOGIN</h2>
<!--any kind of error will be displayed here-->
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
    


<label>User Name</label>
<input type="text" name="uname" placeholder="Enter your name"
>

<label>Password</label>
<input type="password" name="password" placeholder="Enter your password"
>

<button type="submit">  Login</button>

<a href="signup.php" class="ca">Create an account</a>
</form>
</body>
</html>