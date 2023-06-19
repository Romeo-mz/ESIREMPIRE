import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";
import { Vaisseaux } from "../models/vaisseaux.js";
import sessionDataService from '../../SessionDataService.js';

const API_BASE_URL = "../api/boundary/APIinterface/APIvaisseaux.php";
const API_QUERY_PARAMS = {
  defaultVaisseaux: (id_Planet) => `?default_vaisseaux&id_Planet=${id_Planet}`,
  nbVaisseaux: (id_Player, id_Univers) => `?number_vaisseaux&id_Player=${id_Player}&id_Univers=${id_Univers}`,
};
export class Controller extends Notifier {
  #session;
  #vaisseaux;
  #flotte;

  constructor() {
    super();

    this.#vaisseaux = [];
    this.#flotte = [];

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

  get vaisseaux() { return this.#vaisseaux; }
  set vaisseaux(vaisseaux) { this.#vaisseaux = vaisseaux; }

  get session() { return this.#session; }
  set session(session) { this.#session = session; }

  async fetchData(endpoint) {
    const response = await fetch(API_BASE_URL + endpoint);
    return response.json();
  }

  async loadVaisseaux() {
    const vaisseauData = await this.fetchData(API_QUERY_PARAMS.defaultVaisseaux(this.#session.id_CurrentPlanet));

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
  createFlotte(selectedVaisseaux) {
    const flotte = selectedVaisseaux.map(vaisseau => {
      const quantity = parseInt(document.getElementById(`nombre-${vaisseau.id}`).value);
      vaisseau.flotteQuantity = quantity;
      return vaisseau;
    });

    this.#flotte = flotte;
  }
  loadFlotte() {
    const form = document.getElementById("vaisseau-form");
    form.addEventListener("submit", (event) => {
      event.preventDefault();

      const chasseurCheckbox = document.getElementById("vaisseau-chasseur");
      const chasseurQuantityInput = document.getElementById("nombre-vaisseau-chasseur");

      const croiseurCheckbox = document.getElementById("vaisseau-croiseur");
      const croiseurQuantityInput = document.getElementById("nombre-vaisseau-croiseur");

      const transporteurCheckbox = document.getElementById("vaisseau-transporteur");
      const transporteurQuantityInput = document.getElementById("nombre-vaisseau-transporteur");

      const colonisateurCheckbox = document.getElementById("vaisseau-colonisateur");
      const colonisateurQuantityInput = document.getElementById("nombre-vaisseau-colonisateur");

      const flotte = [];

      if (chasseurCheckbox.checked) {
        const chasseurQuantity = parseInt(chasseurQuantityInput.value);
        const chasseurAvailable = this.isVaisseauAvailable("CHASSEUR", chasseurQuantity);
        if (chasseurAvailable) {
          flotte.push({ type: "CHASSEUR", quantity: chasseurQuantity });
        } else {
          alert("Not enough Chasseur available");
        }
      }

      if (croiseurCheckbox.checked) {
        const croiseurQuantity = parseInt(croiseurQuantityInput.value);
        const croiseurAvailable = this.isVaisseauAvailable("CROISEUR", croiseurQuantity);
        if (croiseurAvailable) {
          flotte.push({ type: "CROISEUR", quantity: croiseurQuantity });
        } else {
          alert("Not enough Croiseur available");
        }
      }

      if (transporteurCheckbox.checked) {
        const transporteurQuantity = parseInt(transporteurQuantityInput.value);
        const transporteurAvailable = this.isVaisseauAvailable("TRANSPORTEUR", transporteurQuantity);
        if (transporteurAvailable) {
          flotte.push({ type: "TRANSPORTEUR", quantity: transporteurQuantity });
        } else {
          alert("Not enough Transporteur available");
        }
      }

      if (colonisateurCheckbox.checked) {
        const colonisateurQuantity = parseInt(colonisateurQuantityInput.value);
        const colonisateurAvailable = this.isVaisseauAvailable("COLONISATEUR", colonisateurQuantity);
        if (colonisateurAvailable) {
          flotte.push({ type: "COLONISATEUR", quantity: colonisateurQuantity });
        } else {
          alert("Not enough Colonisateur available");
        }
      }



      this.#session.flotte = flotte;

      this.notify();
      if (this.#session.flotte.length > 0) {
        const flotteData = JSON.stringify(this.#session.flotte);
        console.log(flotteData);
        const encodedData = encodeURIComponent(flotteData);
        const attaqueURL = `attaque.html?flotte=${encodedData}`;
        console.log(attaqueURL);
        // Rediriger l'utilisateur vers la page d'attaque
        window.location.href = attaqueURL;
      }

    });
  }

  isVaisseauAvailable(type, quantity) {

    if (quantity > 0) {
      const vaisseau = this.#vaisseaux.find(v => v.type === type);
      return vaisseau && vaisseau.quantite >= quantity;
    }
  }

  addVaisseauToFlotteToApi() {

    const vaisseauId = document.getElementById("vaisseau-id").value;
  }

  getResultatAttaque(id_Attaquant, id_Defenseur) {
    const resultat = 0;
    return resultat;
  }
}
