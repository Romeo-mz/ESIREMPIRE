export class Defense extends Infrastructure {

    #id_Defense;
    #type_defense;
    #cout_metal;
    #cout_energie;
    #cout_deuterium;
    #temps_construction;
    #point_attaque;
    #point_defense;

    constructor(id, level, id_Defense, type_defense, cout_metal, cout_energie, cout_deuterium, temps_construction, point_attaque, point_defense) {
        super(id, level);
        this.#id_Defense = id_Defense;
        this.#type_defense = type_defense;
        this.#cout_metal = cout_metal;
        this.#cout_energie = cout_energie;
        this.#cout_deuterium = cout_deuterium;
        this.#temps_construction = temps_construction;
        this.#point_attaque = point_attaque;
        this.#point_defense = point_defense;
    }

    get id_Defense() { return this.#id_Defense; }
    set id_Defense(id_Defense) { this.#id_Defense = id_Defense; }

    get nom() { return this.#nom; }
    set nom(nom) { this.#nom = nom; }

    get type_defense() { return this.#type_defense; }
    set type_defense(type_defense) { this.#type_defense = type_defense; }

    get cout_metal() { return this.#cout_metal; }
    set cout_metal(cout_metal) { this.#cout_metal = cout_metal; }

    get cout_energie() { return this.#cout_energie; }
    set cout_energie(cout_energie) { this.#cout_energie = cout_energie; }

    get cout_deuterium() { return this.#cout_deuterium; }
    set cout_deuterium(cout_deuterium) { this.#cout_deuterium = cout_deuterium; }

    get temps_construction() { return this.#temps_construction; }
    set temps_construction(temps_construction) { this.#temps_construction = temps_construction; }

    get point_attaque() { return this.#point_attaque; }
    set point_attaque(point_attaque) { this.#point_attaque = point_attaque; }

    get point_defense() { return this.#point_defense; }
    set point_defense(point_defense) { this.#point_defense = point_defense; }

}