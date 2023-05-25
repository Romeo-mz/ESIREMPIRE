import { Observer } from "../pattern/observer.js";
export class View extends Observer {
    #controller;

    constructor(controller) {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);

        
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
        this.updateHistorique();
    }

}