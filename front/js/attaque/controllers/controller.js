import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";
import sessionDataService from '../../SessionDataService.js';

const API_BASE_URL = "/api/boundary/APIinterface/APIattaque.php";
const API_QUERY_PARAMS = {
  defaultEnnemis: (id_Joueur, id_Univers) => `?default_ennemis&id_Joueur=${id_Joueur}&id_Univers=${id_Univers}`,
  dataEnnemis: (liste_Ennemis, id_Univers) => `?dataEnnemis&liste_Ennemis=${liste_Ennemis}&id_Univers=${id_Univers}`,
};
export class Controller extends Notifier {
  #session;
  #idJoueurEnnemis;
  #flotteData;
  #joueurEnnemis;

  constructor() {
    super();
    this.#idJoueurEnnemis = [];

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
  
  }

  get session() { return this.#session; };
  get idJoueurEnnemis() { return this.#idJoueurEnnemis; };

  set session(session) { this.#session = session; };
  set idJoueurEnnemis(idJoueurEnnemis) { this.#idJoueurEnnemis = idJoueurEnnemis; };

  async loadJoueurEnnemis() {
    const response = await fetch(API_BASE_URL + API_QUERY_PARAMS.defaultEnnemis(this.#session.id_Player, this.#session.id_Univers));
    if (!response.ok) {
      throw new Error(`Request failed with status ${response.status}`);
    }
    const data = await response.json();
    // console.log(data); // Log the parsed JSON data
    this.#idJoueurEnnemis = data;
    this.notify();
    
  }

  async getFlotteJoueur() {
    let urlParams = new URLSearchParams(window.location.search);
    let flotteParam = urlParams.get('flotte');

    if (flotteParam) {
      let flotteData = JSON.parse(decodeURIComponent(flotteParam));
      this.#flotteData = flotteData;
      return flotteData;
    } else {
      console.log('No flotte parameter found in URL.');
    }
  }

  async getDataEnnemis() {
    const idJoueurEnnemis = this.#idJoueurEnnemis;
    const data = [];
    
    for (const id of idJoueurEnnemis) {
      const response = await fetch(API_BASE_URL + API_QUERY_PARAMS.dataEnnemis(id.id_Joueur, this.#session.id_Univers));
      if (!response.ok) {
        throw new Error(`Request failed with status ${response.status}`);
      }
      
      const responseData = await response.json();
      data.push(responseData);
    }
    // console.log(data); // Log the parsed JSON data for each idJoueurEnnemis
    return data;
    
  }

  async fetchAttaque(JSONdata) {
   
    try {
      const response = await fetch(API_BASE_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSONdata,
      });

      const jsonData = await response.json();
      console.log(jsonData);
      // const dataToReturn = jsonData.id_New_Infrastructure;

      return dataToReturn;
    } catch (error) {
      console.error('Erreur:', error);
      throw error;
    }

  }
    

}
