import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";
import sessionDataService from '../../SessionDataService.js';

document.addEventListener("DOMContentLoaded", async () => {

    if (sessionDataService.getSessionData() !== null) {
    const myController = new Controller();

    myController.loadVaisseaux()
        .then(() => {
                console.log("Success to load vaisseaux")
            const myView = new View(myController)

            myView.createVaisseaux() . then (() => {
                myController.loadFlotte()
                    .then(() => {
                        console.log("Success to load flotte")
                        myController.notify();
                    })
                    .catch(error => {
                        alert("Error while loading flotte - please refresh the page")
                    });
                })
                .catch(error => {
                    alert("Error while loading vaisseaux - please refresh the page")
                });
        })
    }
    else
        window.location.href = './login.php';
        
});