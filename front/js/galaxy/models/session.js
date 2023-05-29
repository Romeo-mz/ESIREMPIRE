export class Session
{
    #pseudo;
    #id_Player;
    #id_Univers;
    #id_Planet = [];
    #id_Ressource = [];

    constructor(pseudo, id_Player, id_Univers, id_Planet, id_Ressource)
    {
        this.#pseudo = pseudo;
        this.#id_Player = id_Player;
        this.#id_Univers = id_Univers;
        this.#id_Planet = id_Planet;
        this.#id_Ressource[0] = id_Ressource[0];
        this.#id_Ressource[1] = id_Ressource[1];
        this.#id_Ressource[2] = id_Ressource[2];
    }

    get pseudo() { return this.#pseudo; }
    set pseudo(pseudo) { this.#pseudo = pseudo; }

    get id_Player() { return this.#id_Player; }
    set id_Player(id_Player) { this.#id_Player = id_Player; }

    get id_Univers() { return this.#id_Univers; }
    set id_Univers(id_Univers) { this.#id_Univers = id_Univers; }

    get id_Planet() { return this.#id_Planet; }
    set id_Planet(id_Planet) { this.#id_Planet = id_Planet; }

    get id_Ressource() { return this.#id_Ressource; }
    set id_Ressource(id_Ressource) { this.#id_Ressource = id_Ressource; }

}