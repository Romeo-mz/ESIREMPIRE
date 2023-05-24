document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission

    // Retrieve input values
    const username = document.getElementById('usernameInput').value;
    const password = document.getElementById('passwordInput').value;
    const universe = document.getElementById('universSelect').value;

    // Perform login logic
    fetch('http://esirempire/api/boundary/APIinterface/APIlogin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: username,
            password: password,
            universe: universe
        })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête à l\'API');
            }
            return response.json();
        })
        .then(data => {
            // console.log(data.id_Player);
            // Process login response

            if (data.success) {
                // Login successful, redirect to another page or perform further actions
                console.log(data.id_Player);
            } else {
                // Login failed, display error message or take appropriate action
                const errorMessage = data.message || 'Login failed';
                console.log(errorMessage);
                //   document.getElementById('errorContainer').textContent = errorMessage;
            }
        })
        .catch(error => {
            // Handle any errors
            console.error(error);
        });
});
