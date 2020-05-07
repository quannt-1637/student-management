<?php
require './students.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : '';

if ($id) {
    deleteStudent($id);
    disconnectDatabase();
}

header('location: index.php');
