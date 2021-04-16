<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign up</title>
	<link rel="stylesheet" href="project.css" />
</head>
<body>
<?php
include('projectConnection.php');

//insert user input into database
if (isset($_REQUEST['User Name'])){

	$username = $_REQUEST['User Name'];
	$username = mysqli_real_escape_string($db, $username);

	$password = $_REQUEST['Password'];
	$password = mysqli_real_escape_string($db, $password);

	$fname = $_REQUEST['First Name'];
	$fname = mysqli_real_escape_string($db, $fname);

	$lname = $_REQUEST['Last Name'];
	$lname = mysqli_real_escape_string($db, $lname);

	$email = $_REQUEST['Email'];
	$email = mysqli_real_escape_string($db, $email);

	$query = "INSERT into accounts (User Name, Password, First Name, Last Name, Email) VALUES ('NULL', '$username', '$password', '$fname', '$lname','$email')";
	$result = mysqli_query($db,$query);

	if($result){
		echo "<div class='form'>
                <h3>Signup successful.</h3>
                <br/>Click here to < a href=' '>Login</ a></div>";
	}
}else{
	?>
            <div class="form">
                <h1>Signup</h1>
                <form name="signup" action="" method="post">
                    <input id="User Name" type="username" name="User Name" placeholder="Enter username" required /><br>
                    <input id="Password" type="password" name="Password" placeholder="Enter password" required /><br>
                    <input id="First Name" name="fname" type="text" placeholder="Enter first name" required /><br>
                    <input id="Last Name" name="lname" type="text" placeholder="Enter last name" required /><br>
                    <input id="Email" name="email" type="text" placeholder="Enter Email Address" required /><br>
                    <input type="submit" name="submit" value="Signup" />
                </form>
                <p>Already have an account? < a href='weblogin.php'> Please Login Here</ a></p >
            </div>
</body>
</html>
