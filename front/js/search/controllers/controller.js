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
    #laboID;

    constructor()
    {
        super();
        this.#technologies = [];
        this.#defaultTechnologies = [];
        this.#quantiteRessource = [];
        this.#technoRequired = [];

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

    async loadQuantitiesRessource() {
        const ressourceData = await this.fetchData("?quantity_ressource_player&id_Player=" + this.#session.id_Player + "&id_Universe=" + this.#session.id_Univers);

        this.#quantiteRessource = ressourceData.map(({ id_Ressource, type, quantite }) =>
            new QuantiteRessource(id_Ressource, type, quantite)
        );

    }

    async loadTechnologies() 
    {
        
        if (this.#laboID !== -1)
        {
            const data = await this.fetchData(`?technologies&id_Labo=${this.#laboID}`);

            const technos = data.map(item => {
                return new Technologie(
                    item.id,
                    item.niveau,
                    item.type_technologie,
                    item.cout_metal,
                    item.cout_deuterium,
                    item.temps_recherche * (2 ** (item.niveau - 1))
                );
            });

            this.#technologies = this.mergeTechnologies(this.#defaultTechnologies, technos);
        }
    }

    mergeTechnologies(defaultTechnologies, existingTechnologies) {
        const mergedTechnologies = [];
    
        defaultTechnologies.forEach(defaultTechno => {
            let existingTechno = null;

            existingTechno = existingTechnologies.find(existingTechno => existingTechno.type === defaultTechno.type);

    
            if (existingTechno) {
                mergedTechnologies.push(existingTechno);
            } else {
                mergedTechnologies.push(defaultTechno);
            }
        });
    
        return mergedTechnologies;
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
    
    async createTechnologieToAPI(type) {
        const technologieData = {
            id_Labo: this.#laboID,
            type: type
        };
    
        try {
            const response = await fetch(API_BASE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(technologieData),
            });
    
            const jsonData = await response.json();
            const dataToReturn = jsonData.id_New_Technologie;
    
            return dataToReturn;
        } catch (error) {
            console.error('Erreur:', error);
            throw error;
        }
    }

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

    async upgradeTechnologie(id, type) 
    {

        // if(!this.checkEnoughRessource(id, type))
        // {
        //     alert("Pas assez de ressources");
        //     return;
        // }

        // this.decreaseRessource(id, type);

        if (id < 0) {
            try {
                const dataToReturn = await this.createTechnologieToAPI(type);
                console.log("Success to create techno:", dataToReturn);
                
                if(dataToReturn > 0){
                    const techno = this.#technologies.find(technologie => technologie.id === id).id = dataToReturn;
                    id = dataToReturn;
                }


            } catch (error) {
                alert("Error while creating techno - please refresh the page:" + error);
            }
        }

        const technologie = this.#technologies.find(technologie => technologie.id === id);

        technologie.level++;

        technologie.temps_recherche = Math.round(technologie.temps_recherche ** 2);
            
        this.upgradeTechnologieToAPI(technologie.id);

        this.notify();
    }
        
}