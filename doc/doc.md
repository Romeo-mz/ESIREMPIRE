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
@note Fetch à réaliser: GET /api/boundary/apiinterface/apiadmin.php?universes
@note JSON renvoyé: [{"id":"id de l'univers","nom":"nom univers"}].

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
* Endpoint: /api/boundary/apiinterface/apiattaque.php
     * Input (JSON): {
     *   "id_Attacker_Player": int,
     *   "id_Defender_Player": int,
     *   "id_Attacker_Planet": int,
     *   "id_Defender_Planet": int,
     *   "fleet_Attacker": array
     * }

Interface `/api/boundary/APIinterface/APIgalaxy.php`:
