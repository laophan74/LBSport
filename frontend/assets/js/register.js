
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

    $.post('../backend/controllers/register.php', { username, email, password }, function (response) {
        if (response === 'success') {
            $('#message').text('Registration successful!').removeClass().addClass('success-message');
            $('#registerForm')[0].reset();
        } else {
            $('#message').text(response).removeClass().addClass('error-message');
        }
    });
});
