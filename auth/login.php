<?php

require './handle_auth.php';

session_start();
if (isset($_SESSION['email']) && $_SESSION['email']) {
    header('location: ../index.php');
}

if (!empty($_POST['login'])) {
    $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';

    // Validate
    $errors = [];
    if (empty($data['password'])) {
        $errors['password'] = 'The password required';
    }

    if (empty($data['email'])) {
        $errors['email'] = 'The email required';
    }

    if (!$errors) {
        login(
            $data['email'],
            $data['password']
        );
    }
    disconnectDatabase();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="../resources/css/index.css">
    </head>
    <body>
        <h1>Login</h1>
        <br/><br/>
        <form action='./login.php' method='POST'>
            <table class="table table-border width-table">
                <tr>
                    <td class="table-border">Email</td>
                    <td class="table-border">
                        <input type="email" name="email"
                               value="<?php echo !empty($data['email']) ? $data['email'] : ''; ?>"/>
                        <?php if (!empty($errors['email'])) {
                            echo '<p class="color-error">' . $errors['email'] . '</p>';
                        } ?>
                    </td>
                </tr>

                <tr>
                    <td class="table-border">Password</td>
                    <td class="table-border">
                        <input type="password" name="password"
                               value="<?php echo !empty($data['password']) ? $data['password'] : ''; ?>"/>
                        <?php if (!empty($errors['password'])) {
                            echo '<p class="color-error">' . $errors['password'] . '</p>';
                        } ?>
                    </td>
                </tr>
            </table>
            <input type='submit' name="login" value='Login' />
            <a href='register.php' title='Register'>Register</a>
        </form>
    </body>
</html>
