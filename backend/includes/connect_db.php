<?php

$dbc = mysqli_connect("localhost", "22121468", "Comeflywithme016399", "db_22121468");

// Check connection
if (!$dbc) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
