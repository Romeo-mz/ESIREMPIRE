export class Laboratoire {

    #id;
    #type_Laboratoire;

    constructor(id, type_Laboratoire) {
        this.#id = id;
        this.#type_Laboratoire = type_Laboratoire;
    }

    get id() { return this.#id; }
    set id(id) { this.#id = id; }

    get type_Laboratoire() { return this.#type_Laboratoire; }
    set type_Laboratoire(type_Laboratoire) { this.#type_Laboratoire = type_Laboratoire; }

}