<?php
session_start();
// Check if user is logged in, and redirect to login page if not
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] != true) {
    header("Location: ../login.php");
    exit();
}
require("../config/functions.php");

$errormsg = "";
if (isset($_POST["submitpasschange"])) {
    if (checkPassword($_POST["newpassword"])) {
        if (checkPasswordValid($_SESSION["username"], $_POST["password"])) {
            // Check if new password is same as current or previous passwords
            $query = "SELECT oldpass1, oldpass2 FROM accounts WHERE username = :username AND password = :oldpassword";
            $params = array(":username"=>$_SESSION["username"], ":oldpassword"=>$_POST["password"]);
            try {
                $results = db_execute_one($query, $params);
            } catch (PDOException $e) {
                var_dump($e);
                exit();
            }

            $currentpass = $_POST["password"];
            $oldpass1 = $results["oldpass1"];
            $oldpass2 = $results["oldpass2"];
            $newpass = $_POST["newpassword"];
            if (in_array($newpass, array($currentpass, $oldpass1, $oldpass2))) {
                $errormsg = "Could not change. You have already used that password recently";
            } else {
                $oldpass2 = $oldpass1;
                $oldpass1 = $currentpass;
                $currentpass = $newpass;
                $query = "UPDATE accounts SET password = :password, oldpass1 = :oldpass1, oldpass2 = :oldpass2 WHERE username = :username";
                $params = array(":password"=>$currentpass,
                    ":oldpass1"=>$oldpass1,
                    ":oldpass2"=>$oldpass2,
                    ":username"=>$_SESSION["username"]);
                try {
                    db_execute_one($query, $params);
                } catch (PDOException $e) {
                    var_dump($e);
                    exit();
                }
                $errormsg = "Successfully changed password";
            }
        } else {
            $errormsg = "Incorrect current password";
        }
    } else {
        $errormsg = "Invalid format for new password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
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
                Change Password
            </h1>
        </div>

        <form method="post" action="changepass.php" autocomplete="off">
            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="newpassword">
                            New Password
                        </label>
                    </div>
                    <div class="flex-item-horizontal">
                        <input type="password" id="newpassword" name="newpassword" maxlength="30" value="<?php if (isset($_POST["newpassword"])) {echo $_POST["newpassword"];} ?>" required>
                    </div>
                </div>
            </div>

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="password">
                            Current Password
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
                    <button type="submit" name="submitpasschange" value="submitpasschange" class="big-orange-button">Change Password</button>
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