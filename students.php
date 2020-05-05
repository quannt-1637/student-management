<?php
// Bien ket noi toan cuc
global $conn;

// Ham ket noi database
function connectDatabase()
{
    // Goi toi bien toan cuc $conn
    global $conn;

    // Neu chua ket noi thi thuc hien ket noi
    if (!$conn) {
        $conn = mysqli_connect('localhost', 'root', '123456', 'student_management') or die('Can\'t not connect to database');
        mysqli_set_charset($conn, 'utf8');
    }
}
 
// Ham ngat ket noi
function disconnectDatabase()
{
    // Goi toi bien toan cuc $conn
    global $conn;
     
    // Neu da ket noi thi thuc hien ngat ket noi
    if ($conn) {
        mysqli_close($conn);
    }
}

function getAllStudents()
{
    // Goi toi bien toan cuc $conn
    global $conn;

    connectDatabase();

    $sql = 'SELECT students.*, class.name as class_name FROM students INNER JOIN class ON students.id_class = class.id';

    // Thuc hien cau truy van
    $query = mysqli_query($conn, $sql);

    $result = [];
    // Lay tung ban ghi va dua vao bien result[]
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    return $result;
}
