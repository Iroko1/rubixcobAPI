<?php
include "database.php";


function getUserByEmail($UserEmail, $UserAPIKey) {
    global $db;

    $qry = $db->query("SELECT * FROM users WHERE Email = '$UserEmail' AND APIKey = '$UserAPIKey'");
    $qry = $qry->fetch(PDO::FETCH_ASSOC);
    if (count($qry) == 0) {
        return [false, "Error with database"];
    } else {
        return [true, $qry];
    }
}


// register the user in the database
function registerUser($email, $key) {
    global $db;
    // check if email already exists
    $email = strtolower($email);
    $date = date("Y-m-d H:i:s");
    $qry = $db->query("SELECT * FROM users WHERE email = '$email'");
    if ($qry->rowCount() > 0) {
        //if so, return false and user will need to retrieve their key associated with their email
        return [false, "Email already exists -> please retrieve your key and login instead"];
    }
    $stmt = $db->prepare("INSERT INTO users (email, APIKey, DateCreated) VALUES (:email, :key, :date)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':key', $key);
    $stmt->bindParam(':date', $date);
    if ($stmt->execute()) {
        return [true, ""];
    } else {
        return [false, "Error registering user -> Error with the database"];
    }
}

function validateUser($email, $key) {
    global $db;

    $stmt = $db->prepare("SELECT * FROM users WHERE APIKey = :key AND email = :email");
    $stmt->bindParam(':key', $key);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $qry = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($qry);
    if ($qry != null) {
        return true;
    } else {
        return false;
    }
}


function recordRequest($UserEmail, $UserAPIKey, $DateRequested, $RequestData) {
    global $db;

    $qry = $db->query("SELECT * FROM users WHERE APIKey = '$UserAPIKey' and email = '$UserEmail'");
    $qry = $qry->fetch(PDO::FETCH_ASSOC);
    if ($qry == null) {
        return [false, "Error with database"];
    } else if ($qry['APIKey'] != $UserAPIKey) {
        return [false, "Invalid API Key"];
    } else if ($qry['Email'] != $UserEmail) {
        return [false, "Invalid email"];
    } else {
        // echo "Validated";
    }
    

    $stmt = $db->prepare("INSERT INTO requestdata (UserID, DateRequested,RequestData) VALUES (:UserID, :DateRequested, :RequestData)");
    $stmt->bindParam(':UserID', $qry['UserID']);
    $stmt->bindParam(':DateRequested', $DateRequested);
    $stmt->bindParam(':RequestData', $RequestData);
    if ($stmt->execute()) {
        return [true, ""];
    } else {
        return [false, "Error with recording request"];
    }
    
}

function getRecordData($UserID) {
    global $db;
    

    $qry = $db->query("SELECT * FROM requestdata WHERE UserID = '$UserID'");
    $qry = $qry->fetchAll(PDO::FETCH_ASSOC);
    if ($qry == null) {
        return [false, "Error with database"];
    } else {
        return [true, $qry];
    }
}

function deleteRecord($RequestID) {
    global $db;
    

    $qry = $db->query("DELETE FROM requestdata WHERE RequestID = '$RequestID'");
    if ($qry == null) {
        return [false, "Error with database"];
    } else {
        return [true, $qry];
    }
}




function destroySession() {
    $_SESSION = [];
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time()-3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    session_destroy();
    echo "<script>window.location.href = './';</script>";
    exit();
}




?>