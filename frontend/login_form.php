<?php 
session_start(); 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
    <title>Login</title> 

    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css" /> 
    <link rel="stylesheet" href="assets/css/main.css" /> 
    <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css" /> 
</head> 

<body class="d-flex flex-column min-vh-100"> 

    <?php include 'includes/topbar.php'; ?> 

    <main class="container login-container flex-grow-1 d-flex align-items-center justify-content-center py-5"> 
        <div class="row justify-content-center w-100"> 
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4"> 
                <div class="card p-4 shadow"> 
                    <h3 class="text-center mb-4">Login</h3> 

                    <div id="error-message" class="error-message text-center mb-2 text-danger"></div> 

                    <form id="loginForm"> 
                        <div class="mb-3"> 
                            <label for="email" class="form-label">Email</label> 
                            <input type="email" id="email" name="email" class="form-control" required /> 
                        </div> 

                        <div class="mb-3"> 
                            <label for="password" class="form-label">Password</label> 
                            <input type="password" id="password" name="password" class="form-control" required /> 
                        </div> 

                        <button type="submit" class="btn btn-primary w-100">Login</button> 
                    </form> 

                    <div class="text-center mt-3"> 
                        <button type="button" class="btn btn-link" onclick="window.location.href='register_form.php'">Register</button> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </main> 

    <?php include 'includes/footer.php'; ?> 

    <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script> 
    <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script> 
    <script src="assets/js/auth.js"></script>
</body> 
</html>
