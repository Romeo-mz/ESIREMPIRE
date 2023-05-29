import { Controller } from "../controllers/controller.js";
import { View } from "../views/view-joueur.js";

document.addEventListener("DOMContentLoaded", async () => {
  const myController = new Controller();

  try {
    await myController.getFlotteJoueur();
    console.log("Success to load all vaisseaux");

    
    await myController.loadJoueurEnnemis();
    console.log("Success to load all ennemis");

    const myView = new View(myController);
    // await myController.displayJoueurEnnemis();
    // console.log("Success to display all ennemis");
  
  } catch (error) {
    console.error("An error occurred:", error);
  }
});
