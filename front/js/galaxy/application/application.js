import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";
import { SessionService } from "../../SessionService.js";

document.addEventListener("DOMContentLoaded", () => {
    const myController = new Controller();

    myController.loadPlanets(0,0)
        .then(() => {
            console.log("Success to load planets")
            const myView = new View(myController);
        })
        .catch(error => {
            alert("Error while loading planets - please refresh the page")
        });
    

    
}); 