<?php
session_start();

if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
}

if (isset($_COOKIE['remember'])) {
    unset($_COOKIE['remember']);
    setcookie('remember', null, -1, '/');
}

header('location: ./login.php');
