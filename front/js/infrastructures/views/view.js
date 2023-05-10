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
        const infrastructures = this.#controller.infrastructures;
        console.log(infrastructures);

        infrastructures.forEach(infra => {

            if(infra instanceof Defense) 
            {
                this.createOrUpdateInfrastructureElement(infra, "div-list-defenses");
            }
            else if(infra instanceof Installation) 
            {
                this.createOrUpdateInfrastructureElement(infra, "div-list-installations");
            }
            else if(infra instanceof Ressource) 
            {
                this.createOrUpdateInfrastructureElement(infra, "div-list-ressources");
            }
            
        });
    }

    createOrUpdateInfrastructureElement(infrastructure, parentDivId) 
    {        
        const prefix = infrastructure.type;

        let div = this.createOrUpdateElement("div", `div-${prefix}-${infrastructure.id}`, "div-infrastructure");
        let div_information = this.createOrUpdateElement("div", `div-${prefix}-information-${infrastructure.id}`, "div-infrastructure-information");
        let div_image = this.createOrUpdateElement("div", `div-${prefix}-image-${infrastructure.id}`, "div-infrastructure-image");
        let img = this.createOrUpdateElement("img", `img-${prefix}-${infrastructure.id}`, "img-infrastructure");
        

        if(infrastructure instanceof Installation) 
        {

            let div_information_type = null;
            let div_information_level = null;
            let div_information_metal = null;
            let div_information_energie = null;


            img.src = this.getImageSrcForType(infrastructure.type_installation);

            div_information_type = this.createOrUpdateElement("div", `div-${prefix}-type-installation-${infrastructure.id}`, "div-infrastructure-type", "<b>" + infrastructure.type_installation + "</b>");
            div_information_level = this.createOrUpdateElement("div", `div-${prefix}-level-installation-${infrastructure.id}`, "div-infrastructure-level", "Niveau: " + infrastructure.level);
            div_information_metal = this.createOrUpdateElement("div", `div-${prefix}-metal-installation-${infrastructure.id}`, "div-infrastructure-metal", "Métal: " + infrastructure.cout_metal);
            div_information_energie = this.createOrUpdateElement("div", `div-${prefix}-energie-installation-${infrastructure.id}`, "div-infrastructure-energie", "Energie: " + infrastructure.cout_energie);


            let div_upgrade = this.createOrUpdateElement("div", `div-${prefix}-upgrade-installation-${infrastructure.id}`, "div-infrastructure-upgrade");
            let button_upgrade = this.createOrUpdateElement(
                "button",
                `upgrade-installation-button-${prefix}-${infrastructure.id}`,
                "upgrade-button",
                infrastructure.level === 0 ? "Construire <br>" + infrastructure.temps_construction + "s" : "Améliorer <br> " + infrastructure.temps_construction + "s"
            );

            button_upgrade.addEventListener("click", () =>
            {
                this.#controller.upgradeInfrastructure(infrastructure.id, infrastructure.type_installation);
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
        else if(infrastructure instanceof Ressource) 
        {

            let div_information_type = null;
            let div_information_level = null;
            let div_information_metal = null;
            let div_information_energie = null;
            let div_information_deuterium = null;
            let div_production_metal = null;
            let div_production_energie = null;
            let div_production_deuterium = null;

            img.src = this.getImageSrcForType(infrastructure.type_ressource);

            div_information_type = this.createOrUpdateElement("div", `div-${prefix}-type-ressource-${infrastructure.id}`, "div-infrastructure-type", "<b>" + infrastructure.type_ressource + "</b>");
            div_information_level = this.createOrUpdateElement("div", `div-${prefix}-level-ressource-${infrastructure.id}`, "div-infrastructure-level", "Niveau: " + infrastructure.level);
            if (infrastructure.cout_metal !== null)
                div_information_metal = this.createOrUpdateElement("div", `div-${prefix}-metal-ressource-${infrastructure.id}`, "div-infrastructure-metal", "Métal: " + infrastructure.cout_metal);
            if (infrastructure.cout_energie !== null)
                div_information_energie = this.createOrUpdateElement("div", `div-${prefix}-energie-ressource-${infrastructure.id}`, "div-infrastructure-energie", "Energie: " + infrastructure.cout_energie);
            if (infrastructure.cout_deuterium !== null)
                div_information_deuterium = this.createOrUpdateElement("div", `div-${prefix}-deuterium-ressource-${infrastructure.id}`, "div-infrastructure-deuterium", "Deuterium: " + infrastructure.cout_deuterium);
            if(infrastructure.production_metal !== null)
                div_production_metal = this.createOrUpdateElement("div", `div-${prefix}-production-metal-ressource-${infrastructure.id}`, "div-infrastructure-production-metal", "Production métal: " + infrastructure.production_metal);
            if(infrastructure.production_energie !== null)
                div_production_energie = this.createOrUpdateElement("div", `div-${prefix}-production-energie-ressource-${infrastructure.id}`, "div-infrastructure-production-energie", "Production énergie: " + infrastructure.production_energie);
            if(infrastructure.production_deuterium !== null)
                div_production_deuterium = this.createOrUpdateElement("div", `div-${prefix}-production-deuterium-ressource-${infrastructure.id}`, "div-infrastructure-production-deuterium", "Production deuterium: " + infrastructure.production_deuterium);


            let div_upgrade = this.createOrUpdateElement("div", `div-${prefix}-upgrade-ressource-${infrastructure.id}`, "div-infrastructure-upgrade");
            let button_upgrade = this.createOrUpdateElement(
                "button",
                `upgrade-ressource-button-${prefix}-${infrastructure.id}`,
                "upgrade-button",
                infrastructure.level === 0 ? "Construire <br>" + infrastructure.temps_construction + "s" : "Améliorer <br> " + infrastructure.temps_construction + "s"
            );

            button_upgrade.addEventListener("click", () =>
            {
                this.#controller.upgradeInfrastructure(infrastructure.id, infrastructure.type_ressource);
            });

            div_image.appendChild(img);
            div_information.appendChild(div_information_type);
            div_information.appendChild(div_information_level);
            if(infrastructure.cout_metal !== null)
                div_information.appendChild(div_information_metal);
            if(infrastructure.cout_energie !== null)
                div_information.appendChild(div_information_energie);
            if(infrastructure.cout_deuterium !== null)
                div_information.appendChild(div_information_deuterium);
            if(infrastructure.production_metal !== null)
                div_information.appendChild(div_production_metal);
            if(infrastructure.production_energie !== null)
                div_information.appendChild(div_production_energie);
            if(infrastructure.production_deuterium !== null)
                div_information.appendChild(div_production_deuterium);
            div_upgrade.appendChild(button_upgrade);

            div.appendChild(div_image);
            div.appendChild(div_information);
            div.appendChild(div_upgrade);

            document.getElementById(parentDivId).appendChild(div);
        }
        else if(infrastructure instanceof Defense) 
        {

            let div_information_type = null;
            let div_information_level = null;
            let div_information_metal = null;
            let div_information_energie = null;
            let div_information_deuterium = null;
            let div_point_attaque = null;
            let div_point_defense = null;

            img.src = this.getImageSrcForType(infrastructure.type_defense);

            div_information_type = this.createOrUpdateElement("div", `div-${prefix}-type-defense-${infrastructure.id}`, "div-infrastructure-type", "<b>" + infrastructure.type_defense + "</b>");
            div_information_level = this.createOrUpdateElement("div", `div-${prefix}-level-defense-${infrastructure.id}`, "div-infrastructure-level", "Niveau: " + infrastructure.level);
            div_information_metal = this.createOrUpdateElement("div", `div-${prefix}-metal-defense-${infrastructure.id}`, "div-infrastructure-metal", "Métal: " + infrastructure.cout_metal);
            if(infrastructure.cout_energie !== null)
                div_information_energie = this.createOrUpdateElement("div", `div-${prefix}-energie-defense-${infrastructure.id}`, "div-infrastructure-energie", "Energie: " + infrastructure.cout_energie);
            div_information_deuterium = this.createOrUpdateElement("div", `div-${prefix}-deuterium-defense-${infrastructure.id}`, "div-infrastructure-deuterium", "Deuterium: " + infrastructure.cout_deuterium);
            div_point_attaque = this.createOrUpdateElement("div", `div-${prefix}-point-attaque-defense-${infrastructure.id}`, "div-infrastructure-point-attaque", "Point d'attaque: " + infrastructure.point_attaque);
            div_point_defense = this.createOrUpdateElement("div", `div-${prefix}-point-defense-defense-${infrastructure.id}`, "div-infrastructure-point-defense", "Point de défense: " + infrastructure.point_defense);


            let div_upgrade = this.createOrUpdateElement("div", `div-${prefix}-upgrade-defense-${infrastructure.id}`, "div-infrastructure-upgrade");
            let button_upgrade = this.createOrUpdateElement(
                "button",
                `upgrade-defense-button-${prefix}-${infrastructure.id}`,
                "upgrade-button",
                infrastructure.level === 0 ? "Construire <br>" + infrastructure.temps_construction + "s" : "Améliorer <br> " + infrastructure.temps_construction + "s"
            );

            button_upgrade.addEventListener("click", () =>
            {
                this.#controller.upgradeInfrastructure(infrastructure.id, infrastructure.type_defense);
            });

            div_image.appendChild(img);
            div_information.appendChild(div_information_type);
            div_information.appendChild(div_information_level);
            div_information.appendChild(div_information_metal);
            if(infrastructure.cout_energie !== null)
                div_information.appendChild(div_information_energie);
            div_information.appendChild(div_information_deuterium);
            div_information.appendChild(div_point_attaque);
            div_information.appendChild(div_point_defense);
            div_upgrade.appendChild(button_upgrade);

            div.appendChild(div_image);
            div.appendChild(div_information);
            div.appendChild(div_upgrade);

            document.getElementById(parentDivId).appendChild(div);
        }

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