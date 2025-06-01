function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function toggleEdit(fieldId, btn) {
    const $input = $('#' + fieldId);

    if (!$input.prop('readonly')) {
        $input.prop('readonly', true);
        $(btn).text('Edit')
            .removeClass('btn-outline-danger')
            .addClass('btn-outline-secondary');
        return;
    }

    $('#targetField').val(fieldId);
    $('#passwordModal').data('button', btn);
    $('#confirmPassword').val('');
    $('#confirmPassword').removeClass('is-invalid');

    const modal = new bootstrap.Modal(document.getElementById('passwordModal'));
    modal.show();
}

$('#passwordConfirmForm').on('submit', async function (e) {
    e.preventDefault();
    const password = $('#confirmPassword').val();
    const fieldId = $('#targetField').val();
    const $btn = $($('#passwordModal').data('button'));

    try {
        const response = await fetch('../backend/controllers/verify_password.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ password })
        });

        const result = await response.json();

        if (result.status === 'success') {
            $('#' + fieldId).prop('readonly', false).focus();
            $btn.text('Lock')
                .removeClass('btn-outline-secondary')
                .addClass('btn-outline-danger');

            bootstrap.Modal.getInstance(document.getElementById('passwordModal')).hide();
        } else {
            $('#confirmPassword').addClass('is-invalid');
        }
    } catch (error) {
        console.error('Password verification failed:', error);
        alert('Error occurred during verification.');
    }
});

document.getElementById('saveBtn').addEventListener('click', async function (e) {
    e.preventDefault();

    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();

    if (!username || !email) {
        alert('Username and email cannot be empty.');
        return;
    }

    if (!isValidEmail(email)) {
        alert('Please enter a valid email address.');
        return;
    }

    try {
        const res = await fetch('../backend/controllers/update_profile.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, email })
        });

        const result = await res.json();

        if (result.status === 'success') {
            alert('Profile updated successfully.');

            ['username', 'email'].forEach(fieldId => {
                const input = document.getElementById(fieldId);
                input.setAttribute('readonly', true);

                const btn = document.querySelector(`[onclick="toggleEdit('${fieldId}', this)"]`);
                if (btn) {
                    btn.textContent = 'Edit';
                    btn.classList.remove('btn-outline-danger');
                    btn.classList.add('btn-outline-secondary');
                }
            });
            location.reload();
        } else {
            alert(result.message || 'Update failed.');
        }
    } catch (error) {
        alert('Error occurred while updating profile.');
        console.error(error);
    }
});
