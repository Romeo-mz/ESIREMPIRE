export class Technologie 
{
    #id;
    #level;
    #type;

    constructor(id, level, type)
    {
        this.#id = id;
        this.#level = level;
        this.#type = type;
    }

    get id() { return this.#id; }
    get level() { return this.#level; }
    get type() { return this.#type; }

    set id(id) { this.#id = id; }
    set level(level) { this.#level = level; }
    set type(type) { this.#type = type; }
    
}