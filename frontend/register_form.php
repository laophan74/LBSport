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

    <div class="container register-container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <div class="card p-4 shadow">
                    <h3 class="text-center mb-4">Register</h3>

                    <div id="message" class="text-center mb-2"></div>

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

    <?php include 'includes/footer.php'; ?>

    <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>

    <script>
        $('#registerForm').on('submit', function (e) {
            e.preventDefault();

            const username = $('#username').val().trim();
            const email = $('#email').val().trim();
            const password = $('#password').val().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                $('#message').text('Please enter a valid email address.').removeClass().addClass('error-message');
                return;
            }

            $.post('register.php', { username, email, password }, function (response) {
                if (response === 'success') {
                    $('#message').text('Registration successful!').removeClass().addClass('success-message');
                    $('#registerForm')[0].reset();
                } else {
                    $('#message').text(response).removeClass().addClass('error-message');
                }
            });
        });
    </script>

    </body>
</html>
