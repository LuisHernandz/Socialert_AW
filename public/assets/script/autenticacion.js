function showAlert(message) {
    const alertBox = document.querySelector('.custom-alert');
    const alertMessage = document.getElementById('alertMessage');
    const overlay = document.querySelector('.alert-overlay');
    alertMessage.textContent = message;
    alertBox.style.display = 'block';
    overlay.style.display = 'block';
}

function hideAlert() {
    const alertBox = document.querySelector('.custom-alert');
    const overlay = document.querySelector('.alert-overlay');
    alertBox.style.display = 'none';
    overlay.style.display = 'none';
}

document.querySelector('.close-btn').addEventListener('click', hideAlert);

document.addEventListener('DOMContentLoaded', function() {
    const ids = ['email', 'password'];
    
    ids.forEach(function(id) {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('keypress', function(event) {
                const char = String.fromCharCode(event.keyCode || event.which);

                if (id === 'email') {
                    if (!/^[a-zA-Z0-9ñÑ@._-]+$/.test(char)) {
                        showAlert('Solo se permiten caracteres válidos en correos electrónicos.');
                        event.preventDefault();
                    }
                } else if (id === 'password') {
                    if (char === ' ') {
                        showAlert('No se permiten espacios en la contraseña.');
                        event.preventDefault();
                    }
                }
            });
        }
    });
});