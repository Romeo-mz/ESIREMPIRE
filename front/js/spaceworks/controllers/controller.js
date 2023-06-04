import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";
import { QuantiteRessource } from "../models/quantiteressource.js";
import { ShipTechnoRequired } from "../models/shiptechnorequired.js";
import { Technologie } from "../models/technologie.js";
import { Ship } from "../models/ship.js";
import sessionDataService from '../../SessionDataService.js';

const API_BASE_URL = "/api/boundary/APIinterface/APIspacework.php";
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
    #shipTechnoRequired;
    #technologiesPlayer;
    #spaceworkID;

    constructor()
    {
        super();
        this.#ships = [];
        this.#technologiesPlayer = [];
        this.#quantiteRessource = [];
        
        this.#spaceworkID = -1;

        this.#shipTechnoRequired = [];
        this.#shipTechnoRequired.push(new ShipTechnoRequired("CROISEUR", "IONS", "4"));

        let id_Planets = [];
        let id_Ressources = [];

        for (let i = 0; i < sessionDataService.getSessionData().id_Planets.length; i++)
        {
            id_Planets[i] = parseInt(sessionDataService.getSessionData().id_Planets[i].id);
        }
        for (let i = 0; i < sessionDataService.getSessionData().id_Ressources.length; i++)
        {
            id_Ressources[i] = parseInt(sessionDataService.getSessionData().id_Ressources[i].id);
        }

        this.#session = new Session(sessionDataService.getSessionData().pseudo, parseInt(sessionDataService.getSessionData().id_Player), parseInt(sessionDataService.getSessionData().id_Univers), id_Planets, id_Ressources, parseInt(sessionDataService.getSessionData().id_CurrentPlanet));
    
        // Increase resources every minute
        setInterval(() => {
            this.loadQuantitiesRessource();
            this.notifyResources();
        }, 20 * 1000);
    
    }

    get ships() { return this.#ships; }
    get session() { return this.#session; }
    get quantiteRessource() { return this.#quantiteRessource; }
    get technologiesPlayer() { return this.#technologiesPlayer; }
    get shipTechnoRequired() { return this.#shipTechnoRequired; }
    get spaceworkID() { return this.#spaceworkID; }

    set ships(ships) { this.#ships = ships; }
    set spaceworkID(spaceworkID) { this.#spaceworkID = spaceworkID; }
    set session(session) { this.#session = session; }
    set quantiteRessource(quantiteRessource) { this.#quantiteRessource = quantiteRessource; }
    set technologiesPlayer(technologiesPlayer) { this.#technologiesPlayer = technologiesPlayer; }
    set shipTechnoRequired(shipTechnoRequired) { this.#shipTechnoRequired = shipTechnoRequired; }


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

    setUpgradingSomething(id)
    {
        const ship = this.#ships.find(ship => ship.id === id);
        ship.upgradingState = true;
    }

    isUpgradingSomething()
    {
        return this.#ships.some(ship => ship.isUpgrading());
    }

    async loadSpaceworkID()
    {
        const data = await this.fetchData(API_QUERY_PARAMS.spaceworkID(this.#session.id_CurrentPlanet));

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
            const data = await this.fetchData(API_QUERY_PARAMS.technologiesPlayer(this.#session.id_CurrentPlanet));

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

    checkEnoughRessource(id) 
    {
        const ship = this.#ships.find(ship => ship.id === id);

        const quantiteMetal = parseInt(this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite);
        const quantiteDeuterium = parseInt(this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite);
        
        if (quantiteDeuterium < ship.cout_deuterium || quantiteMetal < ship.cout_metal) 
        {
            return false;
        }

        return true;
    }

    decreaseRessource(id) 
    {
        const ship = this.#ships.find(ship => ship.id === id);

        const idQuantiteMetal = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").id;
        const quantiteMetal = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite;

        const idQuantiteDeuterium = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").id;
        const quantiteDeuterium = this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite;

        this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "METAL").quantite -= ship.cout_metal;
        this.#quantiteRessource.find(quantiteRessource => quantiteRessource.type === "DEUTERIUM").quantite -= ship.cout_deuterium;

        this.decreaseRessourceToAPI(idQuantiteMetal, "METAL", ship.cout_metal);
        this.decreaseRessourceToAPI(idQuantiteDeuterium, "DEUTERIUM", ship.cout_deuterium);

    }

    async decreaseRessourceToAPI(id, type, quantite) 
    {
        const ressourceData = {
            id_Ressource: parseInt(id),
            quantite: parseInt(quantite)
        };

        fetch(API_BASE_URL, {
            method: 'POST',
            body: JSON.stringify(ressourceData)
        });
    }
    
    async addShipToAPI(type) {
        const shipData = {
            id_Spacework: this.#spaceworkID,
            type: type
        };
    
        fetch(API_BASE_URL, {
            method: 'POST',
            body: JSON.stringify(shipData),
        });
    }    


    async addShip(id, type) 
    {
        const ship = this.#ships.find(ship => ship.id === id);

        this.decreaseRessource(id, type);
        
        ship.upgradingState = false;

        try {
            const dataToReturn = await this.addShipToAPI(type.toUpperCase());
            console.log("Success to add ship");
            
            ship.quantite = parseInt(ship.quantite) + 1;

            this.notify(id);


        } catch (error) {
            alert("Error while adding ship - please refresh the page:" + error);
        }
    }
        
}