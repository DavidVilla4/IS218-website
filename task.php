<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="header">
    <div class="header-items-left">
        <div class="header-item">
            <form method="post" action="task.php" class="header-link-form">
                <button type="submit" name="tasks" value="tasks" class="header-link-button">Tasks</button>
            </form>
        </div>
    </div>

    <div class="userinfo">
        <?php if (isset($_SESSION["fname"]) && isset($_SESSION["lname"])) echo $_SESSION["fname"] . " " . $_SESSION["lname"] ?>
    </div>

    <div class="header-items-right">
        <div class="header-item">
            <form method="post" action="logout.php" class="header-link-form">
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

<div class="content">

</div>

</body>
</html>
