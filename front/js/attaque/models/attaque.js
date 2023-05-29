export class Attaque{
    #id;
    #idJoueurAttaquant;
    #idJoueursDefenseur;

    constructor(id, idJoueurAttaquant){
        this.#id = id;
        this.#idJoueurAttaquant = idJoueurAttaquant;
        this.#idJoueursDefenseur = [];
    }

    get id() { return this.#id; }
    get idJoueurAttaquant() { return this.#idJoueurAttaquant; }
    get idJoueursDefenseur() { return this.#idJoueursDefenseur; }

    set id(id) { this.#id = id; }
    set idJoueurAttaquant(idJoueurAttaquant) { this.#idJoueurAttaquant = idJoueurAttaquant; }
    set idJoueursDefenseur(idJoueursDefenseur) { this.#idJoueursDefenseur = idJoueursDefenseur; }
}