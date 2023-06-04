import { Controller } from "../controllers/controller.js";
import { View } from "../views/view-joueur.js";
import sessionDataService from '../../SessionDataService.js';

document.addEventListener("DOMContentLoaded", async () => {

  if (sessionDataService.getSessionData() !== null) {
    const btn = document.getElementById('btn-attaquer');
    
    const myController = new Controller();
    console.log("Success to load controller");
    
    btn.addEventListener('click', function() {
      myController.fetchAttaque();
       
    });
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
  }
  else
    window.location.href = './login.php';
    
});


