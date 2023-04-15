<?php
    session_start();

    $host = 'localhost';
    $user = 'root';
    $password = 'mysql';
    $database = 'proyek_pw_6901_6906';
    $port = '3306';

    // TRY CONNECTING DATABASE
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_errno) {die("gagal connect : " . $conn->connect_error); }
?>