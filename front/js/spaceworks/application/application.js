import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";
import sessionDataService from '../../SessionDataService.js';

document.addEventListener("DOMContentLoaded", () => {

    if (sessionDataService.getSessionData() !== null) {
        const myController = new Controller();

        myController.loadSpaceworkID()
            .then(() => {
                console.log("Success to load spaceworks id")
                if (myController.spaceWorksID == -1) {
                    alert("You have to build a spaceworks")
                    window.location.href = "./infrastructures.html";
                    return;
                }
                myController.loadShips()
                    .then(() => {
                        console.log("Success to load default ships")
                        myController.loadQuantitiesRessource()
                            .then(() => {
                                console.log("Success to load ressource quantities") 
                                myController.loadNbShips()
                                    .then(() => {
                                        console.log("Success to load nb ships")
                                        myController.loadTechnologiesPlayer()
                                            .then(() => {
                                                console.log("Success to load technologies player")
                                                const myView = new View(myController);
                                            })
                                            .catch(error => {
                                                alert("Error while loading technologies player - please refresh the page")
                                            });
                                    })
                                    .catch(error => {
                                        alert("Error while loading nb ships - please refresh the page")
                                    });
                            })
                            .catch(error => {
                                alert("Error while loading ressource quantities - please refresh the page")
                            });
                    })
                    .catch(error => {
                        alert("Error while loading default ships - please refresh the page")
                    });
            })
            .catch(error => {
                alert("Error while loading spaceworks id - please refresh the page")
            });
    }
    else
        window.location.href = './login.php';
    
}); 