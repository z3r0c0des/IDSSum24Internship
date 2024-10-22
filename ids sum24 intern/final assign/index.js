document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorMessage = document.getElementById('error-message');

        if (email === '' || password === '') {
            errorMessage.textContent = 'Please fill in all fields.';
            errorMessage.style.display = 'block';
        } else {
            this.submit(); // Submit the form if validation passes
        }
    });
});
