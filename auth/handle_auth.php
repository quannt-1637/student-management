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

function login($email, $password)
{
    global $conn;

    session_start();

    connectDatabase();

    $email      = addslashes($email);
    $password   = md5(addslashes($password));

    $sql = "SELECT email, full_name FROM members WHERE email='{$email}' AND password='{$password}'";
    $query = mysqli_query($conn, $sql);

    if (!mysqli_num_rows($query)) {
        echo "Email or password is incorrect! <a href='javascript: history.go(-1)'>Back</a>";
        exit;
    }

    $row = mysqli_fetch_array($query);

    $_SESSION['email'] = $email;
    echo 'Hello ' . $row['full_name'] . ". Login successfully! <a href='/'>Back</a>";
    die();
}
