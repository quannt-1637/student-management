<?php

require './students.php';

$classes = getMasterData('class');

if (!empty($_POST['add_student'])) {
    $data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
    $data['class'] = isset($_POST['class']) ? $_POST['class'] : '';
    $data['sex'] = isset($_POST['sex']) ? $_POST['sex'] : '';
    $data['birthday'] = isset($_POST['birthday']) ? $_POST['birthday'] : '';
    $data['subjects'][0] = isset($_POST['subject_math']) ? $_POST['subject_math'] : '';
    $data['subjects'][1] = isset($_POST['subject_physics']) ? $_POST['subject_physics'] : '';
    $data['subjects'][2] = isset($_POST['subject_chemistry']) ? $_POST['subject_chemistry'] : '';

    // Validate
    $errors = [];
    if (empty($data['name'])) {
        $errors['student_name'] = 'The student name required';
    }

    if (empty($data['class'])) {
        $errors['student_class'] = 'Class of student not selected';
    }

    if (empty($data['sex'])) {
        $errors['student_sex'] = 'Student gender not selected';
    }

    if (empty($data['birthday'])) {
        $errors['student_birthday'] = 'The student birthday required';
    }

    if (empty($data['subjects'][0])) {
        $errors['subject_math'] = 'Score math required';
    }

    if (empty($data['subjects'][1])) {
        $errors['subject_physics'] = 'Score physics required';
    }

    if (empty($data['subjects'][2])) {
        $errors['subject_chemistry'] = 'Score chemistry required';
    }

    if (!$errors) {
        addStudent(
            $data['name'],
            $data['sex'],
            $data['birthday'],
            $data['class'],
            $data['subjects']
        );

        header('location: index.php');
    }
}

disconnectDatabase();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Student</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./resources/css/index.css">
    </head>

    <body>
        <h1>Add Student</h1>
        <a href="index.php">Back</a>
        <br/><br/>
        <form method="POST" action="add.php">
            <table class="table table-border width-table">
                <tr>
                    <td class="table-border">Name</td>
                    <td class="table-border">G
                        <input type="text" name="name"
                               value="<?php echo !empty($data['name']) ? $data['name'] : ''; ?>"/>
                        <?php if (!empty($errors['student_name'])) {
                            echo '<p class="color-error">' . $errors['student_name'] . '</p>';
                        } ?>
                    </td>
                </tr>

                <tr>
                    <td class="table-border">Class</td>
                    <td class="table-border">
                        <select name="class">
                            <?php
                            foreach ($classes as $val) {
                                echo '<option value="' . $val['id'] . '">' . $val['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="table-border">Gender</td>
                    <td class="table-border">
                        <select name="sex">
                            <option value="Nam">Nam</option>
                            <option value="Nu">Nu</option>
                        </select>
                        <?php if (!empty($errors['student_sex'])) {
                            echo '<p class="color-error">'. $errors['student_sex'] . '</p>';
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td class="table-border">Birthday</td>
                    <td class="table-border">
                        <input type="text" name="birthday"
                               value="<?php echo !empty($data['birthday']) ? $data['birthday'] : ''; ?>"/>
                        <?php if (!empty($errors['student_birthday'])) {
                            echo '<p class="color-error">' . $errors['student_birthday'] . '</p>';
                        } ?>
                    </td>
                </tr>

                <tr>
                    <td class="table-border">Score</td>
                    <td class="table-border">
                        <p>
                            <label>Math: </label>
                            <input type="text" name="subject_math"
                                   value="<?php echo !empty($data['subject_math']) ? $data['subject_math'] : ''; ?>"/>
                            <?php if (!empty($errors['subject_math'])) {
                                echo '<p class="color-error">' . $errors['subject_math'] . '</p>';
                            } ?>
                        </p>
                        <p>
                            <label>Physics: </label>
                            <input type="text" name="subject_physics"
                                   value="<?php echo !empty($data['subject_physics']) ? $data['subject_physics'] : ''; ?>"/>
                            <?php if (!empty($errors['subject_physics'])) {
                                echo '<p class="color-error">' . $errors['subject_physics'] . '</p>';
                            } ?>
                        </p>
                        <p>
                            <label>Chemistry: </label>
                            <input type="text" name="subject_chemistry"
                                   value="<?php echo !empty($data['subject_chemistry']) ? $data['subject_chemistry'] : ''; ?>"/>
                            <?php if (!empty($errors['subject_chemistry'])) {
                                echo '<p class="color-error">' . $errors['subject_chemistry'] . '</p>';
                            } ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td class="table-border"></td>
                    <td class="table-border">
                        <input type="submit" name="add_student" value="Save"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
