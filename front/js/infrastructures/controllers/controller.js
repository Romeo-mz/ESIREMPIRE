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

    async fetchData(endpoint) {
        const response = await fetch(API_BASE_URL + endpoint);
        return response.json();
    }
    
    async upgradeInfrastructure(id, type) 
    {
        if (id < 0) 
        {
            await this.createInfrastructureToAPI(type)
                .then(
                    this.loadDefaultInfrastructures()
                        .then(() => {
                            console.log("Success to load default infra")
                            this.loadInfrastructureFromAPI()
                                .then(() => {
                                    console.log("Success to load Infra")
                                    // get the index where infrastructure.id == id from this.#infrastructures and remove it
                                    const index = this.#infrastructures.findIndex(infrastructure => infrastructure.id === id);
                                    this.#infrastructures.splice(index, 1);
                                })
                                .catch(error => {
                                    alert("Error while loading infra - please refresh the page")
                                });
                        })
                        .catch(error => {
                            alert("Error while loading default infra - please refresh the page")
                        })
                ).catch(error => {
                    alert("Error while creating infra - please refresh the page:" + error)
                });
        }
    
        const infrastructure = this.#infrastructures.find(infrastructure => infrastructure.id === id);

        infrastructure.level++;

        if(infrastructure instanceof Installation) 
        {
            if(infrastructure.type_installation === "Chantier spatial")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
                infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
            }
            else if(infrastructure.type_installation === "Laboratoire")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
                infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
            }
            else if(infrastructure.type_installation === "Usine de nanites")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
                infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
            }
        }
        else if (infrastructure instanceof Ressource)
        {
            if(infrastructure.type_ressource === "Mine de metal")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
                infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
                infrastructure.production_metal = Math.round(infrastructure.production_metal * 1.5 * 100) / 100;
            }
            else if(infrastructure.type_ressource === "Synthetiseur de deuterium")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
                infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
                infrastructure.production_deuterium = Math.round(infrastructure.production_deuterium * 1.3 * 100) / 100;
            }
            else if(infrastructure.type_ressource === "Centrale solaire")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
                infrastructure.cout_deuterium = Math.round(infrastructure.cout_deuterium * 1.6);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
                infrastructure.production_energie = Math.round(infrastructure.production_energie * 1.4 * 100) / 100;
            }
            else if(infrastructure.type_ressource === "Centrale a fusion")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
                infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
                infrastructure.production_energie = Math.round(infrastructure.production_energie * 2);
            }
        }
        else if (infrastructure instanceof Defense)
        {
            if(infrastructure.type_defense === "Artillerie laser")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
                infrastructure.cout_deuterium = Math.round(infrastructure.cout_deuterium * 1.6);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
            }
            else if(infrastructure.type_defense === "Canon a ions")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
                infrastructure.cout_deuterium = Math.round(infrastructure.cout_deuterium * 1.6);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
            }
            else if(infrastructure.type_defense === "Bouclier")
            {
                infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.5);
                infrastructure.cout_deuterium = Math.round(infrastructure.cout_deuterium * 1.5);
                infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.5);
                infrastructure.temps_construction = Math.round(infrastructure.temps_construction * 2);
            }
        }


        this.upgradeInfrastructureToAPI(infrastructure.id);

        this.notify();
    }

    async upgradeInfrastructureToAPI(id_Infrastructure)
    {
        const infrastructureData = {
            id_Planet: this.#session.id_Planet,
            id_Infrastructure: id_Infrastructure
        };
    
        await fetch(API_BASE_URL, {
            method: 'POST',
            body: JSON.stringify(infrastructureData)
        });
    }
    
    async createInfrastructureToAPI(type) 
    {
        const infrastructureData = {
            id_Planet: this.#session.id_Planet,
            type: type
        };
    
        await fetch(API_BASE_URL, {
            method: 'POST',
            body: JSON.stringify(infrastructureData)
        });
    }
    
    async loadDefaultInfrastructures() {
        const defenseData = await this.fetchData("?default_defense");
        const installationData = await this.fetchData("?default_installation");
        const ressourceData = await this.fetchData("?default_ressource");
    
        let count2 = -1;
        const defaultInfrastructures = [
            ...defenseData.map((data, count) => new Defense(
                count2--,
                0,
                data.type,
                data.defense_cout_metal,
                data.defense_cout_energie,
                data.defense_cout_deuterium,
                data.defense_temps_construction,
                data.defense_point_attaque,
                data.defense_point_defense
            )),
            ...installationData.map((data, count) => new Installation(
                count2--,
                0,
                data.type,
                data.installation_cout_metal,
                data.installation_cout_energie,
                data.installation_temps_construction
            )),
            ...ressourceData.map((data, count) => new Ressource(
                count2--,
                0,
                data.type,
                data.ressource_cout_metal,
                data.ressource_cout_energie,
                data.ressource_cout_deuterium,
                data.ressource_temps_construction,
                data.ressource_production_metal,
                data.ressource_production_energie,
                data.ressource_production_deuterium
            ))
        ];
    
        
        this.#defaultInfrastructures = defaultInfrastructures;
    }
    
    mergeInfrastructures(defaultInfrastructures, existingInfrastructures) {
        const mergedInfrastructures = [];
    
        defaultInfrastructures.forEach(defaultInfra => {
            let existingInfra = null;
    
            if (defaultInfra instanceof Defense) {
                existingInfra = existingInfrastructures.find(existingInfra => existingInfra.type_defense === defaultInfra.type_defense);
            } else if (defaultInfra instanceof Installation) {
                existingInfra = existingInfrastructures.find(existingInfra => existingInfra.type_installation === defaultInfra.type_installation);
            } else if (defaultInfra instanceof Ressource) {
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
    
    async loadInfrastructureFromAPI() {
        const data = await this.fetchData(`?id_Planet=${this.#session.id_Planet}`);
        const infrastructures = data.map(item => {
            if (item.installation_type != null) {
                return new Installation(
                    item.infrastructure_id,
                    item.infrastructure_niveau,
                    item.installation_type,
                    (item.installation_cout_metal*(1.6^(item.infrastructure_niveau-1))),
                    (item.installation_cout_energie*(1.6^(item.infrastructure_niveau-1))),
                    (item.installation_temps_construction*(2^(item.infrastructure_niveau-1)))
                );
            } else if (item.ressource_type != null) {
                return new Ressource(
                    item.infrastructure_id,
                    item.infrastructure_niveau,
                    item.ressource_type,
                    item.ressource_cout_metal,
                    item.ressource_cout_energie,
                    item.ressource_cout_deuterium,
                    item.ressource_temps_construction,
                    item.ressource_production_metal,
                    item.ressource_production_energie,
                    item.ressource_production_deuterium
                );
            } else if (item.defense_type != null) {
                return new Defense(
                    item.infrastructure_id,
                    item.infrastructure_niveau,
                    item.defense_type,
                    item.defense_cout_metal,
                    item.defense_cout_energie,
                    item.defense_cout_deuterium,
                    item.defense_temps_construction,
                    item.defense_point_attaque,
                    item.defense_point_defense
                );
            }
        });
    
        const mergedInfrastructures = this.mergeInfrastructures(this.#defaultInfrastructures, infrastructures);
        this.#infrastructures = mergedInfrastructures;

        this.notify();
    }
        
}