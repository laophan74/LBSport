// LOGIN
$('#loginForm').on('submit', function (e) {
    e.preventDefault();

    const email = $('#email').val().trim();
    const password = $('#password').val().trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        $('#error-message').text('Please enter a valid email address.');
        return;
    }

    $.post('../backend/controllers/auth.php', {
        action: 'login',
        email: email,
        password: password
    }, function (response) {
        if (response.status === 'success') {
            if (response.role === 'admin') {
                window.location.href = 'admin.php';
            } else {
                window.location.href = 'home.php';
            }
        } else {
            $('#error-message').text(response.message);
        }
    }, 'json').fail(() => {
        $('#error-message').text('An error occurred. Please try again.');
    });
});

// Register
$('#registerForm').on('submit', function (e) {
    e.preventDefault();

    const username = $('#username').val().trim();
    const email = $('#email').val().trim();
    const password = $('#password').val().trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        $('#message').text('Please enter a valid email address.')
                     .removeClass()
                     .addClass('text-danger text-center mb-2');
        return;
    }

    $.post('../backend/controllers/auth.php', {
        action: 'register',
        username: username,
        email: email,
        password: password
    }, function (response) {
        if (response.status === 'success') {
            $('#message').text('Registration successful! Redirecting to login...')
                         .removeClass()
                         .addClass('text-success text-center mb-2');

            setTimeout(() => {
                window.location.href = 'login_form.php';
            }, 2000);
        } else {
            $('#message').text(response.message)
                         .removeClass()
                         .addClass('text-danger text-center mb-2');
        }
    }, 'json');
});

// Account update
$('#accountForm').on('submit', function (e) {
    e.preventDefault();

    const oldPassword = $('#oldPassword').val().trim();
    const newPassword = $('#newPassword').val().trim();

    if (!oldPassword || !newPassword) {
        $('#msg').text('Please fill in both password fields.')
                 .removeClass().addClass('text-danger');
        return;
    }

    $.post('../backend/controllers/auth.php', {
        action: 'update_password',
        oldPassword,
        newPassword
    }, function (res) {
        if (res.status === 'success') {
            $('#msg').text('Password updated successfully!')
                     .removeClass().addClass('text-success');
            $('#accountForm')[0].reset();
        } else {
            $('#msg').text(res.message)
                     .removeClass().addClass('text-danger');
        }
    }, 'json').fail(() => {
        $('#msg').text('Server error.').removeClass().addClass('text-danger');
    });
});




