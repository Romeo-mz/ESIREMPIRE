import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";

document.addEventListener("DOMContentLoaded", () => {
    const myController = new Controller();
    // const myView = new View(myController);

    myController.loadDefaultTechnologies()
        .then(() => {
            console.log("Success to load default technologies")
            myController.loadLaboratoireID()
                .then(() => {
                    console.log("Success to load labo id")
                })
                .catch(error => {
                    alert("Error while loading labo id - please refresh the page")
                });
        })
        .catch(error => {
            alert("Error while loading default technologies - please refresh the page")
        });
    

    
}); 