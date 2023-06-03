import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";
import sessionDataService from '../../SessionDataService.js';

document.addEventListener("DOMContentLoaded", async () => {

    if (sessionDataService.getSessionData() !== null) {
    const myController = new Controller();
    
    myController.loadVaisseaux()
    .then(() => {
        console.log("Success to load vaisseaux");
        const myView = new View(myController);
        return myView.createVaisseaux();
    })
    .then(() => {
        console.log("Success to create vaisseaux");
        return myController.loadFlotte();
    })
    .then(() => {
        console.log("Success to load flotte");
        myController.notify();
    })
    .catch(error => {
        if (error instanceof Error) {
            console.error(error);
        }
        alert("Error while loading data - please refresh the page");
    })
}
    else
        window.location.href = './login.php';
        
});