import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";
import { Vaisseaux } from "../models/vaisseaux.js";

const API_BASE_URL = "http://esirempire/api/boundary/APIinterface/APIvaisseaux.php";
const API_QUERY_PARAMS = {
  defaultVaisseaux: (id_Planet) => `?default_vaisseaux&id_Planet=${id_Planet}`,
  nbVaisseaux: (id_Player, id_Univers) => `?number_vaisseaux&id_Player=${id_Player}&id_Univers=${id_Univers}`,
};
export class Controller extends Notifier {
  #session;
  #vaisseaux;

  constructor() {
    super();
    this.#session = new Session("roro", 2, 1, 355, [1, 2, 3]);
    this.#vaisseaux = [];
  }

  get vaisseaux() { return this.#vaisseaux; }
  set vaisseaux(vaisseaux) { this.#vaisseaux = vaisseaux; }

  get session() { return this.#session; }
  set session(session) { this.#session = session; }

  async fetchData(endpoint) {
    const response = await fetch(API_BASE_URL + endpoint);
    return response.json();
  }

  async loadVaisseaux() {
    const vaisseauData = await this.fetchData(API_QUERY_PARAMS.defaultVaisseaux(this.#session.id_Planet));

    let negativeId = -1;

    const vaisseaux = vaisseauData.map(item => {
      return new Vaisseaux(
        negativeId--,
        item.type,
        item.quantity
      );
    });

    this.#vaisseaux = vaisseaux;
  }

  // ajoutFlotte(vaisseau) {
  //     this.flotte.ajoutVaisseau(vaisseau);
  //   }

  // ajoutVaisseauToApi(vaisseau){
  //   const vaisseauData = {
  //     id: vaisseau.id,
  //     type: vaisseau.type,
  //   };

  // fetch(API_BASE_URL, {
  //   method: "POST",
  //   body: JSON.stringify(vaisseauData),
  // });
  // }
  // supprimerVaisseau(vaisseau) {
  //     this.flotte.retirerVaisseau(vaisseau);
  //   }

  // obtenirVaisseaux() {
  //     return this.flotte.obtenirVaisseaux();
  //   }

  // async loadFlotte(idFlotte) {
  //     const vaisseauData = await fetchData(`?vaisseaux&flotte=${idFlotte}`); 
  //     const flotte = new Flotte(); 

  //     vaisseauData.forEach(({ id, type }) => {
  //       const vaisseau = new Vaisseau(id, type); 

  //       flotte.ajouterVaisseau(vaisseau); 
  //     });

  //     return flotte; 
  //   }
}