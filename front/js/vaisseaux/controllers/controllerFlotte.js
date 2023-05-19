import { Flotte } from './flotte.js';
import { Vaisseau } from './vaisseau.js';

export class FlotteController {
  constructor() {
    this.flotte = new Flotte();
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

  async loadAllVaissaux(id) {
    

  
}
