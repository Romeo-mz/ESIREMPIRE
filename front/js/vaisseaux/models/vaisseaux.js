export class Vaisseau{
    #id;
    #type;
    
    constructor(id, type){
        this.#id = id;
        this.#type = type;
    }

    get id() { return this.#id; }
    get type() { return this.#type; }

    set id(id) { this.#id = id; }
    set type(type) { this.#type = type; }
}