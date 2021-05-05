<?php
session_start();
// Check if user is already logged in, and redirect to task page if so
if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
    header("Location: tasks/incomplete.php");
    exit();
}

require("config/functions.php");

$errormsg = "";
if (isset($_POST["username"]) && isset($_POST["password"])) {

    if (usernamePasswordExist($_POST["username"], $_POST["password"])) {
        $username = trim($_POST["username"]);
        $_SESSION["logged"] = true;
        $_SESSION["username"] = $username;

        $query = "SELECT fname, lname FROM accounts WHERE username = :username";
        $params = array(":username"=>$username);
        $results = db_execute_one($query, $params);

        $_SESSION["fname"] = $results["fname"];
        $_SESSION["lname"] = $results["lname"];
        header("Location: tasks/incomplete.php");
        exit();
    } else {
        $errormsg = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <link rel="stylesheet" href="headerstyles.css">
</head>
<body>


<div class="content">
    <div class="content-container">
        <div class="content-items">
            <h1>
                Log In
            </h1>
        </div>

        <form method="post" action="login.php" autocomplete="off">
            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="username">
                            Username
                        </label>
                    </div>
                    <div class="flex-item-horizontal">
                        <input type="password" id="username" name="username" maxlength="30" value="<?php if (isset($_POST["username"])) {echo $_POST["username"];} ?>" required>
                    </div>
                </div>
            </div>

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="password">
                            Password
                        </label>
                    </div>
                    <div class="flex-item-horizontal">
                        <input type="password" id="password" name="password" maxlength="30" value="" required>
                    </div>
                </div>
            </div>
            <br>

            <div class="content-container">
                <div class="content-items">
                    <button type="submit" name="login" value="login" class="big-orange-button" style="width: 100px">Log In</button>
                </div>
            </div>

        </form>
        <br>

        <div class="content-items">
            <form method="post" action="signup.php" class="header-link-form">
                <button type="submit" name="signuplink" value="signuplink" class="header-link-button">Don't have an account? Click Here to Sign Up</button>
            </form>
        </div>
        <br><br>

        <div class="content-items">
            <h2><?php echo $errormsg; ?></h2>
        </div>

    </div>
</div>
</body>
</html>
