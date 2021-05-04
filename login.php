<?php
session_start();
// Check if user is already logged in, and redirect to task page if so
if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
    header("Location: task.php");
    exit();
}

require("config/functions.php");

if (isset($_POST["username"]) && isset($_POST["password"])) {

    if (validateCredentials($_POST["username"], $_POST["password"])) {
        $username = trim($_POST["username"]);
        $_SESSION["logged"] = true;
        $_SESSION["username"] = $username;

        //require("config/db.php");
        $query = "SELECT fname, lname FROM accounts WHERE username = :username";
        $params = array(":username"=>$username);
        $results = db_execute_one($query, $params);
        print_r($results);
        $_SESSION["fname"] = $results["fname"];
        $_SESSION["lname"] = $results["lname"];
        header("Location: task.php");
        exit();
    } else {
        echo "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
</head>
<body>
<form action="login.php" autocomplete="off" method="post">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" maxlength="30" value="<?php if (isset($_POST["username"])) {echo $_POST["username"];} ?>" required><br><br>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" maxlength="30" value="<?php if (isset($_POST["password"])) {echo $_POST["password"];} ?>" required><br><br>

    <input type="submit">

    <p>
        Don't have an account? <a href="signup.php">Sign Up</a>
    </p>
</form>
</body>
</html>
