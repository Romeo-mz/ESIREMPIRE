export class Chantier {

    #id;
    #nom;
    #cout_metal;
    #cout_energie;
    #temps_construction;

    constructor(id, nom, cout_metal, cout_energie, temps_construction) {
        this.#id = id;
        this.#nom = nom;
        this.#cout_metal = cout_metal;
        this.#cout_energie = cout_energie;
        this.#temps_construction = temps_construction;
    }

    get id() { return this.#id; }
    set id(id) { this.#id = id; }

    get nom() { return this.#nom; }
    set nom(nom) { this.#nom = nom; }

    get cout_metal() { return this.#cout_metal; }
    set cout_metal(cout_metal) { this.#cout_metal = cout_metal; }

    get cout_energie() { return this.#cout_energie; }
    set cout_energie(cout_energie) { this.#cout_energie = cout_energie; }

    get temps_construction() { return this.#temps_construction; }
    set temps_construction(temps_construction) { this.#temps_construction = temps_construction; }

}