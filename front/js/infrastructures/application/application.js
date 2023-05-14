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
                    myController.notify();
                })
                .catch(error => {
                    alert("Error while loading infra - please refresh the page")
                });
        })
        .catch(error => {
            alert("Error while loading default infra - please refresh the page")
        });
    
}); 