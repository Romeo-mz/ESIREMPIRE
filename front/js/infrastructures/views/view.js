import { Observer } from "../pattern/observer.js";
import { Installation } from "../models/installation.js";
import { Ressource } from "../models/ressource.js";
import { Defense } from "../models/defense.js";

export class View extends Observer 
{
    #controller;

    constructor(controller) 
    {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);
    }

    update() 
    {
        console.log("update");
        const infrastructures = this.#controller.infrastructures;
        console.log(infrastructures);

        infrastructures.forEach(infra => {

            if(infra instanceof Defense) {
                this.createOrUpdateInfrastructureElement(infra, "div-list-defenses");
            }
            else if(infra instanceof Installation) {
                this.createOrUpdateInfrastructureElement(infra, "div-list-installations");
            }
            else if(infra instanceof Ressource) {
                this.createOrUpdateInfrastructureElement(infra, "div-list-ressources");
            }
            
        });
    }

    createOrUpdateInfrastructureElement(infrastructure, parentDivId) 
    {        
        const prefix = infrastructure.type.toLowerCase();

        let div = this.createOrUpdateElement("div", `div-${prefix}-${infrastructure.id}`, "div-infrastructure");
        let div_information = this.createOrUpdateElement("div", `div-${prefix}-information-${infrastructure.id}`, "div-infrastructure-information");
        let div_image = this.createOrUpdateElement("div", `div-${prefix}-image-${infrastructure.id}`, "div-infrastructure-image");
        let img = this.createOrUpdateElement("img", `img-${prefix}-${infrastructure.id}`, "img-infrastructure");
        img.src = this.getImageSrcForType(infrastructure.type);

        let div_information_type = null;
        let div_information_level = null;
        let div_information_metal = null;
        let div_information_energie = null;

        if(prefix === "defense") 
        {
            // this.#type_defense = type_defense;
            // this.#cout_metal = cout_metal;
            // this.#cout_energie = cout_energie;
            // this.#cout_deuterium = cout_deuterium;
            // this.#temps_construction = temps_construction;
            // this.#point_attaque = point_attaque;
            // this.#point_defense = point_defense;

            div_information_type = this.createOrUpdateElement("div", `div-${prefix}-type-${infrastructure.id}`, "div-infrastructure-type", infrastructure.type_defense);
            div_information_level = this.createOrUpdateElement("div", `div-${prefix}-level-${infrastructure.id}`, "div-infrastructure-level", "Niveau: " + infrastructure.level);
            div_information_metal = this.createOrUpdateElement("div", `div-${prefix}-metal-${infrastructure.id}`, "div-infrastructure-metal", "Métal: " + infrastructure.metal);
            div_information_energie = this.createOrUpdateElement("div", `div-${prefix}-energie-${infrastructure.id}`, "div-infrastructure-energie", "Energie: " + infrastructure.energie);
        }
        else if(prefix === "installation") 
        {
            div_information_type = this.createOrUpdateElement("div", `div-${prefix}-type-${infrastructure.id}`, "div-infrastructure-type", infrastructure.type_installation);
            div_information_level = this.createOrUpdateElement("div", `div-${prefix}-level-${infrastructure.id}`, "div-infrastructure-level", "Niveau: " + infrastructure.level);
            div_information_metal = this.createOrUpdateElement("div", `div-${prefix}-metal-${infrastructure.id}`, "div-infrastructure-metal", "Métal: " + infrastructure.metal);
            div_information_energie = this.createOrUpdateElement("div", `div-${prefix}-energie-${infrastructure.id}`, "div-infrastructure-energie", "Energie: " + infrastructure.energie);
        }
        else if(prefix === "ressource") 
        {
            div_information_type = this.createOrUpdateElement("div", `div-${prefix}-type-${infrastructure.id}`, "div-infrastructure-type", infrastructure.type_ressource);
            div_information_level = this.createOrUpdateElement("div", `div-${prefix}-level-${infrastructure.id}`, "div-infrastructure-level", "Niveau: " + infrastructure.level);
            div_information_metal = this.createOrUpdateElement("div", `div-${prefix}-metal-${infrastructure.id}`, "div-infrastructure-metal", "Métal: " + infrastructure.metal);
            div_information_energie = this.createOrUpdateElement("div", `div-${prefix}-energie-${infrastructure.id}`, "div-infrastructure-energie", "Energie: " + infrastructure.energie);
        }

        let div_upgrade = this.createOrUpdateElement("div", `div-${prefix}-upgrade-${infrastructure.id}`, "div-infrastructure-upgrade");
        let button_upgrade = this.createOrUpdateElement(
            "button",
            `upgrade-button-${prefix}-${infrastructure.id}`,
            "upgrade-button",
            infrastructure.level === 0 ? "Construire <br>" + infrastructure.temps + "s" : "Améliorer <br> " + infrastructure.temps + "s"
        );

        button_upgrade.addEventListener("click", () =>
        {
            this.#controller.upgradeInfrastructure(infrastructure.id);
        });

        div_image.appendChild(img);
        div_information.appendChild(div_information_type);
        div_information.appendChild(div_information_level);
        div_information.appendChild(div_information_metal);
        div_information.appendChild(div_information_energie);
        div_upgrade.appendChild(button_upgrade);

        div.appendChild(div_image);
        div.appendChild(div_information);
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
            case "Chantier spatial":
                return "img/chantier-spatial.webp";
            case "Laboratoire":
                return "img/laboratoire.webp";
            case "Usine de nanites":
                return "img/usine-nanites.webp";
            case "Mine de metal":
                return "img/mine-metal.webp";
            case "Synthetiseur de deuterium":
                return "img/synthetiseur-deuterium.webp";
            case "Centrale solaire":
                return "img/centrale-solaire.webp";
            case "Centrale a fusion":
                return "img/centrale-fusion.webp";
            case "Artillerie laser":
                return "img/artillerie.webp";
            case "Canon a ions":
                return "img/canon.webp";
            case "Bouclier":
                return "img/bouclier.webp";
            default:
                return "";
        }
    }

    notify() 
    {
        this.update();
    }

}