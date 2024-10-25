document.getElementById('login-toggle').addEventListener('click', function() {
    document.getElementById('login-form').classList.add('active');
    document.getElementById('signup-form').classList.remove('active');
});

document.getElementById('signup-toggle').addEventListener('click', function() {
    document.getElementById('signup-form').classList.add('active');
    document.getElementById('login-form').classList.remove('active');
});

// Default to showing the signup form
document.getElementById('signup-toggle').click();