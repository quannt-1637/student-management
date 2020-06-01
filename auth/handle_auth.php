<?php

require '../database.php';

function register($userName, $password, $email, $fullName)
{
    global $conn;

    connectDatabase();

    $userName   = addslashes($userName);
    $password   = md5(addslashes($password));
    $email      = addslashes($email);
    $fullName   = addslashes($fullName);

    $sql = "SELECT email FROM members WHERE email='{$email}'";

    if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
        echo "Email address already exists! Please use another email! <a href='javascript: history.go(-1)'>Back</a>";
        exit;
    }

    $sqlRegisterMember = "INSERT INTO members(username, password, email, full_name)
                            VALUES ('$userName', '$password', '$email', '$fullName')";

    $query = mysqli_query($conn, $sqlRegisterMember);

    if ($query) {
        echo "Register successfully! <a href='../index.php'>Back Home</a>";
        exit;
    } else {
        echo "Error Register! <a href='register.php'>Back</a>";
        exit;
    }
}

function login($email, $password, $rememberMe)
{
    global $conn;

    session_start();

    connectDatabase();

    $email      = addslashes($email);
    $password   = md5(addslashes($password));

    $sql = "SELECT email, full_name FROM members WHERE email = '{$email}' AND password = '{$password}'";
    $query = mysqli_query($conn, $sql);

    if (!mysqli_num_rows($query)) {
        echo "Email or password is incorrect! <a href='javascript: history.go(-1)'>Back</a>";
        exit;
    }

    if ($rememberMe) {
        $token = randomString(60);

        updateRememberMe($conn, $email, $token);
        setcookie('remember', $token, time() + 3600, '/');
    }

    $row = mysqli_fetch_array($query);

    $_SESSION['email'] = $email;
    echo 'Hello ' . $row['full_name'] . ". Login successfully! <a href='/'>Back</a>";
    die();
}

function updateRememberMe($conn, $email, $token)
{
    $sql= "UPDATE members SET remember_token = '{$token}' WHERE email = '{$email}'";

    mysqli_query($conn, $sql);
}

function randomString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

function checkRemember($cookieRemember)
{
    global $conn;

    connectDatabase();

    $sql = "SELECT * FROM members WHERE remember_token = '{$cookieRemember}'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $_SESSION['email'] = $row['email'];

        header('location: ../index.php');
    }

    header('location: ./login.php');
}
