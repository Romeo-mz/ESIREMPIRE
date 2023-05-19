import { Infrastructure } from "./infrastructure.js";

export class Ressource extends Infrastructure 
{
    #type_ressource;
    #cout_metal;
    #cout_energie;
    #cout_deuterium;
    #temps_construction;
    #production_metal;
    #production_energie;
    #production_deuterium;

    constructor(id, level, type_ressource, cout_metal, cout_energie, cout_deuterium, temps_construction, production_metal, production_energie, production_deuterium) {
        super(id, level, "RESSOURCE");
        this.#type_ressource = type_ressource;
        this.#cout_metal = cout_metal;
        this.#cout_energie = cout_energie;
        this.#cout_deuterium = cout_deuterium;
        this.#temps_construction = temps_construction;
        this.#production_metal = production_metal;
        this.#production_energie = production_energie;
        this.#production_deuterium = production_deuterium;
    }

    get type_ressource() { return this.#type_ressource; }
    set type_ressource(type_ressource) { this.#type_ressource = type_ressource; }

    get cout_metal() { return this.#cout_metal; }
    set cout_metal(cout_metal) { this.#cout_metal = cout_metal; }

    get cout_energie() { return this.#cout_energie; }
    set cout_energie(cout_energie) { this.#cout_energie = cout_energie; }

    get cout_deuterium() { return this.#cout_deuterium; }
    set cout_deuterium(cout_deuterium) { this.#cout_deuterium = cout_deuterium; }

    get temps_construction() { return this.#temps_construction; }
    set temps_construction(temps_construction) { this.#temps_construction = temps_construction; }

    get production_metal() { return this.#production_metal; }
    set production_metal(production_metal) { this.#production_metal = production_metal; }

    get production_energie() { return this.#production_energie; }
    set production_energie(production_energie) { this.#production_energie = production_energie; }

    get production_deuterium() { return this.#production_deuterium; }
    set production_deuterium(production_deuterium) { this.#production_deuterium = production_deuterium; }

}