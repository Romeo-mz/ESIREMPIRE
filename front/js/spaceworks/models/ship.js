export class Ship
{
    #id;
    #type;
    #quantite;
    #cout_metal;
    #cout_deuterium;
    #temps_construction;
    #point_attaque;
    #point_defense;
    #capacite_fret;

    constructor(id, type, quantite, cout_metal, cout_deuterium, temps_construction, point_attaque, point_defense, capacite_fret)
    {
        this.#id = id;
        this.#type = type;
        this.#quantite = quantite;
        this.#cout_metal = cout_metal;
        this.#cout_deuterium = cout_deuterium;
        this.#temps_construction = temps_construction;
        this.#point_attaque = point_attaque;
        this.#point_defense = point_defense;
        this.#capacite_fret = capacite_fret;
    }

    get id() { return this.#id; }
    get type() { return this.#type; }
    get quantite() { return this.#quantite; }
    get cout_metal() { return this.#cout_metal; }
    get cout_deuterium() { return this.#cout_deuterium; }
    get temps_construction() { return this.#temps_construction; }
    get point_attaque() { return this.#point_attaque; }
    get point_defense() { return this.#point_defense; }
    get capacite_fret() { return this.#capacite_fret; }

    set id(id) { this.#id = id; }
    set type(type) { this.#type = type; }
    set quantite(quantite) { this.#quantite = quantite; }
    set cout_metal(cout_metal) { this.#cout_metal = cout_metal; }
    set cout_deuterium(cout_deuterium) { this.#cout_deuterium = cout_deuterium; }
    set temps_construction(temps_construction) { this.#temps_construction = temps_construction; }
    set point_attaque(point_attaque) { this.#point_attaque = point_attaque; }
    set point_defense(point_defense) { this.#point_defense = point_defense; }
    set capacite_fret(capacite_fret) { this.#capacite_fret = capacite_fret; }
}