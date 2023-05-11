import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";

document.addEventListener("DOMContentLoaded", () => {
    const myController = new Controller();
    const myView = new View(myController);

    myController.loadDefaultInfrastructures()
        .then(() => {
            console.log("Success to load default infra")
            myController.loadInfrastructureFromAPI()
                .then(() => {
                    console.log("Success to load Infra")
                })
                .catch(error => {
                    console.log("Error while loading infra")
                });
        })
        .catch(error => {
            console.log("Error while loading default infra")
        });
    
}); 