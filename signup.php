<?php
session_start();
// Check if user is already logged in, and redirect to task page if so
if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
    header("Location: tasks/incomplete.php");
    exit();
}

$errormsg = "";
if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["fname"]) && isset($_POST["lname"])) {

    require("config/functions.php");

    // Validate format of username
    if (!checkUsername($_POST["username"])) {
        $errormsg = "Invalid username";

    } elseif (!checkUsernameUnique($_POST["username"])) {
        $errormsg = "Username already taken";
    // Validate format of email
    } elseif (!checkEmail($_POST["email"])) {
        $errormsg = "Invalid email";

    } elseif (!checkEmailUnique($_POST["email"])) {
        $errormsg = "Email already taken";

    // Validate format of password
    } elseif (!checkPassword($_POST["password"])) {
        $errormsg = "Invalid password";

    // Validate format of first name
    } elseif (!checkName($_POST["fname"])) {
        $errormsg = "Invalid first name";

    // Validate format of last name
    } elseif (!checkName($_POST["lname"])) {
        $errormsg = "Invalid last name";
    } else {
        try {

            // Check if username already exists in database
            $query = "INSERT INTO `accounts`(`username`, `email`, `password`, `fname`, `lname`) VALUES (:username, :email, :password, :fname, :lname)";
            $params = array(":username"=>$_POST["username"], ":email"=>$_POST["email"], ":password"=>$_POST["password"], ":fname"=>$_POST["fname"], ":lname"=>$_POST["lname"]);
            $results = db_execute_one($query, $params);
            $_SESSION["logged"] = true;
            $_SESSION["username"] = trim($_POST["username"]);
            $_SESSION["fname"] = trim($_POST["fname"]);
            $_SESSION["lname"] = trim($_POST["lname"]);
            header("Location: tasks/incomplete.php");
            exit();

        } catch(PDOException $e) {
            var_export($e);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="headerstyles.css">
</head>
<body>


<div class="content">
    <div class="content-container">
        <div class="content-items">
            <h1>Sign Up</h1>
        </div>

        <form action="signup.php" autocomplete="off" method="post">
            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="username">Username</label>
                    </div>
                    <div class="flex-item-horizontal">
                        <input type="text" id="username" name="username" minlength="3" maxlength="30" value="<?php if (isset($_POST["username"])) {echo $_POST["username"];} ?>" required>
                    </div>
                </div>
            </div>

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="email">Email</label>
                    </div>
                    <div class="flex-item-horizontal">
                        <input type="text" id="email" name="email" value="<?php if (isset($_POST["email"])) {echo $_POST["email"];} ?>" required>
                    </div>
                </div>
            </div>

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="password">Password</label>
                    </div>
                    <div class="flex-item-horizontal">
                        <input type="password" id="password" name="password" minlength="8" maxlength="30" value="<?php if (isset($_POST["password"])) {echo $_POST["password"];} ?>" required>
                    </div>
                </div>
            </div>

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="fname">First Name</label>
                    </div>
                    <div class="flex-item-horizontal">
                        <input type="text" id="fname" name="fname" value="<?php if (isset($_POST["fname"])) {echo $_POST["fname"];} ?>" required>
                    </div>
                </div>
            </div>

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="lname">Last Name</label>
                    </div>
                    <div class="flex-item-horizontal">
                        <input type="text" id="lname" name="lname" value="<?php if (isset($_POST["lname"])) {echo $_POST["lname"];} ?>" required>
                    </div>
                </div>
            </div>
            <br>

            <div class="content-container">
                <div class="content-items">
                    <button type="submit" name="signup" value="signup" class="big-orange-button" style="width: 100px">Sign Up</button>
                </div>
            </div>
        </form>
        <br>

        <div class="content-items">
            <form method="post" action="login.php" class="header-link-form">
                <button type="submit" name="loginlink" value="loginlink" class="header-link-button">Back to Log In page</button>
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