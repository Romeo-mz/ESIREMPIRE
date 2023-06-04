# Documentation de l'API

Auteur: GONCALVEZ Hugo, MARTINEZ Roméo  
Date: Le 23/05/2023

## Table des matières
- [Introduction](#introduction)
- [Architecture de l'API](#architecture-de-lapi)
  - [Introduction](#introduction-1)
  - [Boundary](#boundary)
    - [APIinterface](#apiinterface)
    - [DBinterface](#dbinterface)
  - [Controller](#controller)
    - [SessionController](#sessioncontroller)
    - [Administration](#administration)
    - [Authentifier](#authentifier)
    - [Galaxy](#galaxy)
    - [Infrastructure](#infrastructure)
    - [Search](#search)
    - [Spacework](#spacework)
    - [Vaisseaux](#vaisseaux)
- [Utilisation de l'API](#utilisation-de-lapi)
  - [Authentification](#authentification)
  - [Requêtes](#requêtes)
- [Conclusion](#conclusion)

## Introduction
Ici, vous pouvez ajouter une introduction générale à votre API.

## Architecture de l'API
### Introduction
Cette API utilise une architecture MVC

### Boundary
Le dossier `boundary` est composé de deux sous-dossiers : `APIinterface` et `DBinterface`.

#### APIinterface
Le dossier `APIinterface` contient les fichiers suivants :
- APIadmin
- APIattaque
- APIgalaxy
- APIinfrastructures
- APIinterface
- APIlogin
- APIregister
- APIsearch
- APIspacework
- APIvaisseaux

Les fichiers `APIinterface` servent d'entrée pour les différentes demandes.

#### DBinterface
Le dossier `DBinterface` contient les fichiers suivants :
- DBadmin
- DBattaque
- DBgalaxy
- DBinfrastructures
- DBinterface
- DBlogin
- DBregister
- DBsearch
- DBspacework
- DBvaisseaux

Les fichiers `DBinterface` fournissent un accès directe à la base de donnée SQL.

### Controller
Le dossier `controller` contient les contrôleurs suivants :
- SessionController
- Administration
- Authentifier
- Galaxy
- Infrastructure
- Search
- Spacework
- Vaisseaux

#### SessionController
Le contrôleur `SessionController` est utilisé pour gérer les sessions utilisateur. Il contient les méthodes suivantes :
- Méthode1 : Description de la méthode 1
- Méthode2 : Description de la méthode 2
- Méthode3 : Description de la méthode 3

#### Administration
Le contrôleur `Administration` est utilisé pour gérer les tâches d'administration. Il contient les méthodes suivantes :
- Méthode1 : Description de la méthode 1
- Méthode2 : Description de la méthode 2
- Méthode3 : Description de la méthode 3

#### Authentifier
Le contrôleur `Authentifier` est utilisé pour gérer l'authentification des utilisateurs. Il contient les méthodes suivantes :
- Méthode1 : Description de la méthode 1
- Méthode2 : Description de la méthode 2
- Méthode3 : Description de la méthode 3

#### Galaxy
Le contrôleur `Galaxy` est utilisé pour gérer les données relatives aux galaxies. Il contient les méthodes suivantes :
- Méthode1 : Description de la méthode 1
- Méthode2 : Description de la méthode 2
- Méthode3 : Description de la méthode 3

#### Infrastructure
Le contrôleur `Infrastructure` est utilisé pour gérer les données relatives à l'infrastructure. Il contient les méthodes suivantes :
- Méthode1 : Description de la méthode 1
- Méthode2 : Description de la méthode 2
- Méthode3 : Description de la méthode 3

#### Search
Le contrôleur `Search` est utilisé pour gérer les recherches d'éléments dans l'API. Il contient les méthodes suivantes :
- Méthode1 : Description de la méthode 1
- Méthode2 : Description de la méthode 2
- Méthode3 : Description de la méthode 3

#### Spacework
Le contrôleur `Spacework` est utilisé pour gérer les données relatives aux travaux spatiaux. Il contient les méthodes suivantes :
- Méthode1 : Description de la méthode 1
- Méthode2 : Description de la méthode 2
- Méthode3 : Description de la méthode 3

#### Vaisseaux
Le contrôleur `Vaisseaux` est utilisé pour gérer les données relatives aux vaisseaux spatiaux. Il contient les méthodes suivantes :
- Méthode1 : Description de la méthode 1
- Méthode2 : Description de la méthode 2
- Méthode3 : Description de la méthode 3

## Utilisation de l'API
Pour utiliser l'API il suffit de réaliser les différentes requetes vues ci-dessous.

### Requêtes

Interface `/api/boundary/APIinterface/APIadmin.php`:

    Endpoint: /api/boundary/apiinterface/apiadmin.php?universes
    Method: GET
    Output: JSON array of universes with their IDs and names, like [{"id":"1","nom":"universe1"},{"id":"2","nom":"universe2"}]


Interface `/api/boundary/APIinterface/APIinfrastructures.php`:
 * 1. GET /api/boundary/apiinterface/apiinfrastructures.php?id_Planet={id_Planet}&bonus_ressources
 *    - Input: id_Planet (integer)
 *    - Output: JSON object containing the bonus resources for the specified planet ID
 * 2. GET /api/boundary/apiinterface/apiinfrastructures.php?id_Planet={id_Planet}
 *    - Input: id_Planet (integer)
 *    - Output: JSON object containing the infrastructures for the specified planet ID
 * 3. GET /api/boundary/apiinterface/apiinfrastructures.php?default_defense
 *    - Output: JSON object containing the default defense infrastructure
 * 4. GET /api/boundary/apiinterface/apiinfrastructures.php?default_installation
 *    - Output: JSON object containing the default installation infrastructure
 * 5. GET /api/boundary/apiinterface/apiinfrastructures.php?default_ressource
 *    - Output: JSON object containing the default resource infrastructure
 * 6. GET /api/boundary/apiinterface/apiinfrastructures.php?id_Player={id_Player}&id_Universe={id_Universe}&quantity_ressource_player
 *    - Input: id_Player (integer), id_Universe (integer)
 *    - Output: JSON object containing the quantity of resources for the specified player and universe
 * 7. GET /api/boundary/apiinterface/apiinfrastructures.php?techno_required
 *    - Output: JSON object containing the required technologies
 * 8. GET /api/boundary/apiinterface/apiinfrastructures.php?infra_techno_required
 *    - Output: JSON object containing the required infra technologies
 * 9. GET /api/boundary/apiinterface/apiinfrastructures.php?id_Labo={id_Labo}&technologies
 *    - Input: id_Labo (integer)
 *    - Output: JSON object containing the technologies for the specified laboratory ID
 * 10. POST /api/boundary/apiinterface/apiinfrastructures.php (JSON payload)
 *    - Input: JSON object containing id_Planet (integer) and id_Infrastructure (integer)
 *    - Output: 200 OK response on successful infrastructure upgrade
 * 11. POST /api/boundary/apiinterface/apiinfrastructures.php (JSON payload)
 *    - Input: JSON object containing id_Planet (integer), infraType (string), and type (string)
 *    - Output: JSON object containing the new infrastructure ID
 * 12. POST /api/boundary/apiinterface/apiinfrastructures.php (JSON payload)
 *    - Input: JSON object containing id_Ressource (integer) and quantite (integer)
 *    - Output: 200 OK response on successful resource quantity update

Interface `/api/boundary/APIinterface/APIattaque.php`:
* GET: /api/boundary/apiinterface/apiattaque.php?default_ennemis=&id_Joueur={player_id}&id_Univers={universe_id}
* POST: /api/boundary/apiinterface/apiattaque.php
* Input (JSON): {
*   "id_Attacker_Player": int,
*   "id_Defender_Player": int,
*   "id_Attacker_Planet": int,
*   "id_Defender_Planet": int,
*   "fleet_Attacker": array
* }

Interface `/api/boundary/APIinterface/APIgalaxy.php`:
* Endpoint: /api/boundary/apiinterface/apigalaxy.php?planets&universe={id_Universe}&galaxy={id_Galaxy}&solarsystem={id_SolarSystem}
* Method: GET
* Input: id_Universe (integer), id_Galaxy (integer), id_SolarSystem (integer)
* Output: JSON array of planets in the specified universe, galaxy, and solar system.
*
* Endpoint: /api/boundary/apiinterface/apigalaxy.php?get_planet_name&id_planet={id_planet}
* Method: GET
* Input: id_planet (integer)
* Output: JSON object with the name of the specified planet.
* Endpoint: /api/boundary/apiinterface/apigalaxy.php
* Method: POST
* Input: JSON object with the following properties:
*        - id_Planet (integer)
*        - new_planet_name (string)
* Output: HTTP status code only (200 for success, 400 for bad request)

Interface `/api/boundary/APIinterface/APIlogin.php`:
* Endpoint POST /api/boundary/apiinterface/apilogin.php
* Input JSON { "username": string, "password": string, "universe": string }
* Output JSON { "success": bool, "message": string, "data": mixed } or HTTP error status code with a message

Interface `/api/boundary/APIinterface/APIregister.php`:
* Endpoint: POST /api/boundary/apiinterface/APIregister.php
 * Required parameters:
 * - `username`: string, a username for the new user.
 * - `password`: string, a password for the new user.
 * - `email`: string, an email address for the new user.
 *
 * Possible responses:
 * - 200 OK: Registration successful.
 * - 400 Bad Request: Missing required parameters.
 * - 401 Unauthorized: Invalid input or user/email already exists.

Interface `/api/boundary/APIinterface/APIsearch.php`:
 *  Endpoints
 * ### GET `/api/boundary/apiinterface/APIsearch.php`
 * - `id_Labo` (int): The laboratory ID
 * - `id_Planet` (int): The planet ID
 * Returns: A JSON object with the laboratory ID, like `{"id_Labo": 1}`
 *
 * ### GET `/api/boundary/apiinterface/APIsearch.php`
 * - `default_technologies` (bool): A flag to request the default technologies
 * Returns: A JSON array of default technologies
 *
 * ### GET `/api/boundary/apiinterface/APIsearch.php`
 * - `quantity_ressource_player` (bool): A flag to request the resource quantity of a player
 * - `id_Player` (int): The player ID
 * - `id_Universe` (int): The universe ID
 * Returns: A JSON object containing the resource quantity of the player
 *
 * ### GET `/api/boundary/apiinterface/APIsearch.php`
 * - `technologies` (bool): A flag to request the technologies for a laboratory
 * - `id_Labo` (int): The laboratory ID
 * Returns: A JSON array of technologies
 *
 * ### GET `/api/boundary/apiinterface/APIsearch.php`
 * - `techno_required` (bool): A flag to request the required technologies
 * Returns: A JSON array of required technologies
 *
 * ### POST `/api/boundary/apiinterface/APIsearch.php`
 * - `id_Labo` (int): The laboratory ID
 * - `id_Technologie` (int): The technology ID
 * Action: Upgrades the technology
 * Returns: A 200 OK status
 *
 * ### POST `/api/boundary/apiinterface/APIsearch.php`
 * - `id_Labo` (int): The laboratory ID
 * - `type` (string): The technology type
 * Action: Creates a new technology for the laboratory
 * Returns: A JSON object with the new technology ID, like `{"id_New_Technologie": 1}`
 *
 * ### POST `/api/boundary/apiinterface/APIsearch.php`
 * - `id_Ressource` (int): The resource ID
 * - `quantite` (int): The resource quantity
 * Action: Updates the resource quantity
 * Returns: A 200 OK status

Interface `/api/boundary/APIinterface/APIspacework.php`:
* Endpoints
* GET /api/boundary/apiinterface/APIspacework.php?id_Spacework={id_Spacework}&id_Planet={id_Planet}
* Response: {"id_Spacework": "{spaceworkID}"}
* 
* GET /api/boundary/apiinterface/APIspacework.php?default_ships
* Response: [{}, {}, ...] (list of default ships)
* 
* GET /api/boundary/apiinterface/APIspacework.php?quantity_ressource_player&id_Player={id_Player}&id_Universe={id_Universe}
* Response: {"id_Player": "{id_Player}", "id_Universe": "{id_Universe}", "quantity_ressource_player": {}}
* 
* GET /api/boundary/apiinterface/APIspacework.php?nbships&id_Spacework={id_Spacework}
* Response: {"id_Spacework": "{id_Spacework}", "nbships": {}}
*
* GET /api/boundary/apiinterface/APIspacework.php?technologiesPlayer&id_Planet={id_Planet}
* Response: [{"id_Technology": "{id_Technology}", "name": "{name}", "level": {level}}, ...]
*
*  POST /api/boundary/apiinterface/APIspacework.php
* Request: {"id_Spacework": "{id_Spacework}", "type": "{type}"}
* Response: 200 OK
*
* POST /api/boundary/apiinterface/APIspacework.php
* Request: {"id_Ressource": "{id_Ressource}", "quantite": {quantite}}
* Response: 200 OK

Interface `/api/boundary/APIinterface/APIvaisseaux.php`:
GET Request - Fetch Default Spaceships for a Planet
 * URL: /api/boundary/apiinterface/APIvaisseaux.php?default_vaisseaux=[BOOLEAN]&id_Planet=[ID]
 * Response (JSON):
 * {
 *   "id_Planet": (integer) Planet ID,
 *   "default_vaisseaux": (array) List of default spaceships for the given planet,
 *   GET Request - Fetch Spaceship ID
 * URL: /api/boundary/apiinterface/APIvaisseaux.php?id_Vaisseaux=[ID]&id_Univers=[ID]
 * Response (JSON):
 * {
 *   "id_Vaisseaux": (integer) Spaceship ID,
 *   ...
 * }
 * POST Request
 * URL: /api/boundary/apiinterface/APIvaisseaux.php
 * Request Body (JSON):
 * {
 *   "nombre-vaisseau-chasseur": (integer) Number of hunter ships,
 *   "nombre-vaisseau-croiseur": (integer) Number of cruiser ships,
 *   "nombre-vaisseau-transporteur": (integer) Number of transporter ships,
 *   "nombre-vaisseau-colonisateur": (integer) Number of colonizer ships
 * }
 * Response: A redirect to /front/attaque.php
