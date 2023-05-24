import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";
import { CelestialBody } from "../models/celestial-object.js";
import { SessionService } from "../../SessionService.js";

const API_BASE_URL = "http://esirempire/api/boundary/APIinterface/APIgalaxy.php";
const API_QUERY_PARAMS = {
    loadPlanets: (universeId, galaxyId, systemId) => `?planets&id_Universe=${universeId}&id_Galaxy=${galaxyId}&id_SolarSystem=${systemId}`
};

export class Controller extends Notifier
{
    #session;
    #galaxiesList;
    #solarSystem;
    #solarSystemList;

    constructor()
    {
        super();

        this.#galaxiesList = [
            {
                id: [],
                name: []
            }
        ];

        this.#solarSystemList = [
            {
                id: [],
                name: []
            }
        ];
        
        this.#solarSystem = {
            sun: new CelestialBody(-1, "Sun", "", 40, 0, "#fff68f", 0.1, 0),
            planets: []
        };

        const sessionServiceString = sessionStorage.getItem('sessionService');
        const sessionService = JSON.parse(sessionServiceString).sessionData;

        for (let i = 0; i < sessionService.id_Planets.length; i++)
        {
            sessionService.id_Planets[i] = parseInt(sessionService.id_Planets[i].id);
        }
        for (let i = 0; i < sessionService.id_Ressources.length; i++)
        {
            sessionService.id_Ressources[i] = parseInt(sessionService.id_Ressources[i].id);
        }

        this.#session = new Session(sessionService.pseudo, parseInt(sessionService.id_Player), parseInt(sessionService.id_Univers), sessionService.id_Planets, sessionService.id_Ressources);
    }

    get session() { return this.#session; }
    set session(session) { this.#session = session; }

    get galaxiesList() { return this.#galaxiesList; }
    set galaxiesList(galaxiesList) { this.#galaxiesList = galaxiesList; }

    get solarSystemList() { return this.#solarSystemList; }
    set solarSystemList(solarSystemList) { this.#solarSystemList = solarSystemList; }

    get solarSystem() { return this.#solarSystem; }
    set solarSystem(solarSystem) { this.#solarSystem = solarSystem; }

    async fetchData(endpoint) {
        const response = await fetch(API_BASE_URL + endpoint);
        return response.json();
    }

    goToInfrastructurePage(planetId)
    {
        const sessionData = { id_Current_Planet: planetId };
        // get the previous sessionService from sessionStorage
        const sessionServiceString = sessionStorage.getItem('sessionService');
        const sessionService = JSON.parse(sessionServiceString).sessionData;

        console.log(sessionService);


        // save the updated sessionService in sessionStorage
        // sessionStorage.setItem('sessionService', JSON.stringify(sessionService));

        
        // window.location.href = "./infrastructures.html";
    }

    loadNewPlanets(galaxyId, systemId)
    {
        this.loadPlanets(galaxyId, systemId)
            .then(() => {
                this.notify(galaxyId, systemId);
            }
        );
    }

    async loadPlanets(galaxyId, systemId = 0) 
    {


        // Empty
        this.#solarSystem.planets = [];
        this.#solarSystem.sun.satellites = [];
        this.#galaxiesList = [];
        this.#solarSystemList = [];

        const data = await this.fetchData(API_QUERY_PARAMS.loadPlanets(this.#session.id_Univers, galaxyId, systemId));

        const galaxiesList = data.galaxies;
        const solarSystemList = data.sys_sols;

        const celestialBodyConfig = {
            "1": { radius: 15, distance: 70, color: "#4f4160", rotationSpeed: 0.5, orbitalSpeed: 0.5 },
            "2": { radius: 20, distance: 130, color: "#d3a147", rotationSpeed: 0.2, orbitalSpeed: 0.2 },
            "3": { radius: 30, distance: 180, color: "#355ca3", rotationSpeed: 0.35, orbitalSpeed: 0.35 },
            "4": { radius: 18, distance: 240, color: "#a33a35", rotationSpeed: 0.05, orbitalSpeed: 0.05 },
            "5": { radius: 20, distance: 290, color: "#a33a35", rotationSpeed: 0.45, orbitalSpeed: 0.45 },
            "6": { radius: 22, distance: 350, color: "#a33a35", rotationSpeed: 0.25, orbitalSpeed: 0.25 },
            "7": { radius: 15, distance: 400, color: "#a33a35", rotationSpeed: 0.15, orbitalSpeed: 0.15 },
            "8": { radius: 12, distance: 440, color: "#a33a35", rotationSpeed: 0.4, orbitalSpeed: 0.4 },
            "9": { radius: 20, distance: 490, color: "#a33a35", rotationSpeed: 0.08, orbitalSpeed: 0.08 },
            "10": { radius: 25, distance: 550, color: "#a33a35", rotationSpeed: 0.20, orbitalSpeed: 0.20 },
        };
    
        const createCelestialBody = (item, config) => {
            return new CelestialBody(
                item.id,
                item.nom,
                item.pseudo,
                config.radius,
                config.distance,
                config.color,
                config.rotationSpeed,
                config.orbitalSpeed,
                true
            );
        };
    
        const planets = data.planets.map(item => {
            const config = celestialBodyConfig[item.position];
            if (config) {
                this.#solarSystem.sun.addSatellite(createCelestialBody(item, config));
                return createCelestialBody(item, config);
            }
        });

        this.#galaxiesList = galaxiesList;
        this.#solarSystemList = solarSystemList;
        this.#solarSystem.planets = planets;
    }   
}