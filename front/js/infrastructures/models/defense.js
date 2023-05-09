export class Defense {

    #id;
    #nom;
    #type_Defense;

    constructor(id, nom, type_Defense) {
        this.#id = id;
        this.#nom = nom;
        this.#type_Defense = type_Defense;
    }

    get id() { return this.#id; }
    set id(id) { this.#id = id; }

    get nom() { return this.#nom; }
    set nom(nom) { this.#nom = nom; }

    get type_Defense() { return this.#type_Defense; }
    set type_Defense(type_Defense) { this.#type_Defense = type_Defense; }

}