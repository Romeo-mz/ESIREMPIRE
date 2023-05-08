export class Chantier {

    #id;
    #type_Chantier;

    constructor(id, type_Chantier) {
        this.#id = id;
        this.#type_Chantier = type_Chantier;
    }

    get id() { return this.#id; }
    set id(id) { this.#id = id; }

    get type_Chantier() { return this.#type_Chantier; }
    set type_Chantier(type_Chantier) { this.#type_Chantier = type_Chantier; }

}