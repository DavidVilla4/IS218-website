<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="project.css" />
</head>
<body>
<?php
include('PageConnection.php');
session_start();
if (isset($_POST)){
    $username = $_POST['username'];
    $username = mysqli_real_escape_string($db,$username);
    echo $username;
    $password = $_POST['password'];
    $password = mysqli_real_escape_string($db,$password);
   echo $password;
    $query = "SELECT * FROM accounts WHERE User Name='$username' and Password='$password'";
    $result = mysqli_query($db,$query) or die(mysqli_error());
    $rows = mysqli_num_rows($result);
    if($rows==1){
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['First Name'] = $row['First Name'];
            $_SESSION['Last Name'] = $row['Last Name'];
            $_SESSION['Email'] = $row['Email'];

        }

        redirect('Transferring to user profile page, please wait', '/////Create a profile php file/////', 3);
    }else{
        echo "<div class='form'>
        <h3>Please enter a valid username or password.</h3>
        <br/>Click here to < a href=' '>Login</ a></div>";
    }
}
    ?>
    <div class="form">
        <h1>Login</h1>
        <h2>Bad Login, try again</h2>
        <form action="" method="post" name="login">
            <input id="username" type="username" name="username" placeholder="Enter username" required/><br>
            <input id="password" type="password" name="Password" placeholder="Enter password" required/><br>
            <input name="submit" type="submit" value="Login" />
        </form>
        <p>Don't have an account? No Worries</p> <a href='register.html'>Please Signup Here</ a>
    </div>
</body>
</html>