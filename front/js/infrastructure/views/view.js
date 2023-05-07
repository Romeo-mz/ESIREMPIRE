import { Observer } from "../pattern/observer.js";

export class View extends Observer 
{
    #controller;

    constructor(controller)
    {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);

        let infrastructures = this.#controller.getInfrastructures();

        // let div_installation_image = document.getElementById("div-installation-image");
        let div_installation_name = document.getElementById("div-installation-type");
        let div_installation_level = document.getElementById("div-installation-level");
        let div_installation_metal = document.getElementById("div-installation-metal");
        let div_installation_energie = document.getElementById("div-installation-energie");
        let div_installation_construire = document.getElementById("div-installation-construire");


        for (let infrastructure of infrastructures) 
        {
            let div_installation = document.createElement("div");
            div_installation.id = "div-installation-" + infrastructure.id;
            div_installation.className = "div-installation";

            let div_installation_image = document.createElement("div");
            div_installation_image.id = "div-installation-image-" + infrastructure.id;
            div_installation_image.className = "div-installation-image";
            div_installation_image.style.backgroundImage = "url('img/" + infrastructure.name + ".png')";

            let div_installation_name = document.createElement("div");
            div_installation_name.id = "div-installation-name-" + infrastructure.id;
            div_installation_name.className = "div-installation-name";
            div_installation_name.innerHTML = infrastructure.name;

            let div_installation_level = document.createElement("div");
            div_installation_level.id = "div-installation-level-" + infrastructure.id;
            div_installation_level.className = "div-installation-level";
            div_installation_level.innerHTML = infrastructure.level;

            let div_installation_metal = document.createElement("div");
            div_installation_metal.id = "div-installation-metal-" + infrastructure.id;
            div_installation_metal.className = "div-installation-metal";
            div_installation_metal.innerHTML = infrastructure.metal;

            let div_installation_energie = document.createElement("div");
            div_installation_energie.id = "div-installation-energie-" + infrastructure.id;
            div_installation_energie.className = "div-installation-energie";
            div_installation_energie.innerHTML = infrastructure.energie;

            let div_installation_construire = document.createElement("div");
            div_installation_construire.id = "div-installation-construire-" + infrastructure.id;
            div_installation_construire.className = "div-installation-construire";

            if(infrastructure.temps == 0) {
                div_installation_construire.innerHTML = "Construire";
            }
            else {
                div_installation_construire.innerHTML = "Améliorer<br>" + infrastructure.temps + "s";
            }

            // div_installation_construire.addEventListener("click", () => this.#controller.construire(infrastructure.id));

            div_installation.appendChild(div_installation_image);
            div_installation.appendChild(div_installation_name);
            div_installation.appendChild(div_installation_level);
            div_installation.appendChild(div_installation_metal);
            div_installation.appendChild(div_installation_energie);
            div_installation.appendChild(div_installation_construire);

            document.getElementById("div-installations").appendChild(div_installation);
        }

    }

    notify()
    {
        // document.getElementById("txt-counter").innerHTML = this.#controller.getCounterValue();
    }
}