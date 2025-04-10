<?php
    $host = "localhost";
    $user = "root";
    $pass = "mysql";
    $db = "miz2u_cafe";

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>