<?php
session_start();
// Check if user is logged in, and redirect to login page if not
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] != true) {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
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
                Profile
            </h1>
        </div>
        <br><br>
        <div class="content-items">
            <form method="post" action="changeusername.php" class="task-list-form">
                <button type="submit" name="changeusername" value="changeusername" class="big-orange-button">Change Username</button>
            </form>
        </div>
        <br><br>

        <div class="content-items">
            <form method="post" action="changepass.php" class="task-list-form">
                <button type="submit" name="changepass" value="change pass" class="big-orange-button">Change Password</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
