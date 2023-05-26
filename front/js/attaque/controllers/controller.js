import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";

const API_BASE_URL = "http://esirloc/api/boundary/APIinterface/APIattaque.php";
const API_QUERY_PARAMS = {
  defaultEnnemis: (id_Joueur, id_Univers) => `?default_ennemmis&id_Joueur=${id_Joueur}&id_Univers=${id_Univers}`,
  nbDefense: (id_Joueur, id_Univers) => `?nbDefense&id_Player=${id_Joueur}&id_Univers=${id_Univers}`,
};
export class Controller extends Notifier {
  #session;
  #joueurEnnemis;

  constructor() {
    super();
    this.#session = new Session("roro", 2, 1, 355, [1, 2, 3]);
    this.#joueurEnnemis = [];
  }

  get session() {  return this.#session; };
  get joueurEnnemis() { return this.#joueurEnnemis; };

  set session(session) { this.#session = session; };
  set joueurEnnemis(joueurEnnemis) { this.#joueurEnnemis = joueurEnnemis; };
  
  async loadJoueurEnnemis() {
    const response = await fetch(API_BASE_URL + API_QUERY_PARAMS.defaultEnnemis(this.#session.id_Player, this.#session.id_Univers));
    console.log('test');
    const data = await response.json();
    this.#joueurEnnemis = data.filter((joueur) => joueur.id !== this.#session.id);
    this.notify();
  }

  async getFlotteJoueur(){
    let urlParams = new URLSearchParams(window.location.search);
    let flotteParam = urlParams.get('flotte');
  
    if (flotteParam) {
      let flotteData = JSON.parse(decodeURIComponent(flotteParam));
      console.log(flotteData);
    } else {
      console.log('No flotte parameter found in URL.');
    }
  }


}
