document.addEventListener('DOMContentLoaded', function() {
    const loginButton = document.getElementById('login-button');
    const loginUsername = document.getElementById('login-username');
    const loginPassword = document.getElementById('login-password');
    const loginMessage = document.getElementById('login-message');

    loginButton.addEventListener('click', function() {
        const username = loginUsername.value;
        const password = loginPassword.value;

        $.ajax({
            type: 'POST',
            url: 'login.php',
            data: {
                username: username,
                password: password
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    loginMessage.textContent = 'Login successful.';
                    
                    
                    window.location.href = 'todo.html';
                } else {
                    loginMessage.textContent = 'Login failed: ' + data.message;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});
