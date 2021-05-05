<?php
session_start();
// Check if user is logged in, and redirect to login page if not
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] != true) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST["title"])) {

    require("../config/db.php");

    $duedate = str_replace("T", " ", $_POST["duedate"]) . ":00";

    $query = "INSERT INTO tasks (username, title, description, duedate, urgency) VALUES (:username, :title, :description, :duedate, :urgency)";
    $params = array(":username"=>$_SESSION["username"],
        ":title"=>trim($_POST["title"]),
        ":description"=>trim($_POST["description"]),
        ":duedate"=>$duedate,
        ":urgency"=>trim($_POST["urgency"]));
    try {
        db_execute_one($query, $params);
        header("Location: incomplete.php");
        exit();
    } catch (PDOException $e) {
        var_dump($e);
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Task</title>
    <link rel="stylesheet" href="../headerstyles.css">
    <link rel="stylesheet" href="tasksstyles.css">
</head>
<body>
<div class="header">
    <div class="header-items">
        <div class="header-items-left">
            <div class="header-item">
                <form method="post" action="incomplete.php" class="header-link-form">
                    <button type="submit" name="incomplete" value="incomplete" class="header-link-button">To-Do</button>
                </form>
            </div>

            <div class="header-item">
                <form method="post" action="completed.php" class="header-link-form">
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
                <form method="post" action="../profile/profile.php" class="header-link-form">
                    <button type="submit" name="profile" value="profile" class="header-link-button">Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="tasks-container">
        <div class="tasks-items">
            <h1>
                Create New To-Do Task
            </h1>
        </div>
            <form method="post" action="createtask.php" autocomplete="off">
                <div class="tasks-items">
                    <div class="flex-container-horizontal">
                        <div class="flex-item-horizontal">
                            <label for="title">
                                Title
                            </label>
                        </div>
                        <div class="flex-item-horizontal-right">
                            <input type="text" name="title" id="title" maxlength="100" required><br>
                        </div>
                    </div>
                </div>

                <div class="tasks-items">
                    <div class="flex-container-horizontal">
                        <div class="flex-item-horizontal">
                            <label for="description">
                                Description
                            </label>
                        </div>
                        <div class="flex-item-horizontal-right">
                            <textarea class="newtask-text-area" rows="8" cols="65" name="description" id="description" maxlength="2048" required></textarea><br>
                        </div>
                    </div>
                </div>

                <div class="tasks-items">
                    <div class="flex-container-horizontal">
                        <div class="flex-item-horizontal">
                            <label for="urgency">
                                Urgency
                            </label>
                        </div>

                        <div class="flex-item-horizontal-right">
                            <select name="urgency" id="urgency">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select><br>
                        </div>
                    </div>
                </div>

                <div class="tasks-items">
                    <div class="flex-container-horizontal">
                        <div class="flex-item-horizontal">
                            <label for="duedate">
                                Due Date
                            </label>
                        </div>
                        <div class="flex-item-horizontal-right">
                            <input type="datetime-local" name="duedate" id="duedate" max="2025-01-01T00:00" min="2021-01-01T00:00" required><br><br>
                        </div>
                    </div>
                </div>
                <br>

                <div class="tasks-container">
                    <div class="tasks-items" style="justify-content: ">
                        <button type="submit" name="createtask" value="createtask" class="new-task-button">Create Task</button>
                    </div>
                </div>
            </form>
    </div>
</div>

</body>
</html>
