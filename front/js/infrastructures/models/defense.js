export class Defense {

    #id;
    #type_Defense;

    constructor(id, type_Defense) {
        this.#id = id;
        this.#type_Defense = type_Defense;
    }

    get id() { return this.#id; }
    set id(id) { this.#id = id; }

    get type_Defense() { return this.#type_Defense; }
    set type_Defense(type_Defense) { this.#type_Defense = type_Defense; }

}