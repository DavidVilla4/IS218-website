<?php
require("config.php");

function checkPassword($password): bool
{
    if (strlen($password) < 8 || strlen($password) > 30) {
        return false;
    } elseif (!preg_match("/[A-Z]/", $password)) {
        return false;
    } elseif (!preg_match("/[a-z]/", $password)) {
        return false;
    } elseif (!preg_match("/[0-9]/", $password)) {
        return false;
    }
    return true;
}


if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["fname"]) && isset($_POST["lname"])) {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);

    // Validate format of username
    if (!preg_match('/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*$/', $username)) {
        echo "Invalid username";

    // Validate format of email
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email";

    // Validate format of password
    } elseif (!checkPassword($password)) {
        echo "Invalid password";

    // Validate format of first name
    } elseif (!preg_match('/^[^0-9]+$/', $fname)) {
        echo "Invalid first name";

    // Validate format of last name
    } elseif (!preg_match('/^[^0-9]+$/', $lname)) {
        echo "Invalid last name";
    } else {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if username already exists in database
            $query = "INSERT INTO `accounts`(`username`, `email`, `password`, `fname`, `lname`) VALUES (:username, :email, :password, :fname, :lname)";
            $statement = $conn->prepare($query);
            $statement->bindValue(":username", $_POST["username"]);
            $statement->bindValue(":email", $_POST["email"]);
            $statement->bindValue(":password", $_POST["password"]);
            $statement->bindValue(":fname", $_POST["fname"]);
            $statement->bindValue(":lname", $_POST["lname"]);
            $statement->execute();
            $statement->closeCursor();

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