<?php
    require './students.php';

    $students = getAllStudents();
    disconnectDatabase();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>List Students</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./resources/css/index.css">
    </head>
    <body>
        <h1>List Students</h1>
        <a href="add.php">Add student</a> <br/> <br/>
        <table class="table table-border">
            <tr class="table-title">
                <td class="table-border">ID</td>
                <td class="table-border">Name</td>
                <td class="table-border">Class</td>
                <td class="table-border">Gender</td>
                <td class="table-border">Birthday</td>
                <td class="table-border">Score</td>
                <td class="table-border">Options</td>
            </tr>
            <?php foreach ($students as $item) { ?>
                <tr>
                    <td class="table-border"><?php echo $item['id']; ?></td>
                    <td class="table-border"><?php echo $item['name']; ?></td>
                    <td class="table-border"><?php echo $item['class_name']; ?></td>
                    <td class="table-border"><?php echo $item['sex']; ?></td>
                    <td class="table-border"><?php echo $item['birthday']; ?></td>
                    <td class="table-border">
                        <?php foreach ($item['subjects'] as $subject) {
                            echo $subject['subject_name'] . ': ' . $subject['score'] . '<br/>';
                        } ?>
                    </td>
                    <td class="table-border">
                        <form method="POST" action="#">
                            <input type="button" value="Edit"/>
                            <input type="hidden" name="id" value=""/>
                            <input type="submit" name="delete" value="Delete"/>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>
