import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";

document.addEventListener("DOMContentLoaded", () => {
    const myController = new Controller();
    const myView = new View(myController);

    myController.loadVaisseaux()
        .then(() => {
            console.log("Success to load all vaisseaux")
            // myController.loadFlotte()
            //     .then(() => {
            //         console.log("Success to load flotte")
            //         myController.notify();
            //     })
            //     .catch(error => {
            //         alert("Error while loading vaisseaux - please refresh the page")
            //     });
        })
        .catch(error => {
            alert("Error while loading default vaisseaux - please refresh the page")
        });
    });