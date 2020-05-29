<?php

require './handle_auth.php';

if (!empty($_POST['register_member'])) {
    $data['user_name'] = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
    $data['full_name'] = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    // Validate
    $errors = [];
    if (empty($data['user_name'])) {
        $errors['user_name'] = 'The user name required';
    }

    if (empty($data['password'])) {
        $errors['password'] = 'The password required';
    }

    if (empty($data['email'])) {
        $errors['email'] = 'The email required';
    }

    if (empty($data['full_name'])) {
        $errors['full_name'] = 'The full name required';
    }

    if (!$errors) {
        register(
            $data['user_name'],
            $data['password'],
            $data['email'],
            $data['full_name']
        );
    }
    disconnectDatabase();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../resources/css/index.css">
    </head>

    <body>
        <h1>Register Member</h1>
        <a href='javascript: history.go(-1)'>Back</a>
        <br/><br/>
        <form method="POST" action="./register.php">
            <table class="table table-border width-table">
                <tr>
                    <td class="table-border">User name</td>
                    <td class="table-border">
                        <input type="text" name="user_name"
                               value="<?php echo !empty($data['user_name']) ? $data['user_name'] : ''; ?>"/>
                        <?php if (!empty($errors['user_name'])) {
                            echo '<p class="color-error">' . $errors['user_name'] . '</p>';
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
                    <td class="table-border">Full name</td>
                    <td class="table-border">
                        <input type="text" name="full_name"
                               value="<?php echo !empty($data['full_name']) ? $data['full_name'] : ''; ?>"/>
                        <?php if (!empty($errors['full_name'])) {
                            echo '<p class="color-error">' . $errors['full_name'] . '</p>';
                        } ?>
                    </td>
                </tr>
            </table>
            <input type="submit" name="register_member" value="Register" />
        </form>
    </body>
</html>
