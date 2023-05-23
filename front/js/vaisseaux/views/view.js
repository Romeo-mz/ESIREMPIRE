import { Observer } from "../pattern/observer.js";
export class View extends Observer 
{
    #controller;

    constructor(controller) 
    {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);

        this.createVaisseaux();
    }   

    createVaisseaux()
    {
      const vaisseaux = this.#controller.vaisseaux;

      forEach(vaisseaux, (vaisseau) => {
        createVaisseauElement(vaisseau);
      });
    }

    createVaisseauElement(vaisseau){
        let parentDivId = "spaceship-disponible-liste";

        let div = this.createOrUpdateElement("div", `spaceship-disponible-${vaisseau.id}`, "div-vaisseau");

    }

    // getVaisseauById(vaisseauId) {
    //     return this.#controller.vaisseaux.find((vaisseau) => vaisseau.id === vaisseauId);
    // }

    // updateFlotte() {
    //     const flotteElement = document.querySelector(".spaceship-flotte");
    //     const flotteTitle = flotteElement.querySelector("#flotte-title");
    //     const spaceshipContainer = flotteElement.querySelector(".spaceship");
      
    //     const flotte = getFlotte(flotteElement);
      
    //     if (flotte.length === 0) {
    //       spaceshipContainer.innerHTML = "<p>Aucun vaisseau dans la flotte</p>";
    //     } else {

    //       spaceshipContainer.innerHTML = "";
    //       flotte.forEach((vaisseauId) => {
    //         const vaisseau = getVaisseauById(vaisseauId);
      
    //         const spaceshipElement = document.createElement("div");
    //         spaceshipElement.classList.add("spaceship");
    //         spaceshipElement.innerHTML = `
    //           <div class="spaceship-img">
    //             <img src="img/spaceship_01.png" alt="spaceship">
    //           </div>
    //           <div class="spaceship-infos">
    //             <h3 class="spaceship-name">Name: ${vaisseau.name}</h3>
    //             <p class="spaceship-attack">Attack: ${vaisseau.attack}</p>
    //           </div>
    //         `;
      
    //         spaceshipContainer.appendChild(spaceshipElement);
    //       });
    //     }
    //   }
    // getFlotte(flotteElement) {
    //     return flotteElement.dataset.flotte.split(",").map((vaisseauId) => parseInt(vaisseauId));
    // }

    // addVaisseau(vaisseauId) {
    //     addVaisseauToFlotte(vaisseauId);
      
    //     updateFlotte();
    //   }
 
    // removeVaisseau(vaisseauId) {
        
    //     removeVaisseauFromFlotte(vaisseauId);
      
    //     updateFlotte();
    //   }
    createOrUpdateElement(tagName, id, className, innerHTML = "") 
    {
        let element = document.getElementById(id);

        if (!element) 
        {
            element = document.createElement(tagName);
            element.id = id;
            element.className = className;
        }

        element.innerHTML = innerHTML;
        return element;
    }
    
    getImageSrcForType(type) {
        switch (type) {
            case "chasseur":
                return "img/chasseur.png";
            case "croiseur":
                return "img/croiseur.png";
            case "transporteur":
                return "img/transporteur.png";
            case "colonisateur":
                return "img/colonisateur.png";
            default:
                return "";
        }
    }

    notify() 
    { 
        // this.updateHistorique();
    }

}