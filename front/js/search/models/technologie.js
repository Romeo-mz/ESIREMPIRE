export class Technologie 
{
    #id;
    #level;
    #type;
    #cout_metal;
    #cout_deuterium;
    #temps_recherche;

    constructor(id, level, type, cout_metal, cout_deuterium, temps_recherche)
    {
        this.#id = id;
        this.#level = level;
        this.#type = type;
        this.#cout_metal = cout_metal;
        this.#cout_deuterium = cout_deuterium;
        this.#temps_recherche = temps_recherche;
    }


    get id() { return this.#id; }
    get level() { return this.#level; }
    get type() { return this.#type; }
    get cout_metal() { return this.#cout_metal; }
    get cout_deuterium() { return this.#cout_deuterium; }
    get temps_recherche() { return this.#temps_recherche; }

    set id(id) { this.#id = id; }
    set level(level) { this.#level = level; }
    set type(type) { this.#type = type; }
    set cout_metal(cout_metal) { this.#cout_metal = cout_metal; }
    set cout_deuterium(cout_deuterium) { this.#cout_deuterium = cout_deuterium; }
    set temps_recherche(temps_recherche) { this.#temps_recherche = temps_recherche; }
    
}