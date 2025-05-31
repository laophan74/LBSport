<?php
    $conn = new mysqli("localhost", "22121468", "Laobob123", "db_22121468");

    if ($conn->connect_error) {
        die("Database connection error: " . $conn->connect_error);
    }
?>
