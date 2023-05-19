import { Observer } from "../pattern/observer.js";

export class View extends Observer 
{
    #controller;

    constructor(controller) 
    {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);

        this.createRessources();
        this.createShips();
    }   

    createRessources() {
        const ressources = this.#controller.quantiteRessource;
        
        ressources.forEach(ressource => {
            this.createRessourceElement(ressource);
        });
    }
    
    updateRessources() {
        const ressources = this.#controller.quantiteRessource;

        ressources.forEach(ressource => {
            this.updateRessourceElement(ressource);
        });
    }
    
    createRessourceElement(ressource) {
        const prefix = ressource.type.toLowerCase();

        let div = this.createOrUpdateElement("div", `div-${prefix}`, "div-ressource");
        let img = this.createOrUpdateElement("img", `img-${prefix}`, "img-ressource");
        let p = this.createOrUpdateElement("p", `p-${prefix}`, "number-ressource", ressource.quantite);

        img.src = `img/${prefix}.png`;
        img.alt = prefix;

        div.appendChild(img);
        div.appendChild(p);

        document.getElementById("div-ressources").appendChild(div);
    }
    
    updateRessourceElement(ressource) {
        const prefix = ressource.type.toLowerCase();
        let p = document.getElementById(`p-${prefix}`);
        p.innerHTML = ressource.quantite;
    }

    createShips() {
        const ships = this.#controller.ships;

        ships.forEach(ship => {
            this.createShipElements(ship);
        });
    }

    getShipElementId(elementType, shipId) {
        const idPrefix = 'div-ship';
        return `${idPrefix}-${elementType}-ship-${shipId}`;
    }
    
    updateShip(id) {
        const ships = this.#controller.ships;
        const ship = ships.find(ship => ship.id === id);
        this.updateShipElement(ship);
    }
    
    updateShipElement(ship) {    
        const quantiteDiv = document.getElementById(this.getShipElementId('quantite', ship.id));
        quantiteDiv.innerHTML = `Quantité: ${ship.quantite}`;

        const buttonUpgrade = document.getElementById(`upgrade-ship-button-ship-${ship.id}`);
        buttonUpgrade.innerHTML = `Construire <br>${ship.temps_construction}s`;
        buttonUpgrade.disabled = false;
    }

    createShipElements(ship) 
    {
        let parentDivId = "div-list-ships";

        let div = this.createOrUpdateElement("div", `div-ship-${ship.id}`, "div-ship");
        let div_information = this.createOrUpdateElement("div", `div-ship-information-${ship.id}`, "div-ship-information");
        let div_image = this.createOrUpdateElement("div", `div-ship-image-${ship.id}`, "div-ship-image");
        let img = this.createOrUpdateElement("img", `img-ship-${ship.id}`, "img-ship");

        let div_information_type = null;
        let div_information_quantite = null;
        let div_information_metal = null;
        let div_information_deuterium = null;
        let div_point_attaque = null;
        let div_point_defense = null;
        let div_capacite_fret = null;

        img.src = this.getImageSrcForType(ship.type);

        div_information_type = this.createOrUpdateElement("div", `div-ship-type-ship-${ship.id}`, "div-ship-type", "<b>" + ship.type + "</b>");
        div_information_quantite = this.createOrUpdateElement("div", `div-ship-quantite-ship-${ship.id}`, "div-ship-quantite", "Quantité: " + ship.quantite);
        div_information_metal = this.createOrUpdateElement("div", `div-ship-metal-ship-${ship.id}`, "div-ship-metal", "Métal: " + ship.cout_metal);
        div_information_deuterium = this.createOrUpdateElement("div", `div-ship-deuterium-ship-${ship.id}`, "div-ship-deuterium", "Deuterium: " + ship.cout_deuterium);
        div_point_attaque = this.createOrUpdateElement("div", `div-ship-point-attaque-ship-${ship.id}`, "div-ship-point-attaque", "Point d'attaque: " + ship.point_attaque);
        div_point_defense = this.createOrUpdateElement("div", `div-ship-point-defense-ship-${ship.id}`, "div-ship-point-defense", "Point de défense: " + ship.point_defense);
        if(ship.capacite_fret != null)
            div_capacite_fret = this.createOrUpdateElement("div", `div-ship-capacite-fret-ship-${ship.id}`, "div-ship-capacite-fret", "Capacité de fret: " + ship.capacite_fret);

        let div_upgrade = this.createOrUpdateElement("div", `div-ship-upgrade-ship-${ship.id}`, "div-ship-upgrade");
        let button_upgrade = this.createOrUpdateElement(
            "button",
            `upgrade-ship-button-ship-${ship.id}`,
            "upgrade-button",
            "Construire <br>" + ship.temps_construction + "s"
        );

        button_upgrade.addEventListener("click", () => {
            button_upgrade.disabled = true;
            let remainingTime = ship.temps_construction;
            button_upgrade.innerHTML = "En cours...<br>" + remainingTime + "s";
        
            const intervalId = setInterval(() => {
                remainingTime--;
                button_upgrade.innerHTML = "En cours...<br>" + remainingTime + "s";
                if (remainingTime === 0) {
                    clearInterval(intervalId);
                    this.#controller.addShip(ship.id, ship.type);
                }
            }, 1000);
        });
        
        div_image.appendChild(img);
        div_information.appendChild(div_information_type);
        div_information.appendChild(div_information_quantite);
        div_information.appendChild(div_information_metal);
        div_information.appendChild(div_information_deuterium);
        div_information.appendChild(div_point_attaque);
        div_information.appendChild(div_point_defense);
        if(ship.capacite_fret != null)
            div_information.appendChild(div_capacite_fret);
        div_upgrade.appendChild(button_upgrade);

        div.appendChild(div_image);
        div.appendChild(div_information);

        const shipTechnoRequired = this.#controller.shipTechnoRequired;
        const technoPlayer = this.#controller.technologiesPlayer;        

        (shipTechnoRequired).forEach(shiptechno => {
            if(shiptechno.type === ship.type) 
            {

                let techno = technoPlayer.find(techno => techno.type === shiptechno.technoRequired);
                
                if(techno === undefined || techno.level < shiptechno.technoRequiredLevel)
                {
                    let div_strip_techno_required_list = this.createOrUpdateElement("div", `div-strip-techno-required-list-spacework-${ship.id}`, "strip-techno-required-list");
                    let div_strip_techno_required_list_item = this.createOrUpdateElement("div", `div-strip-techno-required-list-item-spacework-${ship.id}`, "strip-techno-required-list-item");
                    let div_strip_techno_required_list_item_title = this.createOrUpdateElement("div", `div-strip-techno-required-list-item-title-spacework-${ship.id}`, "strip-techno-required-list-item-title");
                    let div_strip_techno_required_list_item_content = this.createOrUpdateElement("div", `div-strip-techno-required-list-item-content-spacework-${ship.id}`, "strip-techno-required-list-item-content");
                    let h4_strip_techno_required_list_item_title = this.createOrUpdateElement("h4", `h4-strip-techno-required-list-item-title-spacework-${ship.id}`, "strip-techno-required-list-item-title", shiptechno.technoRequired);
                    let p_strip_techno_required_list_item_content = this.createOrUpdateElement("p", `p-strip-techno-required-list-item-content-spacework-${ship.id}`, "strip-techno-required-list-item-content", "Niveau: " + shiptechno.technoRequiredLevel);

                    div_strip_techno_required_list_item_title.appendChild(h4_strip_techno_required_list_item_title);
                    div_strip_techno_required_list_item_content.appendChild(p_strip_techno_required_list_item_content);
                    div_strip_techno_required_list_item.appendChild(div_strip_techno_required_list_item_title);
                    div_strip_techno_required_list_item.appendChild(div_strip_techno_required_list_item_content);
                    div_strip_techno_required_list.appendChild(div_strip_techno_required_list_item);

                    button_upgrade.disabled = true;
                    button_upgrade.innerHTML = "Technologie requise";

                    div.appendChild(div_strip_techno_required_list);
                    
                }
            }
        });

        div.appendChild(div_upgrade);
        document.getElementById(parentDivId).appendChild(div);

    }


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

    getImageSrcForType(type) 
    {
        switch (type) 
        {
            case "CHASSEUR":
                return "img/chasseur.png";
            case "CROISEUR":
                return "img/croiseur.png";
            case "TRANSPORTEUR":
                return "img/transporteur.png";
            case "COLONISATEUR":
                return "img/colonisateur.png";
            default:
                return "";
        }
    }

    notify(id) 
    {
        this.updateShip(id);
        this.updateRessources();
    }

}