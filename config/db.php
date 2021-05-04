<?php
function getDB() {
    global $db;
    if (!isset($db)) {
        try {
            require('dbcredentials.php');

            $con = "mysql:dbname=$dbname;host=$dbhost";
            $db = new PDO($con, $dbuname, $dbpass);
        } catch (Exception $e) {
            var_export($e);
            $db = null;
        }
    }
    return $db;
}

function db_execute_one($stmtstr, $params) {
    $db = getDB();
    $stmt = $db->prepare($stmtstr);
    $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] != "00000") {
        var_export($e);
        exit("Database failure try again");
    }
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function db_execute_many($stmtstr, $params) {
    $db = getDB();

    $stmt = $db->prepare($stmtstr);
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
    }
    $stmt->execute();

    $e = $stmt->errorInfo();

    if ($e[0] != "00000") {
        var_export($e);
        exit("Database failure try again");
    }
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $result;
}