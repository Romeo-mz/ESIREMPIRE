import { Observer } from "../pattern/observer.js";
import { Technologie } from "../models/technologie.js";

export class View extends Observer 
{
    #controller;

    constructor(controller) 
    {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);

        this.createRessources();
        this.createTechnologies();
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

    createTechnologies() {
        const technologies = this.#controller.technologies;

        technologies.forEach(techno => {
            this.createTechnologieElements(techno);
        });
    }

    updateTechnologies() {
        const technologies = this.#controller.technologies;

        technologies.forEach(techno => {
            this.updateTechnologieElement(techno);
        });
    }

    updateTechnologieElement(technologie) {
        const idPrefix = `div-technologie`;
        const levelDiv = document.getElementById(`${idPrefix}-level-technologie-${technologie.id}`);
        console.log(`${idPrefix}-level-technologie-${technologie.id}`);

        // TRY TO FIX HERE
        levelDiv.innerHTML = "Niveau: " + technologie.level;
        const metalDiv = document.getElementById(`${idPrefix}-metal`);
        if (metalDiv) metalDiv.innerHTML = "Métal: " + technologie.cout_metal;
        const deuteriumDiv = document.getElementById(`${idPrefix}-deuterium`);
        deuteriumDiv.innerHTML = "Deuterium: " + technologie.cout_deuterium;
        const buttonUpgrade = document.getElementById(`upgrade-technologie-button-${technologie.id}`);
        buttonUpgrade.innerHTML = technologie.level === "0" ? "Construire <br>" + technologie.temps_recherche + "s" : "Améliorer <br> " + technologie.temps_recherche + "s";
    }

    createTechnologieElements(technologie) 
    {
        let parentDivId = "div-list-technologies";

        let div = this.createOrUpdateElement("div", `div-technologie-${technologie.id}`, "div-technologie");
        let div_information = this.createOrUpdateElement("div", `div-technologie-information-${technologie.id}`, "div-technologie-information");
        let div_image = this.createOrUpdateElement("div", `div-technologie-image-${technologie.id}`, "div-technologie-image");
        let img = this.createOrUpdateElement("img", `img-technologie-${technologie.id}`, "img-technologie");

        let div_information_type = null;
        let div_information_level = null;
        let div_information_metal = null;
        let div_information_deuterium = null;

        img.src = this.getImageSrcForType(technologie.type);

        div_information_type = this.createOrUpdateElement("div", `div-technologie-type-technologie-${technologie.id}`, "div-technologie-type", "<b>" + technologie.type + "</b>");
        div_information_level = this.createOrUpdateElement("div", `div-technologie-level-technologie-${technologie.id}`, "div-technologie-level", "Niveau: " + technologie.level);
        if(technologie.cout_metal !== null)
            div_information_metal = this.createOrUpdateElement("div", `div-technologie-metal-technologie-${technologie.id}`, "div-technologie-metal", "Métal: " + technologie.cout_metal);
        div_information_deuterium = this.createOrUpdateElement("div", `div-technologie-deuterium-technologie-${technologie.id}`, "div-technologie-deuterium", "Deuterium: " + technologie.cout_deuterium);

        let div_upgrade = this.createOrUpdateElement("div", `div-technologie-upgrade-technologie-${technologie.id}`, "div-technologie-upgrade");
        let button_upgrade = this.createOrUpdateElement(
            "button",
            `upgrade-technologie-button-technologie-${technologie.id}`,
            "upgrade-button",
            technologie.level === "0" ? "Construire <br>" + technologie.temps_recherche + "s" : "Améliorer <br> " + technologie.temps_recherche + "s"
        );

        button_upgrade.addEventListener("click", () =>
        {
            button_upgrade.disabled = true;
            button_upgrade.innerHTML = "En cours...<br>" + technologie.temps_recherche + "s";
            setTimeout(() => {
                this.#controller.upgradeTechnologie(technologie.id, technologie.type);
            }, technologie.temps_recherche * 1000);
        });
        

        div_image.appendChild(img);
        div_information.appendChild(div_information_type);
        div_information.appendChild(div_information_level);
        if(technologie.cout_metal !== null)
            div_information.appendChild(div_information_metal);
        div_information.appendChild(div_information_deuterium);
        div_upgrade.appendChild(button_upgrade);

        div.appendChild(div_image);
        div.appendChild(div_information);

        const technoRequired = this.#controller.technoRequired;
        const technoPlayer = this.#controller.technologies;

        (technoRequired).forEach(technorequired => {
            if(technorequired.techno === technologie.type) 
            {
                let techno = technoPlayer.find(techno => techno.type === technorequired.technoRequired);

                if(techno === undefined || techno.level < technorequired.technoRequiredLevel)
                {
                    let div_strip_techno_required_list = this.createOrUpdateElement("div", `div-strip-techno-required-list-technologie-${technologie.id}`, "strip-techno-required-list");
                    let div_strip_techno_required_list_item = this.createOrUpdateElement("div", `div-strip-techno-required-list-item-technologie-${technologie.id}`, "strip-techno-required-list-item");
                    let div_strip_techno_required_list_item_title = this.createOrUpdateElement("div", `div-strip-techno-required-list-item-title-technologie-${technologie.id}`, "strip-techno-required-list-item-title");
                    let div_strip_techno_required_list_item_content = this.createOrUpdateElement("div", `div-strip-techno-required-list-item-content-technologie-${technologie.id}`, "strip-techno-required-list-item-content");
                    let h4_strip_techno_required_list_item_title = this.createOrUpdateElement("h4", `h4-strip-techno-required-list-item-title-technologie-${technologie.id}`, "strip-techno-required-list-item-title", technorequired.technoRequired);
                    let p_strip_techno_required_list_item_content = this.createOrUpdateElement("p", `p-strip-techno-required-list-item-content-technologie-${technologie.id}`, "strip-techno-required-list-item-content", "Niveau: " + technorequired.technoRequiredLevel);

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
            case "ENERGIE":
                return "img/techno-energie.png";
            case "LASER":
                return "img/techno-laser.png";
            case "IONS":
                return "img/techno-ions.png";
            case "IA":
                return "img/techno-ia.png";
            case "BOUCLIER":
                return "img/techno-bouclier.png";
            case "ARMEMENT":
                return "img/techno-armement.png";
            default:
                return "";
        }
    }

    notify() 
    {
        this.updateTechnologies();
        this.updateRessources();
    }

}