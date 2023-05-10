import { Notifier } from "../pattern/notifier.js";
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

    generateDefaultInfrastructures() {
        const defaultInfrastructures = [
            new Defense(null, 0, "Artillerie laser", 10, 20, 30, 40, 50, 60),
            new Defense(null, 0, "Canon a ions", 20, 30, 40, 50, 60, 70),
            new Defense(null, 0, "Bouclier", 10, 20, 30, 40, 50, 60),
            new Installation(null, 0, "Chantier spatial", 10, 20, 30),
            new Installation(null, 0, "Laboratoire", 10, 20, 30),
            new Installation(null, 0, "Usine de nanites", 10, 20, 30),
            new Ressource(null, 0, "Mine de metal", 10, 20, 30, 40, null, null),
            new Ressource(null, 0, "Synthetiseur de deuterium", 10, 20, 30, null, null, 40, null),
            new Ressource(null, 0, "Centrale solaire", 10, 20, 30, null, 40, null, 50),
            new Ressource(null, 0, "Centrale a fusion", 10, 20, 30, null, 40, null, 50, 60)
        ];
    
        return defaultInfrastructures;
    }

    mergeInfrastructures(defaultInfrastructures, existingInfrastructures) {
        const mergedInfrastructures = [];

        defaultInfrastructures.forEach(defaultInfra => {

            let existingInfra = null;
            
            if(defaultInfra instanceof Defense)
            {
                existingInfra = existingInfrastructures.find(existingInfra => existingInfra.type_defense === defaultInfra.type_defense);
            }
            else if(defaultInfra instanceof Installation)
            {
                existingInfra = existingInfrastructures.find(existingInfra => existingInfra.type_installation === defaultInfra.type_installation);
            }
            else if(defaultInfra instanceof Ressource)
            {
                existingInfra = existingInfrastructures.find(existingInfra => existingInfra.type_ressource === defaultInfra.type_ressource);
            }

            if (existingInfra) {
                mergedInfrastructures.push(existingInfra);
            } else {
                mergedInfrastructures.push(defaultInfra);
            }
        });
    
        return mergedInfrastructures;
    }

    loadInfrastructureFromAPI() {
        const infrastructures = [];
    
        fetch("http://localhost:5550/ESIREMPIRE/api/boundary/APIinterface/APIinfrastructures.php?id_Planet=" + this.#session.id_Planet)
            .then(response => response.json())
            .then(data => {
                
                for(let i = 0; i < data.length; i++)
                {
                    if(data[i].installation_type != null)
                    {
                        infrastructures.push(
                            new Installation(
                                data[i].infrastructure_id, 
                                data[i].infrastructure_niveau,
                                data[i].installation_type,
                                data[i].installation_cout_metal,
                                data[i].installation_cout_energie,
                                data[i].installation_temps_construction
                            )
                        );
                    }
                    else if(data[i].resource_type != null)
                    {
                        infrastructures.push(
                            new Ressource(
                                data[i].infrastructure_id, 
                                data[i].infrastructure_niveau,
                                data[i].ressource_type,
                                data[i].ressource_cout_metal,
                                data[i].ressource_cout_energie,
                                data[i].ressource_cout_deuterium,
                                data[i].ressource_temps_construction,
                                data[i].ressource_production_metal,
                                data[i].ressource_production_energie,
                                data[i].ressource_production_deuterium
                            )
                        );
                    }
                    else if(data[i].defense_type != null)
                    {
                        infrastructures.push(
                            new Defense(
                                data[i].infrastructure_id, 
                                data[i].infrastructure_niveau,
                                data[i].defense_type,
                                data[i].defense_cout_metal,
                                data[i].defense_cout_energie,
                                data[i].defense_cout_deuterium,
                                data[i].defense_temps_construction,
                                data[i].defense_point_attaque,
                                data[i].defense_point_defense
                            )
                        );
                    }
                }
    
                const defaultInfrastructures = this.generateDefaultInfrastructures();
                const mergedInfrastructures = this.mergeInfrastructures(defaultInfrastructures, infrastructures);
    
                this.infrastructures = mergedInfrastructures;
            });
    }
        
}