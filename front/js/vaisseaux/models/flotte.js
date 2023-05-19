export class Flotte{
    #id;
    #listeVaisseaux;

    constructor(id){
        this.#id = id;
        this.#listeVaisseaux = [];
    }

    get id() { return this.#id; }
    get listeVaisseaux() { return this.#listeVaisseaux; }

    set id(id) { this.#id = id; }
    ajoutVaisseau(vaisseau) { this.#listeVaisseaux.push(vaisseau); }
    retirerVaisseau(vaisseau) { this.#listeVaisseaux.splice(this.#listeVaisseaux.indexOf(vaisseau), 1); }
}