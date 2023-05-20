import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";

document.addEventListener("DOMContentLoaded", () => {
    const myController = new Controller();

    myController.loadPlanets()
        .then(() => {
            console.log("Success to load planets")
            const myView = new View(myController);
        })
        .catch(error => {
            alert("Error while loading planets - please refresh the page")
        });
    

    
}); 