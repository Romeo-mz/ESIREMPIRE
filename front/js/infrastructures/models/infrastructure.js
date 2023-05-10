export class Infrastructure {

    #id;
    #level
    #type;

    constructor(id, level, type) {
        this.#id = id;
        this.#level = level;
        this.#type = type;
    }

    get id() { return this.#id; }
    get level() { return this.#level; }

    set id(id) { this.#id = id; }
    set level(level) { this.#level = level; }

    get type() { return this.#type; }
    set type(type) { this.#type = type; }

}