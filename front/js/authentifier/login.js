import { SessionService } from "../SessionService.js";

document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const username = document.getElementById('usernameInput').value;
    const password = document.getElementById('passwordInput').value;
    const universe = document.getElementById('universSelect').value;

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
            if (data.success) {
                
                const sessionData = {
                    id_Player: data.id_Player,
                    pseudo: data.pseudo,
                    id_Univers: data.id_Univers,
                    id_Planets: data.id_Planetes,
                    id_Ressources: data.id_Ressources
                };
                
                const sessionService = new SessionService();
                sessionService.setSessionData(sessionData);

                sessionStorage.setItem('sessionService', JSON.stringify(sessionService));                

                window.location.href = './galaxy.html';

            } else {
                const errorMessage = data.message || 'Login failed';
                console.log(errorMessage);
            }
        })
        .catch(error => {
            console.error(error);
        });
});
