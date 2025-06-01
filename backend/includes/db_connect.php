<?php
    $conn = new mysqli("localhost", "22121468", "Laobob123", "db_22121468");

    if ($conn->connect_error) {
        die("Database connection error: " . $conn->connect_error);
    }

    /* use this if not working
    $conn = new mysqli("localhost", "22142552", "wtbobdb!", "db_22122552");

    if ($conn->connect_error) {
        die("Database connection error: " . $conn->connect_error);
    }
    */
?>

