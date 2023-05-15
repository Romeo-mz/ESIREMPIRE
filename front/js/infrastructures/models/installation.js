import { Infrastructure } from "./infrastructure.js";

export class Installation extends Infrastructure {

    #id_installation;
    #type_installation;
    #cout_metal;
    #cout_energie;
    #temps_construction;

    constructor(id, level, id_installation, type_installation, cout_metal, cout_energie, temps_construction) {
        super(id, level, "INSTALLATION");
        this.#id_installation = id_installation;
        this.#type_installation = type_installation;
        this.#cout_metal = cout_metal;
        this.#cout_energie = cout_energie;
        this.#temps_construction = temps_construction;
    }

    get id_installation() { return this.#id_installation; }
    set id_installation(id_installation) { this.#id_installation = id_installation; }

    get type_installation() { return this.#type_installation; }
    set type_installation(type_installation) { this.#type_installation = type_installation; }

    get cout_metal() { return this.#cout_metal; }
    set cout_metal(cout_metal) { this.#cout_metal = cout_metal; }

    get cout_energie() { return this.#cout_energie; }
    set cout_energie(cout_energie) { this.#cout_energie = cout_energie; }

    get temps_construction() { return this.#temps_construction; }
    set temps_construction(temps_construction) { this.#temps_construction = temps_construction; }

}