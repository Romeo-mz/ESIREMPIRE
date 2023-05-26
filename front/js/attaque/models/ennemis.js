export class Ennemis{
    #id;
    #nom;
    #planete;
    #galaxie;
    #systeme;

    constructor(id, nom, planete, galaxie, systeme){
        this.#id = id;
        this.#nom = nom;
        this.#planete = planete;
        this.#galaxie = galaxie;
        this.#systeme = systeme;
    }

    get id() { return this.#id; }
    get nom() { return this.#nom; }
    get planete() { return this.#planete; }
    get galaxie() { return this.#galaxie; }
    get systeme() { return this.#systeme; }

    set id(id) { this.#id = id; }
    set nom(nom) { this.#nom = nom; }
    set planete(planete) { this.#planete = planete; }
    set galaxie(galaxie) { this.#galaxie = galaxie; }
    set systeme(systeme) { this.#systeme = systeme; }
}