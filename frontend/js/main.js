document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = {
        username: document.getElementById('username').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    };

    fetch('/api/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "User was created.") {
            alert('Registration successful!');
        } else {
            alert('Failed to register user.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
