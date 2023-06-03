import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";
import sessionDataService from '../../SessionDataService.js';

document.addEventListener("DOMContentLoaded", async () => {

    if (sessionDataService.getSessionData() !== null) {
    const myController = new Controller();
    const myView = new View(myController);
    
    myController.loadVaisseaux()
    .then(() => {
        console.log("Success to load vaisseaux");
        
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
    .then(() => {
        console.log("Success to load attaque");
        return myView.getResultatAttaque(1,1);
    })

}
    else
        window.location.href = './login.php';
        
});