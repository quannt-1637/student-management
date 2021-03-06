<?php

require 'database.php';

function getAllStudents()
{
    // Goi toi bien toan cuc $conn
    global $conn;

    $result = [];
    $newArray = [];
    $counter=0;

    connectDatabase();

    $sql = 'SELECT students.*, class.name AS class_name, subjects.name AS subject_name, student_subjects.score
                FROM students 
                INNER JOIN student_subjects ON student_subjects.id_student = students.id
                INNER JOIN subjects ON subjects.id = student_subjects.id_subject
                INNER JOIN class ON students.id_class = class.id';

    // Thuc hien cau truy van
    $query = mysqli_query($conn, $sql);

    // Lay tung ban ghi va dua vao bien result[]
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    foreach ($result as $key => $val) {
        $newArray[$val['id']]['id'] = $val['id'];
        $newArray[$val['id']]['name'] = $val['name'];
        $newArray[$val['id']]['id_class'] = $val['id_class'];
        $newArray[$val['id']]['sex'] = $val['sex'];
        $newArray[$val['id']]['birthday'] = $val['birthday'];
        $newArray[$val['id']]['class_name'] = $val['class_name'];
        $newArray[$val['id']]['subjects'][$counter]['subject_name'] = $val['subject_name'];
        $newArray[$val['id']]['subjects'][$counter]['score'] = $val['score'];
        $counter++;
    }

    return $newArray;
}

function getStudent($id)
{
    global $conn;
    $result = [];
    $newArray = [];
    $counter=0;

    connectDatabase();

    $sql = "SELECT students.*, class.name AS class_name, subjects.name AS subject_name, student_subjects.score
                FROM students 
                INNER JOIN student_subjects ON student_subjects.id_student = students.id
                INNER JOIN subjects ON subjects.id = student_subjects.id_subject
                INNER JOIN class ON students.id_class = class.id
                WHERE students.id = {$id}";

    $query = mysqli_query($conn, $sql);

    // Lay tung ban ghi va dua vao bien result[]
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    foreach ($result as $key => $val) {
        $newArray['id'] = $val['id'];
        $newArray['name'] = $val['name'];
        $newArray['id_class'] = $val['id_class'];
        $newArray['sex'] = $val['sex'];
        $newArray['birthday'] = $val['birthday'];
        $newArray['class_name'] = $val['class_name'];
        $newArray['subjects'][$counter]['subject_name'] = $val['subject_name'];
        $newArray['subjects'][$counter]['score'] = $val['score'];
        $counter++;
    }

    return $newArray;
}

function getMasterData($table)
{
    global $conn;
    $result = [];

    connectDatabase();

    $sql = 'SELECT * FROM ' . $table;

    // Thuc hien cau truy van
    $query = mysqli_query($conn, $sql);

    // Lay tung ban ghi va dua vao bien result[]
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    return $result;
}

function insertScoreStudent($studentName, $masterDataSubjects, $score)
{
    global $conn;

    connectDatabase();

    foreach ($masterDataSubjects as $key => $value) {
        $sql = "INSERT INTO student_subjects(id_student, id_subject, score)
                    SELECT students.id, subjects.id, {$score[$key]}
                    FROM students, subjects
                    WHERE students.name='{$studentName}' AND subjects.name='{$value['name']}'";
        mysqli_query($conn, $sql);
    }
}

function updateScoreStudent($id, $masterDataSubjects, $score)
{
    global $conn;

    connectDatabase();

    foreach ($masterDataSubjects as $key => $value) {
        $sql = "UPDATE student_subjects SET score = {$score[$key]}
                    WHERE id_student = {$id} AND id_subject = {$value['id']}";
        mysqli_query($conn, $sql);
    }
}

function addStudent($name, $sex, $birthday, $class, $subjects)
{
    global $conn;

    connectDatabase();

    // Chong SQL Injection
    $studentName = addslashes($name);
    $studentSex = addslashes($sex);
    $studentBirthday = addslashes($birthday);
    $class = addslashes($class);

    $sql = "INSERT INTO students(id_class, name, sex, birthday)
                VALUES ('$class', '$studentName', '$studentSex', '$studentBirthday')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $masterDataSubjects = getMasterData('subjects');
        insertScoreStudent($studentName, $masterDataSubjects, $subjects);
    }
}

function editStudent($id, $name, $sex, $birthday, $class, $subjects)
{
    global $conn;

    connectDatabase();

    $studentName = addslashes($name);
    $studentSex = addslashes($sex);
    $studentBirthday = addslashes($birthday);
    $class = addslashes($class);

    $sql = "UPDATE students SET
                id_class = {$class},
                name = '$studentName',
                sex = '$studentSex',
                birthday = '$studentBirthday'
                WHERE id = {$id}";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $masterDataSubjects = getMasterData('subjects');
        updateScoreStudent($id, $masterDataSubjects, $subjects);
    }

    return $query;
}

function deleteStudent($id)
{
    global $conn;

    connectDatabase();

    $sql = "DELETE students, student_subjects
            FROM students
            INNER JOIN student_subjects ON students.id = student_subjects.id_student
            WHERE students.id = $id";

    return mysqli_query($conn, $sql);
}
