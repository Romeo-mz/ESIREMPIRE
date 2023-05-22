export class Vaisseaux {
    #id;
    #type;
    #quantite;

    constructor(id, type, quantite){
        this.#id = id;
        this.#type = type;
        this.#quantite = quantite;
    }

    get id() { return this.#id; }
    get type() { return this.#type; }
    get quantite() { return this.#quantite; }

    set id(id) { this.#id = id; }
    set type(type) { this.#type = type; }
    set quantite(quantite) { this.#quantite = quantite; }
}