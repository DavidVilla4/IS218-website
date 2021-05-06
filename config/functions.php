<?php
require("db.php");
function checkPassword($password) {
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

function checkPasswordValid($username, $password) {
    try {
        $query = "SELECT COUNT(username) AS num FROM accounts WHERE username = :username AND password = :password";
        $params = array(":username"=>$username, ":password"=>$password);
        $result = db_execute_one($query, $params);
        if ($result["num"] != 0) {
            return true;
        }
    } catch (PDOException $e) {
        var_dump($e);
    }
    return false;
}

function checkUsername($username) {
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        return false;
    } elseif (!preg_match('/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*$/', $username)) {
        return false;
    }
    return true;
}

function checkUsernameUnique($username) {
    try {
        $query = "SELECT COUNT(username) AS num FROM accounts WHERE username = :username";
        $params = array(":username"=>$username);
        $result = db_execute_one($query, $params);
        if ($result["num"] == 0) {
            return true;
        }
    } catch (PDOException $e) {
        var_dump($e);
    }
    return false;
}

function checkEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

function checkEmailUnique($email) {
    try {
        $query = "SELECT COUNT(email) AS num FROM accounts WHERE email = :email";
        $params = array(":email"=>$email);
        $result = db_execute_one($query, $params);
        if ($result["num"] == 0) {
            return true;
        }
    } catch (PDOException $e) {
        var_dump($e);
    }
    return false;
}

function checkName($name) {
    $name = trim($name);
    if (!preg_match('/^[^0-9]+$/', $name)) {
        return false;
    }
    return true;
}

function usernamePasswordExist($username, $password) {

    // Validate username and password formats
    if (checkUsername($username) && checkPassword($password)) {
        // Check if username and password are in database
        $query = "SELECT COUNT(username) as num FROM accounts WHERE username = :username AND password = :password";
        $params = array(":username"=>trim($_POST["username"]), ":password"=>trim($_POST["password"]));
        $results = db_execute_one($query, $params);
        if ($results["num"] > 0) {
            return true;
        }
    }
    return false;
}

// Converts a MySQL Datetime string to a more natural format, such as "In 6 hours"
function convertDateToNatural($date) {
    $currentDateStr = new DateTime("now", new DateTimeZone('America/New_York'));
    $currentDateStr = $currentDateStr->format("Y-m-d H:i");
    $currentDate = date_create($currentDateStr);

    $dateStr = substr($date, 0, -3);
    $date = date_create($dateStr);

    $difference = date_diff($currentDate, $date);
    $diffString = explode(" ", $difference->format('%R %y %m %d %h %i'));

    $retVal = "";

    if ($diffString[1] == 0) {
        if ($diffString[2] == 0) {
            if ($diffString[3] == 0) {
                if ($diffString[4] == 0) {
                    if ($diffString[5] == 0) {
                        return "Now";
                    } else {
                        $retVal .= $diffString[5] . " minute";
                        if ($diffString[5] > 1) {
                            $retVal .= "s";
                        }
                    }
                } else {
                    $retVal .= $diffString[4] . " hour";
                    if ($diffString[4] > 1) {
                        $retVal .= "s";
                    }
                }
            } else {
                $retVal .= $diffString[3] . " day";
                if ($diffString[3] > 1) {
                    $retVal .= "s";
                }
            }
        } else {
            $retVal .= $diffString[2] . " month";
            if ($diffString[2] > 1) {
                $retVal .= "s";
            }
        }
    } else {
        $retVal .= $diffString[1] . " year";
        if ($diffString[1] > 1) {
            $retVal .= "s";
        }
    }

    if ($diffString[0] == '+') {
        $retVal = "In " . $retVal;
    } else {
        $retVal .= " ago";
    }

    return $retVal;
}