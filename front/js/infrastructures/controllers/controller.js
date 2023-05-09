import { Notifier } from "../pattern/notifier.js";
import { Infrastructure } from "../models/infrastructure.js";
import { Chantier} from "../models/chantier.js";
import { Laboratoire } from "../models/laboratoire.js";
import { Installation } from "../models/installation.js";
import { Ressource } from "../models/ressource.js";
import { Defense } from "../models/defense.js";
import { Session } from "../models/session.js";

export class Controller extends Notifier
{
    #infrastructures;
    #session;

    constructor()
    {
        super();
        this.#infrastructures = [];

        // this.#infrastructures.push(new Infrastructure(1, "Ressource", 'MINE', 1, 60, 15, 0));
        // this.#infrastructures.push(new Infrastructure(2, "Installation", 'CHANTIER', 0, 75, 20, 0));
        // this.#infrastructures.push(new Infrastructure(3, "Installation", 'LABORATOIRE', 3, 90, 25, 0));
        // this.#infrastructures.push(new Infrastructure(4, "Ressource", 'SYNTHETISEUR', 0, 105, 30, 0));
        // this.#infrastructures.push(new Infrastructure(5, "Defense", 'BOUCLIER', 5, 120, 35, 0));

        this.#session = new Session("hugo", 2, 1, 355, [1, 2, 3]);

        this.loadInfrastructureFromAPI();
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

    loadInfrastructureFromAPI() 
    {
        const infrastructures = [];

        fetch("http://localhost:5550/ESIREMPIRE/api/boundary/APIinterface/APIinfrastructures.php?id_Planet=" + this.#session.id_Planet)
            .then(response => response.json())
            .then(data => 
            {
                for(let i = 0; i < data.length; i++)
                {
                    if(data[i].id_Installation != null)
                    {
                        if(data[i].id_Chantier_Spatial != null)
                        {
                            infrastructures.push(new Chantier(data[i].id_Chantier_Spatial, data[i].nom_Chantier_Spatial));
                        }
                        else if(data[i].id_Laboratoire != null)
                        {
                            infrastructures.push(new Laboratoire(data[i].id_Laboratoire, data[i].nom_Laboratoire));
                        }
                        else
                        {
                            infrastructures.push(new Usine(data[i].id_Installation, data[i].nom_Installation));
                        }
                    }
                    else if(data[i].id_Ressource != null)
                    {
                        if(data[i].typeressource == "METAL") {var nom = "Mine de métal";}
                        else if(data[i].typeressource == "SYNTHETISEUR") {var nom = "Synthétiseur de deutérium";}
                        else if(data[i].typeressource == "CENTRALE_SOLAIRE") {var nom = "Centrale électrique solaire";}
                        else if(data[i].typeressource == "CENTRALE_FUSION") {var nom = "Centrale électrique de fusion";}
                        infrastructures.push(new Ressource(data[i].id_Ressource, nom, data[i].typeressource));
                    }
                    else if(data[i].id_Defense != null)
                    {
                        if(data[i].typedefense == "ARTILLERIE") {var nom = "Artillerie laser";}
                        else if(data[i].typedefense == "CANON") {var nom = "Canon à ions";}
                        else if(data[i].typedefense == "BOUCLIER") {var nom = "Bouclier";}
                        infrastructures.push(new Defense(data[i].id_Defense, nom, data[i].typedefense));
                    }
                }

                console.log(infrastructures);
            });

    }
        
}