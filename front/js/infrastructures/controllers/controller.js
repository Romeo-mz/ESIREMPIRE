import { Notifier } from "../pattern/notifier.js";
import { Infrastructure } from "../models/infrastructure.js";
import { Session } from "../models/session.js";

export class Controller extends Notifier
{
    #infrastructures;
    #session;

    constructor()
    {
        super();
        this.#infrastructures = [];

        this.#infrastructures.push(new Infrastructure(1, "Ressource", 'MINE', 1, 60, 15, 0));
        this.#infrastructures.push(new Infrastructure(2, "Installation", 'CHANTIER', 0, 75, 20, 0));
        this.#infrastructures.push(new Infrastructure(3, "Installation", 'LABORATOIRE', 3, 90, 25, 0));
        this.#infrastructures.push(new Infrastructure(4, "Ressource", 'SYNTHETISEUR', 0, 105, 30, 0));
        this.#infrastructures.push(new Infrastructure(5, "Defense", 'BOUCLIER', 5, 120, 35, 0));

        this.#session = new Session("hugo", 2, 1, 355, [1, 2, 3]);
    }

    get infrastructures() { return this.#infrastructures; }
    set infrastructures(infrastructures) { this.#infrastructures = infrastructures; }

    get session() { return this.#session; }
    set session(session) { this.#session = session; }

    upgradeInfrastructure(id)
    {
        const infrastructure = this.#infrastructures.find(infrastructure => infrastructure.id === id);

        if (infrastructure.level === 0)
        {
            infrastructure.level++;
            infrastructure.metal += 100;
            infrastructure.energie += 50;
            infrastructure.temps += 10;
        }
        else
        {
            infrastructure.level++;
            infrastructure.metal += 100;
            infrastructure.energie += 50;
            infrastructure.temps += 10;
        }

        this.notify();
    }

    getInfrastructureFromAPI() 
    {
        const infrastructures = [];

        fetch("http://localhost:3000/infrastructures")
            .then(response => response.json())
            .then(data => 
            {
                for (const infrastructure of data) 
                {
                    infrastructures.push(new Infrastructure(infrastructure.id, infrastructure.type_infrastructure, infrastructure.type, infrastructure.level, infrastructure.temps, infrastructure.metal, infrastructure.energie));
                }
            });

        return infrastructures;
    }
        
}