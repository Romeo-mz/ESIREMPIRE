export class Ressource {

    #id;
    #type_Ressource;

    constructor(id, type_Ressource) {
        this.#id = id;
        this.#type_Ressource = type_Ressource;
    }

    get id() { return this.#id; }
    set id(id) { this.#id = id; }

    get type_Ressource() { return this.#type_Ressource; }
    set type_Ressource(type_Ressource) { this.#type_Ressource = type_Ressource; }

}