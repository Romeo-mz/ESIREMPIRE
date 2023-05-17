import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";
import { QuantiteRessource } from "../models/quantiteressource.js";
import { TechnoRequired } from "../models/technorequired.js";
import { Technologie } from "../models/technologie.js";

const API_BASE_URL = "http://esirempire/api/boundary/APIinterface/APIsearch.php";

export class Controller extends Notifier
{
    #technologies;
    #defaultTechnologies;
    #session;
    #quantiteRessource;
    #technoRequired;
    #technologiesPlayer;
    #laboID;

    constructor()
    {
        super();
        this.#technologies = [];
        this.#defaultTechnologies = [];
        this.#quantiteRessource = [];
        this.#technoRequired = [];
        this.#technologiesPlayer = [];

        this.#laboID;

        this.#session = new Session("hugo", 2, 1, 355, [1, 2, 3]);
    }

    get technologies() { return this.#technologies; }
    set technologies(technologies) { this.#technologies = technologies; }

    get session() { return this.#session; }
    set session(session) { this.#session = session; }

    get quantiteRessource() { return this.#quantiteRessource; }
    set quantiteRessource(quantiteRessource) { this.#quantiteRessource = quantiteRessource; }

    get technoRequired() { return this.#technoRequired; }
    set technoRequired(technoRequired) { this.#technoRequired = technoRequired; }

    get technologiesPlayer() { return this.#technologiesPlayer; }
    set technologiesPlayer(technologiesPlayer) { this.#technologiesPlayer = technologiesPlayer; }

    get laboID() { return this.#laboID; }
    set laboID(laboID) { this.#laboID = laboID; }

    async fetchData(endpoint) {
        const response = await fetch(API_BASE_URL + endpoint);
        return response.json();
    }

    async loadDefaultTechnologies()
    {
        const data = await this.fetchData("?default_technologies");

        let negativeID = -1;

        const technos = data.map(item => {
            return new Technologie(
                negativeID--, 
                "0",
                item.type,
                item.cout_metal,
                item.cout_deuterium,
                item.temps_recherche
            );
        });
        
        this.#defaultTechnologies = technos;
    }

    async loadLaboratoireID()
    {
        const data = await this.fetchData(`?id_Labo&id_Planet=${this.#session.id_Planet}`);

        if (data.id_Labo !== false)
        {
            this.#laboID = data.id_Labo;
        }
        else
        {
            this.#laboID = -1;
        }

    }

    // To Do
    async loadTechnologies() 
    {
        
        if (this.#laboID > 0)
        {
            const data = await this.fetchData(`?technologies&id_Labo=${this.#laboID}`);
            // console.log(data);

            const technos = data.map(item => {
                return new Technologie(
                    item.id,
                    item.niveau,
                    item.type_technologie
                );
            });
            
            this.#technologiesPlayer = technos;
        }
    }
    
    

    // checkEnoughRessource(id, type) 
    // {
    //     const infrastructure = this.#infrastructures.find(infrastructure => infrastructure.id === id);

    //     const quantiteMetal = parseInt(this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite);
    //     const quantiteEnergie = parseInt(this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "ENERGIE").quantite);
    //     const quantiteDeuterium = parseInt(this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite);

    //     if (infrastructure instanceof Installation) {
    //         if (infrastructure.type_installation === "Chantier spatial") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteEnergie < infrastructure.cout_energie) {
    //                 return false;
    //             }
    //         }
    //         else if (infrastructure.type_installation === "Laboratoire") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteEnergie < infrastructure.cout_energie) {
    //                 return false;
    //             }
    //         }
    //         else if (infrastructure.type_installation === "Usine de nanites") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteEnergie < infrastructure.cout_energie) {
    //                 return false;
    //             }
    //         }
    //     }
    //     else if (infrastructure instanceof Ressource) {
    //         if (infrastructure.type_ressource === "Mine de metal") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteEnergie < infrastructure.cout_energie) {
    //                 return false;
    //             }
    //         }
    //         else if (infrastructure.type_ressource === "Synthetiseur de deuterium") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteEnergie < infrastructure.cout_energie) {
    //                 return false;
    //             }
    //         }
    //         else if (infrastructure.type_ressource === "Centrale solaire") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteDeuterium < infrastructure.cout_deuterium) {
    //                 return false;
    //             }
    //         }
    //         else if (infrastructure.type_ressource === "Centrale a fusion") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteEnergie < infrastructure.cout_energie) {
    //                 return false;
    //             }
    //         }
    //     }
    //     else if (infrastructure instanceof Defense) {
    //         if (infrastructure.type_defense === "Artillerie laser") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteEnergie < infrastructure.cout_energie) {
    //                 return false;
    //             }
    //         }
    //         else if (infrastructure.type_defense === "Canon a ions") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteEnergie < infrastructure.cout_energie) {
    //                 return false;
    //             }
    //         }
    //         else if (infrastructure.type_defense === "Bouclier") {
    //             if (quantiteMetal < infrastructure.cout_metal || quantiteEnergie < infrastructure.cout_energie) {
    //                 return false;
    //             }
    //         }
    //     }

    //     return true;

    // }

    // decreaseRessource(id, type) 
    // {
    //     const infrastructure = this.#infrastructures.find(infrastructure => infrastructure.id === id);

    //     const idQuantiteMetal = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").id;
    //     const quantiteMetal = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite;

    //     const idQuantiteEnergie = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "ENERGIE").id;
    //     const quantiteEnergie = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "ENERGIE").quantite;

    //     const idQuantiteDeuterium = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").id;
    //     const quantiteDeuterium = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite;

    //     if (infrastructure instanceof Installation) {
    //         if (infrastructure.type_installation === "Chantier spatial") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "ENERGIE").quantite -= infrastructure.cout_energie;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteEnergie, "ENERGIE", infrastructure.cout_energie);
    //         }
    //         else if (infrastructure.type_installation === "Laboratoire") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "ENERGIE").quantite -= infrastructure.cout_energie;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteEnergie, "ENERGIE", infrastructure.cout_energie);
    //         }
    //         else if (infrastructure.type_installation === "Usine de nanites") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "ENERGIE").quantite -= infrastructure.cout_energie;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteEnergie, "ENERGIE", infrastructure.cout_energie);
    //         }
    //     }
    //     else if (infrastructure instanceof Ressource) {
    //         if (infrastructure.type_ressource === "Mine de metal") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "ENERGIE").quantite -= infrastructure.cout_energie;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteEnergie, "ENERGIE", infrastructure.cout_energie);
    //         }
    //         else if (infrastructure.type_ressource === "Synthetiseur de deuterium") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "ENERGIE").quantite -= infrastructure.cout_energie;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteEnergie, "ENERGIE", infrastructure.cout_energie);
    //         }
    //         else if (infrastructure.type_ressource === "Centrale solaire") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite -= infrastructure.cout_deuterium;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteDeuterium, "DEUTERIUM", infrastructure.cout_deuterium);
    //         }
    //         else if (infrastructure.type_ressource === "Centrale a fusion") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite -= infrastructure.cout_deuterium;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteDeuterium, "DEUTERIUM", infrastructure.cout_deuterium);
    //         }
    //     }
    //     else if (infrastructure instanceof Defense) {
    //         if (infrastructure.type_defense === "Artillerie laser") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite -= infrastructure.cout_deuterium;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteDeuterium, "DEUTERIUM", infrastructure.cout_deuterium);
    //         }
    //         else if (infrastructure.type_defense === "Canon a ions") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite -= infrastructure.cout_deuterium;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteDeuterium, "DEUTERIUM", infrastructure.cout_deuterium);
    //         }
    //         else if (infrastructure.type_defense === "Bouclier") {
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= infrastructure.cout_metal;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "ENERGIE").quantite -= infrastructure.cout_energie;
    //             this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite -= infrastructure.cout_deuterium;

    //             this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", infrastructure.cout_metal);
    //             this.decreaseRessourceToAPI(idQuantiteEnergie, "ENERGIE", infrastructure.cout_energie);
    //             this.decreaseRessourceToAPI(idQuantiteDeuterium, "DEUTERIUM", infrastructure.cout_deuterium);
    //         }
    //     }

    // }

    // async decreaseRessourceToAPI(id, type, quantite) 
    // {
    //     const ressourceData = {
    //         id_Ressource: parseInt(id),
    //         quantite: parseInt(quantite)
    //     };

    //     fetch(API_BASE_URL, {
    //         method: 'POST',
    //         body: JSON.stringify(ressourceData)
    //     });
    // }

    // async upgradeInfrastructureToAPI(id_Infrastructure)
    // {
    //     const infrastructureData = {
    //         id_Planet: this.#session.id_Planet,
    //         id_Infrastructure: id_Infrastructure
    //     };
    
    //     await fetch(API_BASE_URL, {
    //         method: 'POST',
    //         body: JSON.stringify(infrastructureData)
    //     });
    // }
    
    // async createInfrastructureToAPI(id, type) {
    //     const infrastructureData = {
    //         id_Planet: this.#session.id_Planet,
    //         type: type
    //     };
    
    //     try {
    //         const response = await fetch(API_BASE_URL, {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //             },
    //             body: JSON.stringify(infrastructureData),
    //         });
    
    //         const jsonData = await response.json();
    //         const dataToReturn = jsonData.id_New_Infrastructure;
    
    //         return dataToReturn;
    //     } catch (error) {
    //         console.error('Erreur:', error);
    //         throw error;
    //     }
    // }
    
    // async loadQuantitiesRessource() {
    //     const ressourceData = await this.fetchData("?quantity_ressource_player&id_Player=" + this.#session.id_Player + "&id_Universe=" + this.#session.id_Univers);

    //     this.#quantiteRessource = ressourceData.map(({ id_Ressource, type, quantite }) =>
    //         new QuantiteRessource(id_Ressource, type, quantite)
    //     );

    // }
    
       
    
    // mergeInfrastructures(defaultInfrastructures, existingInfrastructures) {
    //     const mergedInfrastructures = [];
    
    //     defaultInfrastructures.forEach(defaultInfra => {
    //         let existingInfra = null;
    
    //         if (defaultInfra instanceof Defense) {
    //             existingInfra = existingInfrastructures.find(existingInfra => existingInfra.type_defense === defaultInfra.type_defense);
    //         } else if (defaultInfra instanceof Installation) {
    //             existingInfra = existingInfrastructures.find(existingInfra => existingInfra.type_installation === defaultInfra.type_installation);
    //         } else if (defaultInfra instanceof Ressource) {
    //             existingInfra = existingInfrastructures.find(existingInfra => existingInfra.type_ressource === defaultInfra.type_ressource);
    //         }
    
    //         if (existingInfra) {
    //             mergedInfrastructures.push(existingInfra);
    //         } else {
    //             mergedInfrastructures.push(defaultInfra);
    //         }
    //     });
    
    //     return mergedInfrastructures;
    // }
    
    // async loadInfrastructureFromAPI() {
    //     const data = await this.fetchData(`?id_Planet=${this.#session.id_Planet}`);
    //     const infrastructures = data.map(item => {
    //         if (item.installation_type != null) {
    //             return new Installation(
    //                 item.infrastructure_id,
    //                 item.infrastructure_niveau,
    //                 item.installation_id,
    //                 item.installation_type,
    //                 Math.round(item.installation_cout_metal * (1.6 ** (item.infrastructure_niveau - 1))),
    //                 Math.round(item.installation_cout_energie * (1.6 ** (item.infrastructure_niveau - 1))),
    //                 item.installation_temps_construction * (2 ** (item.infrastructure_niveau - 1))
    //             );
    //         } else if (item.ressource_type != null) {
    //             return new Ressource(
    //                 item.infrastructure_id,
    //                 item.infrastructure_niveau,
    //                 item.ressource_type,
    //                 Math.round(item.ressource_cout_metal * (1.6 ** (item.infrastructure_niveau - 1))),
    //                 Math.round(item.ressource_cout_energie * (1.6 ** (item.infrastructure_niveau - 1))),
    //                 Math.round(item.ressource_cout_deuterium * (1.6 ** (item.infrastructure_niveau - 1))),
    //                 item.ressource_temps_construction * (2 ** (item.infrastructure_niveau - 1)),
    //                 item.ressource_production_metal,
    //                 item.ressource_production_energie,
    //                 item.ressource_production_deuterium
    //             );
    //         } else if (item.defense_type != null) {
    //             return new Defense(
    //                 item.infrastructure_id,
    //                 item.infrastructure_niveau,
    //                 item.defense_type,
    //                 Math.round(item.defense_cout_metal * (1.6 ** (item.infrastructure_niveau - 1))),
    //                 Math.round(item.defense_cout_energie * (1.6 ** (item.infrastructure_niveau - 1))),
    //                 Math.round(item.defense_cout_deuterium * (1.6 ** (item.infrastructure_niveau - 1))),
    //                 item.defense_temps_construction * (2 ** (item.infrastructure_niveau - 1)),
    //                 item.defense_point_attaque,
    //                 item.defense_point_defense
    //             );
    //         }
    //     });
    
    //     const mergedInfrastructures = this.mergeInfrastructures(this.#defaultInfrastructures, infrastructures);
    //     this.#infrastructures = mergedInfrastructures;

    // }

    // async loadTechnoRequired() {
    //     const data = await this.fetchData(`?techno_required`);

    //     const technos = data.map(item => {
    //         return new TechnoRequired(
    //             item.technologie,
    //             item.technologie_necessaire,
    //             item.technologie_necessaire_niveau
    //         );
    //     });
        
    //     this.#technoRequired = technos;
    // }

    // async loadInfraTechnoRequired()
    // {
    //     const data = await this.fetchData(`?infra_techno_required`);

    //     const infraTechnos = data.map(item => {
    //         if(item.Type_Installation !== null)
    //         {
    //             return new InfraTechnoRequired(
    //                 item.Type_Installation,
    //                 item.Type_Technologie,
    //                 item.niveau
    //             );
    //         }
    //         else if(item.Type_Ressource !== null)
    //         {
    //             return new InfraTechnoRequired(
    //                 item.Type_Ressource,
    //                 item.Type_Technologie,
    //                 item.niveau
    //             );
    //         }
    //         else if(item.Type_Defense !== null)
    //         {
    //             return new InfraTechnoRequired(
    //                 item.Type_Defense,
    //                 item.Type_Technologie,
    //                 item.niveau
    //             );
    //         }
    //     });
        
    //     this.#infraTechnoRequired = infraTechnos;
    // }

    // async upgradeTechnologie(id, type) 
    // {

    //     if(!this.checkEnoughRessource(id, type))
    //     {
    //         alert("Pas assez de ressources");
    //         return;
    //     }

    //     this.decreaseRessource(id, type);

    //     if (id < 0) {
    //         try {
    //             const dataToReturn = await this.createInfrastructureToAPI(id, type);
    //             console.log("Success to create infra:", dataToReturn);
                
    //             if(dataToReturn > 0){
    //                 const infra = this.#infrastructures.find(infrastructure => infrastructure.id === id).id = dataToReturn;
    //                 id = dataToReturn;
    //             }


    //         } catch (error) {
    //             alert("Error while creating infra - please refresh the page:" + error);
    //         }
    //     }

    //     const infrastructure = this.#infrastructures.find(infrastructure => infrastructure.id === id);

    //     infrastructure.level++;

    //     // Find "Usine de nanites level"
    //     const usineNanitesLevel = this.#infrastructures.find(infrastructure => infrastructure.type_installation === "Usine de nanites").level;

    //     if(infrastructure instanceof Installation) 
    //     {
    //         if(infrastructure.type_installation === "Chantier spatial")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
    //             infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //         }
    //         else if(infrastructure.type_installation === "Laboratoire")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
    //             infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //         }
    //         else if(infrastructure.type_installation === "Usine de nanites")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
    //             infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //         }
    //     }
    //     else if (infrastructure instanceof Ressource)
    //     {
    //         if(infrastructure.type_ressource === "Mine de metal")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
    //             infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //             infrastructure.production_metal = Math.round(infrastructure.production_metal * 1.5 * 100) / 100;
    //         }
    //         else if(infrastructure.type_ressource === "Synthetiseur de deuterium")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
    //             infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //             infrastructure.production_deuterium = Math.round(infrastructure.production_deuterium * 1.3 * 100) / 100;
    //         }
    //         else if(infrastructure.type_ressource === "Centrale solaire")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
    //             infrastructure.cout_deuterium = Math.round(infrastructure.cout_deuterium * 1.6);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //             infrastructure.production_energie = Math.round(infrastructure.production_energie * 1.4 * 100) / 100;
    //         }
    //         else if(infrastructure.type_ressource === "Centrale a fusion")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
    //             infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.6);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //             infrastructure.production_energie = Math.round(infrastructure.production_energie * 2);
    //         }
    //     }
    //     else if (infrastructure instanceof Defense)
    //     {
    //         if(infrastructure.type_defense === "Artillerie laser")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
    //             infrastructure.cout_deuterium = Math.round(infrastructure.cout_deuterium * 1.6);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //         }
    //         else if(infrastructure.type_defense === "Canon a ions")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.6);
    //             infrastructure.cout_deuterium = Math.round(infrastructure.cout_deuterium * 1.6);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //         }
    //         else if(infrastructure.type_defense === "Bouclier")
    //         {
    //             infrastructure.cout_metal = Math.round(infrastructure.cout_metal * 1.5);
    //             infrastructure.cout_deuterium = Math.round(infrastructure.cout_deuterium * 1.5);
    //             infrastructure.cout_energie = Math.round(infrastructure.cout_energie * 1.5);
    //             infrastructure.temps_construction = Math.round(infrastructure.temps_construction * (1 - (usineNanitesLevel * 0.01)) * 2);
    //         }
    //     }

    //     this.upgradeInfrastructureToAPI(infrastructure.id);

    //     this.notify();
    // }
        
}