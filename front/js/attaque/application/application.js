import { Controller } from "../controllers/controller.js";
import { View } from "../views/view-joueur.js";

document.addEventListener("DOMContentLoaded", async () => {
  const myController = new Controller();

  try {
    await myController.getFlotteJoueur();
    console.log("Success to load all vaisseaux");

    const myView = new View(myController);
    await myController.loadJoueurEnnemis();
    console.log("Success to load all ennemis");

    myController.notify();
  } catch (error) {
    console.error("An error occurred:", error);
  }
});
