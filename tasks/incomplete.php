<?php
session_start();
// Check if user is logged in, and redirect to login page if not
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] != true) {
    header("Location: ../login.php");
    exit();
}

require("../config/db.php");
if (isset($_POST["delete"])) {
    $query = "DELETE FROM tasks WHERE id = :id AND username = :username";
    $params = array(":id"=>$_POST["id"],
        ":username"=>$_SESSION["username"]);
    try {
        db_execute_one($query, $params);
    } catch (PDOException $e) {
        var_dump($e);
    }

} elseif (isset($_POST["markcomplete"])) {
    $query = "UPDATE tasks SET completed = 1 WHERE id = :id AND username = :username";
    $params = array(":id"=>$_POST["id"],
        ":username"=>$_SESSION["username"]);
    try {
        db_execute_one($query, $params);
    } catch (PDOException $e) {
        var_dump($e);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do Tasks</title>
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
            <h1>To-Do Tasks</h1>
        </div>
        <div class="tasks-items">
            <form method="post" action="createtask.php" class="task-list-form">
                <button type="submit" name="createnew" value="createnew" class="new-task-button">Add New Task</button>
            </form>
        </div>
        <br><br>
        <div class="tasks-items">
            <table border="1" frame="void" rules="rows">
                <tr>
                    <th>
                        Title
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        Due
                    </th>
                    <th>
                        Urgency
                    </th>
                </tr>
                <?php


                $query = "SELECT * FROM tasks WHERE username = :username AND completed IS FALSE";
                $params = array(":username" => $_SESSION["username"]);
                try {
                    $results = db_execute_many($query, $params);
                    if ($results == null) {
                        echo "<tr><td></td><td></td><td></td><td></td></tr>";
                    } else {
                        foreach ($results as $task) {
                            $urgency = match ($task["urgency"]) {
                                "low" => "Low",
                                "high" => "High",
                                default => "Medium",
                            };
                            $currentFile = basename(__FILE__);
                            echo "<tr>";
                            echo "<td>" . $task["title"] . "</td>";
                            echo "<td>" . $task["description"] . "</td>";
                            echo "<td>" . $task["duedate"] . "</td>"; // TODO - FORMAT TIME UNTIL DUE DATE PROPERLY
                            echo "<td>" . $urgency . "</td>";
                            echo "<td><form method='post' action='incomplete.php' class='task-list-form'>
                                    <input type='hidden' name='id' value='${task["id"]}'>
                                    <button type='submit' name='markcomplete' value='markcomplete' class='task-list-button'>Mark Completed</button>
                              </form></td>";
                            echo "<td><form method='post' action='edittask.php' class='task-list-form'>
                                    <input type='hidden' name='id' value='${task["id"]}'>
                                    <input type='hidden' name='prevpage' value='${currentFile}'>
                                    <button type='submit' name='edit' value='edit' class='task-list-button'>Edit Task</button>
                              </form></td>";
                            echo "<td><form method='post' action='incomplete.php' class='task-list-form'>
                                    <input type='hidden' name='id' value='${task["id"]}'>
                                    <button type='submit' name='delete' value='delete' class='task-list-button'>Delete</button>
                              </form></td>";
                            echo "</tr>";
                        }
                    }
                } catch (PDOException $e) {
                    var_dump($e);
                }
                ?>
            </table>
        </div>
    </div>
</div>

</body>
</html>
