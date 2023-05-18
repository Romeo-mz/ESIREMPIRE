import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";

document.addEventListener("DOMContentLoaded", () => {
    const myController = new Controller();
    const myView = new View(myController);

    myController.loadDefaultTechnologies()
        .then(() => {
            console.log("Success to load default technologies")
            myController.loadLaboratoireID()
                .then(() => {
                    console.log("Success to load labo id")
                    myController.loadQuantitiesRessource()
                        .then(() => {
                            console.log("Success to load ressource quantities")
                            myController.loadTechnologies()
                                .then(() => {
                                    console.log("Success to load technologies")
                                    myController.notify();
                                })
                                .catch(error => {
                                    alert("Error while loading technologies - please refresh the page")
                                });
                        })
                        .catch(error => {
                            alert("Error while loading ressource quantities - please refresh the page")
                        });
                })
                .catch(error => {
                    alert("Error while loading labo id - please refresh the page")
                });
        })
        .catch(error => {
            alert("Error while loading default technologies - please refresh the page")
        });
    

    
}); 