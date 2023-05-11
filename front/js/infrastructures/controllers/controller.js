import { Notifier } from "../pattern/notifier.js";
import { Installation } from "../models/installation.js";
import { Ressource } from "../models/ressource.js";
import { Defense } from "../models/defense.js";
import { Session } from "../models/session.js";

const API_BASE_URL = "http://esirempire/esirempire/api/boundary/APIinterface/APIinfrastructures.php";

export class Controller extends Notifier
{
    #infrastructures;
    #defaultInfrastructures;
    #session;

    constructor()
    {
        super();
        this.#infrastructures = [];
        this.#defaultInfrastructures = [];

        this.#session = new Session("hugo", 2, 1, 355, [1, 2, 3]);
    }

    get infrastructures() { return this.#infrastructures; }
    set infrastructures(infrastructures) { this.#infrastructures = infrastructures; }

    get session() { return this.#session; }
    set session(session) { this.#session = session; }

    upgradeInfrastructure(id, type)
    {
        if(id < 0)
        {
            this.createInfrastructureToAPI(type);
        }
        const infrastructure = this.#infrastructures.find(infrastructure => infrastructure.id === id);
        infrastructure.level++;

        this.notify();
    }

    createInfrastructureToAPI(type)
    {
        const infrastructureData = {
            id_Planet: this.#session.id_Planet,
            type: type
        };

        fetch("http://esirempire/esirempire/api/boundary/APIinterface/APIinfrastructures.php", {
            method: 'POST',
            body: JSON.stringify(infrastructureData)
        })

    }

    loadeDefaultInfrastructures() {

        const defaultInfrastructures = [];
        let count = 0;
    
        fetch("http://esirempire/esirempire/api/boundary/APIinterface/APIinfrastructures.php?default_defense")
            .then(response => response.json())
            .then(data => {
                
                for(let i = 0; i < data.length; i++)
                {
                    defaultInfrastructures.push(
                        new Defense(
                            count--,
                            0,
                            data[i].type,
                            data[i].defense_cout_metal,
                            data[i].defense_cout_energie,
                            data[i].defense_cout_deuterium,
                            data[i].defense_temps_construction,
                            data[i].defense_point_attaque,
                            data[i].defense_point_defense
                        )
                    );
                }

            });

        fetch("http://esirempire/esirempire/api/boundary/APIinterface/APIinfrastructures.php?default_installation")
            .then(response => response.json())
            .then(data => {

                for(let i = 0; i < data.length; i++)
                {
                    defaultInfrastructures.push(
                        new Installation(
                            count--,
                            0,
                            data[i].type,
                            data[i].installation_cout_metal,
                            data[i].installation_cout_energie,
                            data[i].installation_temps_construction
                        )
                    );
                }

            });

        fetch("http://esirempire/esirempire/api/boundary/APIinterface/APIinfrastructures.php?default_ressource")
            .then(response => response.json())
            .then(data => {

                for(let i = 0; i < data.length; i++)
                {
                    defaultInfrastructures.push(
                        new Ressource(
                            count--,
                            0,
                            data[i].type,
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

            });

        this.#defaultInfrastructures = defaultInfrastructures;

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

    loadInfrastructureFromAPI() 
    {
        const infrastructures = [];
    
        fetch("http://esirempire/esirempire/api/boundary/APIinterface/APIinfrastructures.php?id_Planet=" + this.#session.id_Planet)
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
                    else if(data[i].ressource_type != null)
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
    
                const mergedInfrastructures = this.mergeInfrastructures(this.#defaultInfrastructures, infrastructures);
    
                this.#infrastructures = mergedInfrastructures;

                this.notify();
            });
        
    }
        
}