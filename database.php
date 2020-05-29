<?php
// Bien ket noi toan cuc
global $conn;

// Ham ket noi database
function connectDatabase()
{
    global $conn;

    if (!$conn) {
        $conn = mysqli_connect('localhost', 'root', '123456', 'student_management')
        or die('Can\'t not connect to database');
        mysqli_set_charset($conn, 'utf8');
    }
}

// Ham ngat ket noi
function disconnectDatabase()
{
    global $conn;

    if ($conn) {
        mysqli_close($conn);
    }
}
