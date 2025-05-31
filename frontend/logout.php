<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Logged Out</title>
        <meta http-equiv="refresh" content="3;url=login_form.php" />
        <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    </head>
    <body class="logoutpage">
        <div class="message-box">
            You have been logged out.<br />
            Redirecting to login page...
        </div>
    </body>
</html>
