<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
    <?php
    if (isset($_SESSION['email']) && $_SESSION['email']) {
        echo 'You are already logged in with email ' . $_SESSION['email'] . '<br/>';
        echo 'Click here <a href="auth/logout.php">Logout</a>';
    } else {
        header('location: ./auth/login.php');
    }
    ?>
    </body>
</html>
