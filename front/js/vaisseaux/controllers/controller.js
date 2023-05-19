import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";
import { Vaisseau } from "../models/vaisseaux.js";

const API_BASE_URL = "http://esirempire/api/boundary/APIinterface/APIvaisseaux.php";

export class VaisseauxController extends Notifier{
   #session;
   #vaisseaux;
   #flotte;

    constructor(){
        super();
        this.#session = new Session("roro", 2, 1, 355, [1, 2, 3]);
        this.#vaisseaux = [];
        this.#flotte = [];
    }

    get vaisseau(){ return this.#vaisseaux; }
    set vaisseau(vaisseaux){ this.#vaisseaux = vaisseaux; }

    async fetchData(endpoint) {
        const response = await fetch(API_BASE_URL + endpoint);
        return response.json();
    }

    async loadVaisseaux(){
        const vaisseauData = await this.fetchData("?number_vaisseaux&id_Player=" + this.#session.id_Player + "&id_Univers=" + this.#session.id_Univers );
        this.#vaisseaux = vaisseauData.map(({id_Vaisseau, type}) => 
            new Vaisseau(id_Vaisseau, type)
        );
    }

    ajoutFlotte(vaisseau) {
        this.flotte.ajoutVaisseau(vaisseau);
      }
    
      supprimerVaisseau(vaisseau) {
        this.flotte.retirerVaisseau(vaisseau);
      }
    
      obtenirVaisseaux() {
        return this.flotte.obtenirVaisseaux();
      }
    
      async loadFlotte(idFlotte) {
        const vaisseauData = await fetchData(`?vaisseaux&flotte=${idFlotte}`); 
        const flotte = new Flotte(); 
      
        vaisseauData.forEach(({ id, type }) => {
          const vaisseau = new Vaisseau(id, type); 
      
          flotte.ajouterVaisseau(vaisseau); 
        });
      
        return flotte; 
      }

    
}