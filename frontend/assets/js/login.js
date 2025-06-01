
$('#loginForm').on('submit', function (e) {
    e.preventDefault();

    const email = $('#email').val().trim();
    const password = $('#password').val().trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        $('#error-message').text('Please enter a valid email address.');
        return;
    }

    $.post('../backend/controllers/login.php', { email, password }, function (response) {
        if (response === 'admin') {
            window.location.href = 'admin.php';
        } else if (response === 'customer') {
            window.location.href = 'home.php';
        } else {
            $('#error-message').text(response);
        }
    });
});