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
if (isset($_REQUEST['username'])){

	$username = $_REQUEST['username'];
	$username = mysqli_real_escape_string($db, $username);

	$password = $_REQUEST['password'];
	$password = mysqli_real_escape_string($db, $password);

	$fname = $_REQUEST['fname'];
	$fname = mysqli_real_escape_string($db, $fname);

	$lname = $_REQUEST['lname'];
	$lname = mysqli_real_escape_string($db, $lname);

	$college = $_REQUEST['college'];
	$college = mysqli_real_escape_string($db, $college);

	$major = $_REQUEST['major'];
	$major = mysqli_real_escape_string($db,$major);

	$query = "INSERT into accounts000 (id, email, password, fname, lname, college, major) VALUES ('NULL', '$username', '$password', '$fname', '$lname', '$college', '$major')";
	$result = mysqli_query($db,$query);

	if($result){
		echo "<div class='form'>
                <h3>Signup successful.</h3>
                <br/>Click here to < a href=' '>Login</ a></div>";
	}
}else{
	?>
    <!-- SIGNUP FORM -->
            <div class="form">
                <h1>Signup</h1>
                <form name="signup" action="" method="post">
                    <input id="username" type="email" name="username" placeholder="Enter username" required /><br>
                    <input id="password" type="password" name="password" placeholder="Enter password" required /><br>
                    <input id="fname" name="fname" type="text" placeholder="Enter first name" required /><br>
                    <input id="lname" name="lname" type="text" placeholder="Enter last name" required /><br>
                    <input id="college" name="college" type="text" placeholder="Enter college" required /><br>
                    <input id="major" name="major" type="text" placeholder="Enter major" required /><br>
                    <input type="submit" name="submit" value="Signup" />
                </form>
                <p>Already have an account? < a href='login.php'>Login Here</ a></p >
            </div>
<?php } ?>
</body>
</html>