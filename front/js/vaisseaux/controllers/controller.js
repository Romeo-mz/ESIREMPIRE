import { Notifier } from "../pattern/notifier.js";
import { Session } from "../models/session.js";
import { Vaisseaux } from "../models/vaisseaux.js";

const API_BASE_URL = "http://esirloc/api/boundary/APIinterface/APIvaisseaux.php";
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
    this.#session = new Session("roro", 2, 1, 355, [1, 2, 3]);
    this.#vaisseaux = [];
    this.#flotte = [];

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
        console.log(this.#vaisseaux);
        if (colonisateurAvailable) {
          flotte.push({ type: "COLONISATEUR", quantity: colonisateurQuantity });
        } else {
          alert("Not enough Colonisateur available");
        }
      }

      console.log("Flotte:", flotte);

      // Faites ce que vous voulez avec la flotte (par exemple, enregistrez-la dans le contrôleur)
      // this.#session.flotte = flotte;

      // Ensuite, vous pouvez invoquer this.notify() pour notifier les observateurs du changement de la flotte.
      // this.notify();
    });
  }

  isVaisseauAvailable(type, quantity) {
    if (quantity > 0) {
      const vaisseau = this.#vaisseaux.find(v => v.type === type);
      return vaisseau && vaisseau.quantite >= quantity;
    }
  }


}
