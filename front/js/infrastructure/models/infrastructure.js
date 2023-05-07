export class Infrastructure {

    #id;
    #type;
    #level
    #metal;
    #energie;
    #temps;

    constructor(id, type, level, metal, energie, temps) {
        this.#id = id;
        this.#type = type;
        this.#level = level;
        this.#metal = metal;
        this.#energie = energie;
        this.#temps = temps;
    }

    get id() { return this.#id; }
    get type() { return this.#type; }
    get level() { return this.#level; }
    get metal() { return this.#metal; }
    get energie() { return this.#energie; }
    get temps() { return this.#temps; }

    set id(id) { this.#id = id; }
    set type(type) { this.#type = type; }
    set level(level) { this.#level = level; }
    set metal(metal) { this.#metal = metal; }
    set energie(energie) { this.#energie = energie; }
    set temps(temps) { this.#temps = temps; }

}