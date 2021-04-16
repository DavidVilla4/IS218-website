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
if (isset($_POST['User Name'])){
    $username = $_REQUEST['User Name'];
    $username = mysqli_real_escape_string($db,$username);
    $password = $_REQUEST['Password'];
    $password = mysqli_real_escape_string($db,$password);
    $query = "SELECT * FROM accounts WHERE User Name='$username' and Password='$password'";
    $result = mysqli_query($db,$query) or die(mysqli_error());
    $rows = mysqli_num_rows($result);
    if($rows==1){
        $_SESSION['User Name'] = $username;
        $_SESSION['Password'] = $password;
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $_SESSION['User Name'] = $row['User Name'];
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
        <form action="" method="post" name="login">
            <input id="User Name" type="email" name="User Name" placeholder="Enter username" required/><br>
            <input id="Password" type="password" name="Password" placeholder="Enter password" required/><br>
            <input name="submit" type="submit" value="Login" />
        </form>
        <p>Don't have an account? No Worries < a href='Websignup.php'>Please Signup Here</ a></p >
    </div>
</body>
</html>
