import { Controller } from "../controllers/controller.js";
import { View } from "../views/view.js";

document.addEventListener("DOMContentLoaded", () => {
    const myController = new Controller();

    myController.loadVaisseaux()
        .then(() => {
            console.log("Success to load all vaisseaux")
            const myView = new View(myController);
            myController.loadFlotte()
                .then(() => {
                    console.log("Success to load flotte")
                    myController.notify();
                })
                .catch(error => {
                    alert("Error while loading vaisseaux - please refresh the page")
                });
        })
        .catch(error => {
            alert("Error while loading default vaisseaux - please refresh the page")
        });
});