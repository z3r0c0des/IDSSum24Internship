document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (email === '' || password === '') {
        alert('Please fill in all fields');
    } else {
        this.submit();
    }
});
