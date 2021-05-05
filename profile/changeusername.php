<?php
session_start();
// Check if user is logged in, and redirect to login page if not
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] != true) {
    header("Location: ../login.php");
    exit();
}

require("../config/functions.php");

$errormsg = "";
if (isset($_POST["submitnamechange"])) {
    if (checkUsername($_POST["newusername"])) {
        if (checkUsernameUnique($_POST["newusername"])) {
            if (checkPasswordValid($_SESSION["username"], $_POST["password"])) {
                $query = "UPDATE accounts SET username = :newusername WHERE username = :oldusername AND password = :password";
                $params = array(":newusername"=>$_POST["newusername"], ":oldusername"=>$_SESSION["username"], ":password"=>$_POST["password"]);
                try {
                    db_execute_one($query, $params);
                    $_SESSION["username"] = $_POST["newusername"];
                    $errormsg = "Username changed successfully";
                } catch (PDOException $e) {
                    var_dump($e);
                    exit();
                }
            } else {
                $errormsg = "Incorrect password";
            }
        } else {
            $errormsg = "Username already taken";
        }
    } else {
        $errormsg = "Invalid username format";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Username</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../headerstyles.css">
</head>
<body>
<div class="header">
    <div class="header-items">
        <div class="header-items-left">
            <div class="header-item">
                <form method="post" action="../tasks/incomplete.php" class="header-link-form">
                    <button type="submit" name="incomplete" value="incomplete" class="header-link-button">To-Do</button>
                </form>
            </div>

            <div class="header-item">
                <form method="post" action="../tasks/completed.php" class="header-link-form">
                    <button type="submit" name="completed" value="completed" class="header-link-button">Completed</button>
                </form>
            </div>
        </div>
    </div>

    <div class="userinfo">
        <?php if (isset($_SESSION["fname"]) && isset($_SESSION["lname"])) echo $_SESSION["fname"] . " " . $_SESSION["lname"] ?>
    </div>

    <div class="header-items">
        <div class="header-items-right">
            <div class="header-item">
                <form method="post" action="../logout.php" class="header-link-form">
                    <button type="submit" name="logout" value="logout" class="header-link-button">Log Out</button>
                </form>
            </div>

            <div class="header-item">
                <form method="post" action="profile.php" class="header-link-form">
                    <button type="submit" name="profile" value="profile" class="header-link-button">Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-container">
        <div class="content-items">
            <h1>
                Change Username
            </h1>
        </div>

        <form method="post" action="changeusername.php" autocomplete="off">
            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="newusername">
                            New Username
                        </label>
                    </div>
                    <div class="flex-item-horizontal">
                        <input type="text" id="newusername" name="newusername" maxlength="30" value="<?php if (isset($_POST["newusername"])) {echo $_POST["newusername"];} ?>" required>
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
                    <button type="submit" name="submitnamechange" value="submitnamechange" class="big-orange-button">Change Username</button>
                </div>
            </div>

        </form>
        <br>

        <div class="content-items">
            <h2><?php echo $errormsg; ?></h2>
        </div>

    </div>
</div>
</body>
</html>
