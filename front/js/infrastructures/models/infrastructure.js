export class Infrastructure {

    #id;
    #level

    constructor(id, level) {
        this.#id = id;
        this.#level = level;
    }

    get id() { return this.#id; }
    get level() { return this.#level; }

    set id(id) { this.#id = id; }
    set level(level) { this.#level = level; }

}