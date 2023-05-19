import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";
import { QuantiteRessource } from "../models/quantiteressource.js";
import { ShipTechnoRequired } from "../models/shiptechnorequired.js";
import { Technologie } from "../models/technologie.js";
import { Ship } from "../models/ship.js";

const API_BASE_URL = "http://esirempire/api/boundary/APIinterface/APIspacework.php";
const API_QUERY_PARAMS = {
    defaultShips: "?default_ships",
    spaceworkID: (planetID) => `?id_Spacework&id_Planet=${planetID}`,
    resourceQuantities: (playerID, universeID) => `?quantity_ressource_player&id_Player=${playerID}&id_Universe=${universeID}`,
    nbships: (spaceworkID) => `?nbships&id_Spacework=${spaceworkID}`,
    technologiesPlayer: (id_Planet) => `?technologiesPlayer&id_Planet=${id_Planet}`
};

export class Controller extends Notifier
{
    #ships;
    #session;
    #quantiteRessource;
    #technoRequired;
    #technologiesPlayer;
    #spaceworkID;

    constructor()
    {
        super();
        this.#ships = [];
        this.#technologiesPlayer = [];
        this.#quantiteRessource = [];
        
        this.#spaceworkID = -1;

        this.#session = new Session("hugo", 2, 1, 355, [1, 2, 3]);

        this.technoRequired = new ShipTechnoRequired("CROISEUR", "IONS", "4");
    }

