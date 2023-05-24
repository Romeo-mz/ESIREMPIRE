import { sessionService } from '../SessionService.js';

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
            // Process login response
            if (data.success) {
                // Login successful, redirect to another page or perform further actions
                
                const sessionData = {
                    id_Player: data.id_Player,
                    pseudo: data.pseudo,
                    id_Univers: data.id_Univers,
                    id_Planets: data.id_Planetes,
                    id_Ressources: data.id_Ressources
                };
                
                // Set the session data using the SessionService
                sessionService.setSessionData(sessionData);

                console.log(sessionService);

            } else {
                // Login failed, display error message or take appropriate action
                const errorMessage = data.message || 'Login failed';
                console.log(errorMessage);
            }
        })
        .catch(error => {
            // Handle any errors
            console.error(error);
        });
});
