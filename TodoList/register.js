document.addEventListener('DOMContentLoaded', function() {
    const registerButton = document.getElementById('register-button');
    const registerUsername = document.getElementById('register-username');
    const registerEmail = document.getElementById('register-email');
    const registerPassword = document.getElementById('register-password');
    const registerMessage = document.getElementById('register-message');

    registerButton.addEventListener('click', function() {
        const username = registerUsername.value;
        const email = registerEmail.value;
        const password = registerPassword.value;

        $.ajax({
            type: 'POST',
            url: 'register.php',
            data: {
                username: username,
                email: email,
                password: password
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    registerMessage.textContent = 'Registration successful.';
                    
               
                    window.location.href = 'login.html';
                } else {
                    registerMessage.textContent = 'Registration failed: ' + data.message;
                }
            }
        });
    });
});
