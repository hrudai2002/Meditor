<?php 

function emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat) {
    $result = false; 
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat)) {
        $result = true;
    }

    return $result;
}


function invalidUid($username) {
    $result = false; 
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }

    return $result;
}

function invalidEmail($email) {
    $result = false; 
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }

    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result = false; 
    if($pwd !== $pwdRepeat) {
        $result = true;
    }

    return $result;
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.html?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } 
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.html?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username,  $hashedPwd);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../signup.html?error=none");
    exit();    
}

function emptyInputLogin($username, $pwd){
    $result = false; 
    if(empty($username) || empty($pwd)) {
        $result = true;
    }

    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false) {
        header("location: ../login.html?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"]; 
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false) {
        header("location: ../login.html?error=incorrectpassword");
        exit();
    }
    else if($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"]; 
        $_SESSION["useruid"] = $uidExists["usersUid"]; 
        $_SESSION["userName"] = $username;
        header("location: ../index.html?");
        exit();
    }
}

