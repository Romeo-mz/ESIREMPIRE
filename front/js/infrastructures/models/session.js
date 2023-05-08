export class Session
{
    #id;
    #pseudo;
    #id_Player;
    #id_Univers;
    #id_Planet;
    #id_Ressource;

    constructor(id, pseudo, id_Player, id_Univers, id_Planet, id_Ressource)
    {
        this.#id = id;
        this.#pseudo = pseudo;
        this.#id_Player = id_Player;
        this.#id_Univers = id_Univers;
        this.#id_Planet = id_Planet;
        this.#id_Ressource = id_Ressource;
    }

    get id() { return this.#id; }
    set id(id) { this.#id = id; }

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