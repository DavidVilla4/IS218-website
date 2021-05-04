<?php
session_start();
// Check if user is already logged in, and redirect to task page if so
if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
    header("Location: task.php");
    exit();
}

if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["fname"]) && isset($_POST["lname"])) {

    require("config/functions.php");

    // Validate format of username
    if (!checkUsername($_POST["username"])) {
        echo "Invalid username";

    // Validate format of email
    } elseif (!checkEmail($_POST["email"])) {
        echo "Invalid email";

    // Validate format of password
    } elseif (!checkPassword($_POST["password"])) {
        echo "Invalid password";

    // Validate format of first name
    } elseif (!checkName($_POST["fname"])) {
        echo "Invalid first name";

    // Validate format of last name
    } elseif (!checkName($_POST["lname"])) {
        echo "Invalid last name";
    } else {
        try {
            require("config/db.php");

            // Check if username already exists in database
            $query = "INSERT INTO `accounts`(`username`, `email`, `password`, `fname`, `lname`) VALUES (:username, :email, :password, :fname, :lname)";
            $params = array(":username"=>$_POST["username"], ":email"=>$_POST["email"], ":password"=>$_POST["password"], ":fname"=>$_POST["fname"], ":lname"=>$_POST["lname"]);
            $results = db_execute_one($query, $params);
            $_SESSION["logged"] = true;
            $_SESSION["username"] = trim($_POST["username"]);
            $_SESSION["fname"] = trim($_POST["fname"]);
            $_SESSION["lname"] = trim($_POST["lname"]);
            header("Location: task.php");
            exit();

        } catch(PDOException $e) {
            // Checks if database returned a duplicate key error
            if ($e->errorInfo[1] == 1062) {

                // Checks if duplicate key is 'email'
                if (str_contains($e->errorInfo[2], "'email'")) {
                    echo "Email already taken";

                // Checks if duplicate key is 'PRIMARY', which in this case means the username already exists
                } elseif (str_contains($e->errorInfo[2], "'PRIMARY'")) {
                    echo "Username already taken";
                } else {
                    echo "Connection failed: " . $e->getMessage();
                }
            } else {
                var_export($e);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<form action="signup.php" autocomplete="off" method="post">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php if (isset($_POST["username"])) {echo $_POST["username"];} ?>" required><br><br>

    <label for="email">Email</label>
    <input type="text" id="email" name="email" value="<?php if (isset($_POST["email"])) {echo $_POST["email"];} ?>" required><br><br>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" value="<?php if (isset($_POST["password"])) {echo $_POST["password"];} ?>" minlength="8" maxlength="30" required><br><br>

    <label for="fname">First Name</label>
    <input type="text" id="fname" name="fname" value="<?php if (isset($_POST["fname"])) {echo $_POST["fname"];} ?>" required><br><br>

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lname" value="<?php if (isset($_POST["lname"])) {echo $_POST["lname"];} ?>" required><br><br>

    <input type="submit">
</form>
</body>
</html>