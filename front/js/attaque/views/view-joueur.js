import { Observer } from "../pattern/observer.js";
export class View extends Observer {
    #controller;

    constructor(controller) {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);

        this.loadJoueurEnnemis();
    }

    loadJoueurEnnemis() {
      const ennemisTableBody = document.querySelector('#joueur-liste');
      ennemisTableBody.innerHTML = '';
      
      this.#controller.getDataEnnemis().then((data) => {
        data.forEach((ennemi, index) => {
          console.log(ennemi);
          const row = document.createElement('tr');
    
          const radioTd = document.createElement('td');
          const radioInput = document.createElement('input');
          radioInput.type = 'radio';
          radioInput.name = 'ennemi-' + ennemi.id; // Update to use a unique identifier
          radioInput.value = index;
          radioTd.appendChild(radioInput);
          row.appendChild(radioTd);
          
          const pseudoTd = document.createElement('td');
          pseudoTd.textContent = ennemi[index].pseudo;

          row.appendChild(pseudoTd);
    
          const galaxieTd = document.createElement('td');
          galaxieTd.textContent = ennemi[index].nom_galaxie;
          row.appendChild(galaxieTd);
    
          const systemeTd = document.createElement('td');
          systemeTd.textContent = ennemi[index].nom_systeme_solaire;
          row.appendChild(systemeTd);
    
          const planeteTd = document.createElement('td');
          planeteTd.textContent = ennemi[index].nom_planete;
          row.appendChild(planeteTd);
    
          const flotteTd = document.createElement('td');
          flotteTd.textContent = ennemi[index].flotte;
          row.appendChild(flotteTd);
    
          ennemisTableBody.appendChild(row);
        });
      });
    }
    
    

    createOrUpdateElement(tagName, id, className, innerHTML = "") {
        let element = document.getElementById(id);

        if (!element) {
            element = document.createElement(tagName);
            element.id = id;
            element.className = className;
        }

        element.innerHTML = innerHTML;
        return element;
    }


    
    notify() {
        this.loadJoueurEnnemis();
    }

}