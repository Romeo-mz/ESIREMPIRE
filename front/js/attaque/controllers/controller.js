import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";

const API_BASE_URL = "http://esirloc/api/boundary/APIinterface/APIattaque.php";
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
    this.#session = new Session("roro", 2, 1, 355, [1, 2, 3]);
    this.#idJoueurEnnemis = [];
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


}
