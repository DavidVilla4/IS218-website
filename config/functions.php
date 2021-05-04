<?php

function checkPassword($password) {
    $password = trim($password);
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

function checkUsername($username) {
    $username = trim($username);
    if(!preg_match('/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*$/', $username)) {
        return false;
    }
    return true;
}

function checkEmail($email) {
    $email = trim($email);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

function checkName($name) {
    $name = trim($name);
    if (!preg_match('/^[^0-9]+$/', $name)) {
        return false;
    }
    return true;
}

function validateCredentials($username, $password) {
    require("db.php");

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