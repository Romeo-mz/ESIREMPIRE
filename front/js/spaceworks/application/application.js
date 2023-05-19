import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";

document.addEventListener("DOMContentLoaded", () => {
    const myController = new Controller();

    myController.loadSpaceworkID()
        .then(() => {
            console.log("Success to load spaceworks id")
            if (myController.spaceWorksID == -1) {
                alert("You have to build a spaceworks")
                window.location.href = "./infrastructures.html";
                return;
            }
            myController.loadDefaultShips()
                .then(() => {
                    console.log("Success to load default ships")
                    myController.loadQuantitiesRessource()
                        .then(() => {
                            console.log("Success to load ressource quantities") 
                            myController.loadShips()
                                .then(() => {
                                    console.log("Success to load ships")
                                })
                                .catch(error => {
                                    alert("Error while loading ships - please refresh the page")
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


    // myController.loadLaboratoireID()
    //     .then(() => {
    //         console.log("Success to load labo id")
    //         if (myController.laboID == -1) {
    //             alert("You have to build a laboratory")
    //             window.location.href = "./infrastructures.html";
    //             return;
    //         }
    //         myController.loadDefaultTechnologies()
    //             .then(() => {
    //                 console.log("Success to load default technologies")
    //                 myController.loadQuantitiesRessource()
    //                     .then(() => {
    //                         console.log("Success to load ressource quantities")
    //                         myController.loadTechnologies()
    //                             .then(() => {
    //                                 console.log("Success to load technologies")
    //                                 myController.loadTechnoRequired()
    //                                     .then(() => {
    //                                         console.log("Success to load required technologies")
    //                                         const myView = new View(myController);
    //                                     })
    //                                     .catch(error => {
    //                                         alert("Error while loading required technologies - please refresh the page")
    //                                     });
    //                             })
    //                             .catch(error => {
    //                                 alert("Error while loading technologies - please refresh the page")
    //                             });
    //                     })
    //                     .catch(error => {
    //                         alert("Error while loading ressource quantities - please refresh the page")
    //                     });
    //             })
    //             .catch(error => {
    //                 alert("Error while loading default technologies - please refresh the page")
    //             });
    //     })
    //     .catch(error => {
    //         alert("Error while loading labo id - please refresh the page")
    //     });
    

    
}); 