    get ships() { return this.#ships; }
    get session() { return this.#session; }
    get quantiteRessource() { return this.#quantiteRessource; }
    get technologiesPlayer() { return this.#technologiesPlayer; }
    get technoRequired() { return this.#technoRequired; }
    get spaceworkID() { return this.#spaceworkID; }

    set ships(ships) { this.#ships = ships; }
    set spaceworkID(spaceworkID) { this.#spaceworkID = spaceworkID; }
    set session(session) { this.#session = session; }
    set quantiteRessource(quantiteRessource) { this.#quantiteRessource = quantiteRessource; }
    set technologiesPlayer(technologiesPlayer) { this.#technologiesPlayer = technologiesPlayer; }
    set technoRequired(technoRequired) { this.#technoRequired = technoRequired; }


    async fetchData(endpoint) {
        const response = await fetch(API_BASE_URL + endpoint);
        return response.json();
    }

    async loadShips()
    {
        const data = await this.fetchData(API_QUERY_PARAMS.defaultShips);

        let negativeID = -1;

        const ships = data.map(item => {
            return new Ship(
                negativeID--,
                item.type,
                "0",
                item.cout_metal,
                item.cout_deuterium,
                item.temps_construction,
                item.point_attaque,
                item.point_defense,
                item.capacite_fret
            );
        });
        
        this.#ships = ships;
    }

    async loadSpaceworkID()
    {
        const data = await this.fetchData(API_QUERY_PARAMS.spaceworkID(this.#session.id_Planet));

        if (data.id_Spacework !== false)
        {
            this.#spaceworkID = data.id_Spacework;
        }
        else
        {
            this.#spaceworkID = -1;
        }
    }

    async loadQuantitiesRessource() {
        const ressourceData = await this.fetchData(API_QUERY_PARAMS.resourceQuantities(this.#session.id_Player, this.#session.id_Univers));

        this.#quantiteRessource = ressourceData.map(({ id_Ressource, type, quantite }) =>
            new QuantiteRessource(id_Ressource, type, quantite)
        );

    }

    async loadNbShips() 
    {
        if (this.#spaceworkID !== -1)
        {
            const data = await this.fetchData(API_QUERY_PARAMS.nbships(this.#spaceworkID));

            data.forEach(item => {
                const ship = this.#ships.find(ship => ship.type === item.type);
                ship.quantite = item.nb;
            });
        }
    }

    async loadTechnologiesPlayer() 
    {        
        if (this.#spaceworkID !== -1)
        {
            const data = await this.fetchData(API_QUERY_PARAMS.technologiesPlayer(this.#session.id_Planet));

            const technos = data.map(item => {
                return new Technologie(
                    item.id,
                    item.niveau,
                    item.type
                );
            });
            
            this.#technologiesPlayer = technos;
        }
    }

    // checkEnoughRessource(id, type) 
    // {
    //     const technologie = this.#technologies.find(technologie => technologie.id === id);

    //     const quantiteMetal = parseInt(this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite);
    //     const quantiteDeuterium = parseInt(this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite);

        
    //         if (quantiteDeuterium < technologie.cout_deuterium) 
    //         {
    //             if (technologie.type === "ARMEMENT") 
    //             {
    //                 if (quantiteMetal < technologie.cout_metal) 
    //                 {
    //                     return false;
    //                 }
    //             }
    //             return false;
    //         }


    //     return true;

    // }

    // decreaseRessource(id, type) 
    // {
    //     const technologie = this.#technologies.find(technologie => technologie.id === id);

    //     const idQuantiteMetal = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").id;
    //     const quantiteMetal = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite;

    //     const idQuantiteDeuterium = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").id;
    //     const quantiteDeuterium = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite;

    //     if (technologie.type === "ARMEMENT") 
    //     {
    //         this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= technologie.cout_metal;
    //         this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite -= technologie.cout_deuterium;

    //         this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", technologie.cout_metal);
    //         this.decreaseRessourceToAPI(idQuantiteDeuterium, "DEUTERIUM", technologie.cout_deuterium);
    //     }
    //     else {
    //         this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite -= technologie.cout_deuterium;

    //         this.decreaseRessourceToAPI(idQuantiteDeuterium, "METAL", technologie.cout_deuterium);
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
    
    // async createTechnologieToAPI(type) {
    //     const technologieData = {
    //         id_Labo: this.#laboID,
    //         type: type
    //     };
    
    //     try {
    //         const response = await fetch(API_BASE_URL, {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //             },
    //             body: JSON.stringify(technologieData),
    //         });
    
    //         const jsonData = await response.json();
    //         const dataToReturn = jsonData.id_New_Technologie;
    
    //         return dataToReturn;
    //     } catch (error) {
    //         console.error('Erreur:', error);
    //         throw error;
    //     }
    // }    

    // async upgradeTechnologieToAPI(id_Technologie)
    // {
    //     const technologieData = {
    //         id_Labo: this.#laboID,
    //         id_Technologie: id_Technologie
    //     };
    
    //     await fetch(API_BASE_URL, {
    //         method: 'POST',
    //         body: JSON.stringify(technologieData)
    //     });
    // }

    // async upgradeTechnologie(id, type) 
    // {
    //     const oldId = id;

    //     if(!this.checkEnoughRessource(id, type))
    //     {
    //         alert("Pas assez de ressources");
    //         return;
    //     }

    //     this.decreaseRessource(id, type);

    //     if (id < 0) {
    //         try {
    //             const dataToReturn = await this.createTechnologieToAPI(type.toUpperCase());
    //             console.log("Success to create techno:", dataToReturn);
                
    //             if(dataToReturn > 0){
    //                 const techno = this.#technologies.find(technologie => technologie.id === id).id = dataToReturn;
    //                 id = dataToReturn;
    //             }


    //         } catch (error) {
    //             alert("Error while creating techno - please refresh the page:" + error);
    //         }
    //     }

    //     const technologie = this.#technologies.find(technologie => technologie.id === id);

    //     technologie.level++;

    //     technologie.temps_recherche = Math.round(technologie.temps_recherche * 2);
            
    //     this.upgradeTechnologieToAPI(technologie.id)
    //         .then(() => {
    //             this.notify(oldId, technologie.id);
    //         })
    //         .catch(error => {
    //             alert("Error while upgrading techno - please refresh the page:" + error);
    //         }
    //     );
    // }
        
}