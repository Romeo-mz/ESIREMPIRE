export class Installation {

    #id;
    #type_Installation;

    constructor(id, type_Installation) {
        this.#id = id;
        this.#type_Installation = type_Installation;
    }

    get id() { return this.#id; }
    set id(id) { this.#id = id; }

    get type_Installation() { return this.#type_Installation; }
    set type_Installation(type_Installation) { this.#type_Installation = type_Installation; }

}