import { Vaisseau } from "./vaisseaux.js";

export class VaisseauDefault extends Vaisseau{
    #cout_metal;
    #cout_deuterium;
    #temps_construction;
    #point_attaque;
    #point_defense;
    #capcite_fret;

    constructor(id, type, cout_metal, cout_deuterium, temps_construction, point_attaque, point_defense, capcite_fret){
        super(id, type);
        this.#cout_metal = cout_metal;
        this.#cout_deuterium = cout_deuterium;
        this.#temps_construction = temps_construction;
        this.#point_attaque = point_attaque;
        this.#point_defense = point_defense;
        this.#capcite_fret = capcite_fret;
    }

    get cout_metal() { return this.#cout_metal; }
    get cout_deuterium() { return this.#cout_deuterium; }
    get temps_construction() { return this.#temps_construction; }
    get point_attaque() { return this.#point_attaque; }
    get point_defense() { return this.#point_defense; }
    get capcite_fret() { return this.#capcite_fret; }

    set cout_metal(cout_metal) { this.#cout_metal = cout_metal; }
    set cout_deuterium(cout_deuterium) { this.#cout_deuterium = cout_deuterium; }
    set temps_construction(temps_construction) { this.#temps_construction = temps_construction; }
    set point_attaque(point_attaque) { this.#point_attaque = point_attaque; }
    set point_defense(point_defense) { this.#point_defense = point_defense; }
    set capcite_fret(capcite_fret) { this.#capcite_fret = capcite_fret; }
}