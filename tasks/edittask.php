<?php
session_start();
// Check if user is logged in, and redirect to login page if not
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] != true) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_POST["id"]) && !isset($_POST["edit"])) {
    header("Location: incomplete.php");
    exit();
}

require("../config/db.php");
if (isset($_POST["submitedit"])) {
    $query = "UPDATE tasks SET title = :title, description = :description, urgency = :urgency, duedate = :duedate WHERE id = :id AND username = :username";
    $params = array(":title"=>$_POST["title"],
        ":description" => $_POST["description"],
        ":urgency"=>$_POST["urgency"],
        ":duedate"=>$_POST["duedate"],
        ":id"=>$_POST["id"],
        ":username"=>$_SESSION["username"]);
    try {
        db_execute_one($query, $params);
        header("Location: ". $_POST["prevpage"]);
    } catch (PDOException $e) {
        var_dump($e);
    } finally {
        exit();
    }
} else {
    $query = "SELECT * FROM tasks WHERE id = :id AND username = :username";
    $params = array(":id"=>$_POST["id"],
        ":username"=>$_SESSION["username"]);
    try {
        $result = db_execute_one($query, $params);
    } catch (PDOException $e) {
        var_dump($e);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link rel="stylesheet" href="../headerstyles.css">
    <link rel="stylesheet" href="taskstyles.css">
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
    <div class="content-container">
        <div class="content-items">
            <h1>
                Edit Task
            </h1>
        </div>

        <form method="post" action="edittask.php" autocomplete="off">

            <input type="hidden" name="id" value="<?php echo $result["id"]; ?>">
            <input type="hidden" name="prevpage" value="<?php echo $_POST["prevpage"]; ?>">

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="title">
                            Title
                        </label>
                    </div>
                    <div class="flex-item-horizontal-right">
                        <input type="text" name="title" id="title" maxlength="100" value="<?php echo $result["title"]; ?>" required><br>
                    </div>
                </div>
            </div>

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="description">
                            Description
                        </label>
                    </div>
                    <div class="flex-item-horizontal-right">
                        <textarea class="newtask-text-area" rows="8" cols="65" name="description" id="description" maxlength="2048" required><?php echo $result["description"]; ?></textarea><br>
                    </div>
                </div>
            </div>

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="urgency">
                            Urgency
                        </label>
                    </div>

                    <div class="flex-item-horizontal-right">
                        <select name="urgency" id="urgency" >
                            <option value="low" <?php if ($result["urgency"] == "Low") echo "selected"; ?>>Low</option>
                            <option value="med" <?php if ($result["urgency"] == "Medium") echo "selected"; ?>>Medium</option>
                            <option value="high" <?php if ($result["urgency"] == "High") echo "selected"; ?>>High</option>
                        </select><br>
                    </div>
                </div>
            </div>

            <div class="content-items">
                <div class="flex-container-horizontal">
                    <div class="flex-item-horizontal">
                        <label for="duedate">
                            Due Date
                        </label>
                    </div>
                    <div class="flex-item-horizontal-right">
                        <input type="datetime-local" name="duedate" id="duedate" max="2025-01-01T00:00" min="2021-01-01T00:00" value="<?php echo str_replace(" ", "T", substr($result["duedate"], 0, -3)); ?>" required><br><br>
                    </div>
                </div>
            </div>
            <br>

            <div class="content-container">
                <div class="content-items" style="justify-content: ">
                    <button type="submit" name="submitedit" value="submitedit" class="big-orange-button">Edit Task</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>
