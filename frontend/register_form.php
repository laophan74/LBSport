<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    </head>
    <body>

        <?php include 'includes/topbar.php'; ?>

        <main class="container flex-grow-1 d-flex align-items-center justify-content-center py-5">
            <div class="container register-container mt-5 pt-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                        <div class="card p-4 shadow">
                            <h3 class="text-center mb-4">Register</h3>

                            <div id="message" class="alert d-none text-center mb-3" role="alert"></div>

                            <form id="registerForm">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Register</button>

                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-link" onclick="window.location.href='login_form.php'">Go to Login</button>
                                </div>
                            </form>
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
