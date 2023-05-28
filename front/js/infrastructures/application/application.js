import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";
import sessionDataService from '../../SessionDataService.js';

document.addEventListener("DOMContentLoaded", () => {

    if (sessionDataService.getSessionData() !== null) {
        const myController = new Controller();
        const myView = new View(myController);

        myController.loadBonusRessources()
            .then(() => {
                console.log("Success to bonus ressource")
                myController.loadDefaultInfrastructures()
                    .then(() => {
                        console.log("Success to load default infra")
                        myController.loadInfrastructureFromAPI()
                            .then(() => {
                                console.log("Success to load Infra")
                                myController.loadQuantitiesRessource()
                                    .then(() => {
                                        console.log("Success to load quantities ressource")
                                        myController.loadTechnoRequired()
                                            .then(() => {
                                                console.log("Success to load techno required")
                                                myController.loadInfraTechnoRequired()
                                                    .then(() => {
                                                        console.log("Success to load infra techno required")
                                                        myController.loadTechnologies()
                                                            .then(() => {
                                                                console.log("Success to load techno")
                                                                myController.notify();
                                                            }
                                                            )
                                                            .catch(error => {
                                                                alert("Error while loading techno - please refresh the page")
                                                            }
                                                            );
                                                    }
                                                    )
                                                    .catch(error => {
                                                        alert("Error while loading infra techno required - please refresh the page")
                                                    }
                                                    );
                                            }
                                            )
                                            .catch(error => {
                                                alert("Error while loading techno required - please refresh the page")
                                            }
                                            );
                                    }
                                    )
                                    .catch(error => {
                                        alert("Error while loading quantities ressource - please refresh the page")
                                    }
                                    );

                            })
                            .catch(error => {
                                alert("Error while loading infra - please refresh the page")
                            });
                    })
                    .catch(error => {
                        alert("Error while loading default infra - please refresh the page")
                    });
            })
            .catch(error => {
                alert("Error while loading bonus ressource - please refresh the page")
            })
    }
    else
        window.location.href = './login.php';

}); 