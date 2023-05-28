import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";
import sessionDataService from '../../SessionDataService.js';

document.addEventListener("DOMContentLoaded", () => {

    if (sessionDataService.getSessionData() !== null) {
        const myController = new Controller();

        myController.loadPlanets(0,0)
            .then(() => {
                console.log("Success to load planets")
                const myView = new View(myController);
            })
            .catch(error => {
                alert("Error while loading planets - please refresh the page")
            });
    }
    else
        window.location.href = './login.php';

}); 