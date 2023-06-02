import { Observer } from "../pattern/observer.js";
export class View extends Observer {
  #controller;

  constructor(controller) {
    super();
    this.#controller = controller;
    this.#controller.addObserver(this);

    this.loadJoueurEnnemis();
  }

  loadJoueurEnnemis() {
    const ennemisTableBody = document.querySelector('#joueur-liste');
    ennemisTableBody.innerHTML = '';

    const attackerId = this.#controller.session.id_Player;
    const fleetData = this.#controller.getFlotteJoueur();
    // console.log(fleetData);

    this.#controller.getDataEnnemis().then((data) => {
      data.forEach((ennemi, index) => {
        const defenderId = ennemi[index].id_defender;
        const idDefenderPlanet = ennemi[index].id_planete;

        const jsonData = {
          id_Attacker_Player: attackerId,
          id_Defender_Player: defenderId,
          id_Attacker_Planet: this.#controller.session.id_Player, // Set the attacker's planet ID
          id_Defender_Planet: idDefenderPlanet, // Set the defender's planet ID
          fleet_Attacker: fleetData
        }
        // console.log(jsonData);
        const row = document.createElement('tr');

        const jsonDataTd = document.createElement('td');
        const jsonDataInput = document.createElement('input');
        jsonDataInput.type = 'hidden';
        jsonDataInput.name = 'json_data';
        jsonDataInput.value = JSON.stringify(jsonData);
        jsonDataTd.appendChild(jsonDataInput);
        row.appendChild(jsonDataTd);

        const radioTd = document.createElement('td');
        const radioInput = document.createElement('input');
        radioInput.type = 'radio';
        radioInput.name = 'ennemi-' + ennemi.id; // Update to use a unique identifier
        radioInput.value = index;
        radioTd.appendChild(radioInput);
        row.appendChild(radioTd);

        const pseudoTd = document.createElement('td');
        pseudoTd.id = "id_Defender_Player";//this.#sessionId;
        pseudoTd.textContent = ennemi[index].pseudo;

        row.appendChild(pseudoTd);

        const galaxieTd = document.createElement('td');
        galaxieTd.textContent = ennemi[index].nom_galaxie;
        row.appendChild(galaxieTd);

        const systemeTd = document.createElement('td');
        systemeTd.textContent = ennemi[index].nom_systeme_solaire;
        row.appendChild(systemeTd);

        const planeteTd = document.createElement('td');
        planeteTd.textContent = ennemi[index].nom_planete;
        row.appendChild(planeteTd);

        const flotteTd = document.createElement('td');
        flotteTd.textContent = ennemi[index].flotte;
        row.appendChild(flotteTd);

        ennemisTableBody.appendChild(row);
      });
    });
  }



  createOrUpdateElement(tagName, id, className, innerHTML = "") {
    let element = document.getElementById(id);

    if (!element) {
      element = document.createElement(tagName);
      element.id = id;
      element.className = className;
    }

    element.innerHTML = innerHTML;
    return element;
  }



  notify() {
    this.loadJoueurEnnemis();
  }

}