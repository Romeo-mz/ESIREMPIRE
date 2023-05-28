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
        
        
        
        const data = this.#controller.getDataEnnemis();
        // data.forEach((ennemi, index) => {
        //   const row = document.createElement('tr');
      
        //   const radioTd = document.createElement('td');
        //   const radioInput = document.createElement('input');
        //   radioInput.type = 'radio';
        //   radioInput.name = 'attaque';
        //   radioInput.value = index + 1;
        //   radioTd.appendChild(radioInput);
        //   row.appendChild(radioTd);
      
        //   Object.values(ennemi).forEach((value) => {
        //     const td = document.createElement('td');
        //     td.textContent = value;
        //     row.appendChild(td);
        //   });
      
        //   ennemisTableBody.appendChild(row);
        // });
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