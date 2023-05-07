import { Observer } from "../pattern/observer.js";

export class View extends Observer 
{
    #controller;

    constructor(controller) 
    {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);
        this.update();
    }

    update() 
    {
        const infrastructures = this.#controller.getInfrastructures();

        for (const infrastructure of infrastructures) 
        {
            if (infrastructure.type_infrastructure === "Installation") 
            {
                this.createOrUpdateInfrastructureElement(infrastructure, "div-list-installations");
            } else if (infrastructure.type_infrastructure === "Ressource") 
            {
                this.createOrUpdateInfrastructureElement(infrastructure, "div-list-ressources");
            } else if (infrastructure.type_infrastructure === "Defense") 
            {
                this.createOrUpdateInfrastructureElement(infrastructure, "div-list-defenses");
            }
        }
    }

    createOrUpdateInfrastructureElement(infrastructure, parentDivId) 
    {
        const prefix = infrastructure.type_infrastructure.toLowerCase();

        let div = this.createOrUpdateElement("div", `div-${prefix}-${infrastructure.id}`, "div-infrastructure");
        let div_information = this.createOrUpdateElement("div", `div-${prefix}-information-${infrastructure.id}`, "div-infrastructure-information");
        let div_image = this.createOrUpdateElement("div", `div-${prefix}-image-${infrastructure.id}`, "div-infrastructure-image");
        let img = this.createOrUpdateElement("img", `img-${prefix}-${infrastructure.id}`, "img-infrastructure");
        img.src = this.getImageSrcForType(infrastructure.type);

        let div_information_type = this.createOrUpdateElement("div", `div-${prefix}-type-${infrastructure.id}`, "div-infrastructure-type", infrastructure.type);
        let div_information_level = this.createOrUpdateElement("div", `div-${prefix}-level-${infrastructure.id}`, "div-infrastructure-level", "Niveau: " + infrastructure.level);
        let div_information_metal = this.createOrUpdateElement("div", `div-${prefix}-metal-${infrastructure.id}`, "div-infrastructure-metal", "Métal: " + infrastructure.metal);
        let div_information_energie = this.createOrUpdateElement("div", `div-${prefix}-energie-${infrastructure.id}`, "div-infrastructure-energie", "Energie: " + infrastructure.energie);

        let div_upgrade = this.createOrUpdateElement("div", `div-${prefix}-upgrade-${infrastructure.id}`, "div-infrastructure-upgrade");
        let button_upgrade = this.createOrUpdateElement(
            "button",
            `button-${prefix}-upgrade-${infrastructure.id}`,
            "button-infrastructure-upgrade",
            infrastructure.level === 0 ? "Construire <br>" + infrastructure.temps + "s" : "Améliorer <br> " + infrastructure.temps + "s"
        );

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
            case "Mine de métal":
                return "img/mine-metal.webp";
            case "Chantier spatial":
                return "img/chantier-spatial.webp";
            case "Laboratoire":
                return "img/laboratory.webp";
            case "Synthétiseur de deutérium":
                return "img/synthetiseur-deuterium.webp";
            case "Bouclier":
                return "img/bouclier.webp";
            case "Usine de nanites":
                return "img/usine-nanites.webp";
            default:
                return "";
        }
    }

    notify() 
    {
        this.update();
    }

}