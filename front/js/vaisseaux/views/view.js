import { Observer } from "../pattern/observer.js";
export class View extends Observer {
    #controller;

    constructor(controller) {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);

    }

    createVaisseaux() {
        return new Promise((resolve, reject) => {
            console.log("debug");

            const vaisseaux = this.#controller.vaisseaux;
            vaisseaux.forEach(vaisseau => {
                console.log(vaisseau);
                this.createVaisseauElement(vaisseau);
            });

            resolve(); // Resolve the promise after creating the vaisseaux
        });
    }

    createVaisseauElement(vaisseau) {
        let parentDivId = "spaceship-disponible-liste";

        let div = this.createOrUpdateElement("div", `spaceship-disponible-${vaisseau.id}`, "spaceship-disponible");
        let div_information = this.createOrUpdateElement("div", `spaceship-disponible-information-${vaisseau.id}`, "spaceship-disponible-information");
        let div_image = this.createOrUpdateElement("div", `spaceship-disponible-image-${vaisseau.id}`, "spaceship-disponible-image");
        let img = this.createOrUpdateElement("img", `spaceship-disponible-img-${vaisseau.id}`, "spaceship-disponible-img");

        let div_information_type = this.createOrUpdateElement("div", `spaceship-disponible-type-${vaisseau.id}`, "spaceship-disponible-type", "<b>" + vaisseau.type + "</b>");
        let div_information_quantite = this.createOrUpdateElement("div", `spaceship-disponible-quantite-${vaisseau.id}`, "spaceship-disponible-quantite", "<b>" + vaisseau.quantite + "</b>");

        img.src = this.getImageSrcForType(vaisseau.type);

        div_image.appendChild(img);
        div_information.appendChild(div_information_type);
        div_information.appendChild(div_information_quantite);
        div.appendChild(div_image);
        div.appendChild(div_information);

        document.getElementById(parentDivId).appendChild(div);
    }
    getSelectedVaisseaux() {
        const vaisseaux = this.#controller.vaisseaux;
        const selectedVaisseaux = [];

        vaisseaux.forEach(vaisseau => {
            const quantity = parseInt(document.getElementById(`nombre-${vaisseau.id}`).value);
            if (quantity > 0) {
                selectedVaisseaux.push({ ...vaisseau });
            }
        });

        return selectedVaisseaux;
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

    getImageSrcForType(type) {
        switch (type) {
            case "CHASSEUR":
                return "/front/img/chasseur.png";
            case "CROISEUR":
                return "/front/img/croiseur.png";
            case "TRANSPORTEUR":
                return "/front/img/transporteur.png";
            case "COLONISATEUR":
                return "/front/img/colonisateur.png";
            default:
                return "";
        }
    }

    notify() {
        // this.updateHistorique();
    }

}