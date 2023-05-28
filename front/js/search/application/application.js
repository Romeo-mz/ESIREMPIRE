import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";
import sessionDataService from '../../SessionDataService.js';

document.addEventListener("DOMContentLoaded", () => {

    if (sessionDataService.getSessionData() !== null) 
    {
        const myController = new Controller();

        myController.loadLaboratoireID()
            .then(() => {
                console.log("Success to load labo id")
                if (myController.laboID == -1) {
                    alert("You have to build a laboratory")
                    window.location.href = "./infrastructures.html";
                    return;
                }
                myController.loadDefaultTechnologies()
                    .then(() => {
                        console.log("Success to load default technologies")
                        myController.loadQuantitiesRessource()
                            .then(() => {
                                console.log("Success to load ressource quantities")
                                myController.loadTechnologies()
                                    .then(() => {
                                        console.log("Success to load technologies")
                                        myController.loadTechnoRequired()
                                            .then(() => {
                                                console.log("Success to load required technologies")
                                                const myView = new View(myController);
                                            })
                                            .catch(error => {
                                                alert("Error while loading required technologies - please refresh the page")
                                            });
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
                        alert("Error while loading default technologies - please refresh the page")
                    });
            })
            .catch(error => {
                alert("Error while loading labo id - please refresh the page")
            });
    }
    else
        window.location.href = './login.php';


    
    

    
}); 