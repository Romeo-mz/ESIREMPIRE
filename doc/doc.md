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

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php?id_Planet={id_Planet}&bonus_ressources
    Method: GET
    Input: id_Planet (integer)
    Output: JSON object containing the bonus resources for the specified planet ID

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php?id_Planet={id_Planet}
    Method: GET
    Input: id_Planet (integer)
    Output: JSON object containing the infrastructures for the specified planet ID

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php?default_defense
    Method: GET
    Output: JSON object containing the default defense infrastructure

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php?default_installation
    Method: GET
    Output: JSON object containing the default installation infrastructure

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php?default_ressource
    Method: GET
    Output: JSON object containing the default resource infrastructure

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php?id_Player={id_Player}&id_Universe={id_Universe}&quantity_ressource_player
    Method: GET
    Input: id_Player (integer), id_Universe (integer)
    Output: JSON object containing the quantity of resources for the specified player and universe

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php?techno_required
    Method: GET
    Output: JSON object containing the required technologies

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php?infra_techno_required
    Method: GET
    Output: JSON object containing the required infra technologies

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php?id_Labo={id_Labo}&technologies
    Method: GET
    Input: id_Labo (integer)
    Output: JSON object containing the technologies for the specified laboratory ID

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php
    Method: POST
    Input: JSON object containing id_Planet (integer) and id_Infrastructure (integer)
    Output: 200 OK response on successful infrastructure upgrade

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php
    Method: POST
    Input: JSON object containing id_Planet (integer), infraType (string), and type (string)
    Output: JSON object containing the new infrastructure ID

    Endpoint: /api/boundary/apiinterface/apiinfrastructures.php
    Method: POST
    Input: JSON object containing id_Ressource (integer) and quantite (integer)
    Output: 200 OK response on successful resource quantity update

Interface `/api/boundary/APIinterface/APIattaque.php`:


    Endpoint: /api/boundary/apiinterface/apiattaque.php?default_ennemis=&id_Joueur={player_id}&id_Univers={universe_id}
    Method: GET
    Input: player_id (integer), universe_id (integer)
    Output: JSON object containing the default enemies for the specified player and universe

    Endpoint: /api/boundary/apiinterface/apiattaque.php
    Method: POST
    Input: JSON object containing id_Attacker_Player (integer), id_Defender_Player (integer), id_Attacker_Planet (integer), id_Defender_Planet (integer), and fleet_Attacker (array)
    Output: A redirect to /front/attaque.php


Interface `/api/boundary/APIinterface/APIgalaxy.php`:


    Endpoint: /api/boundary/apiinterface/apigalaxy.php?planets&universe={id_Universe}&galaxy={id_Galaxy}&solarsystem={id_SolarSystem}
    Method: GET
    Input: id_Universe (integer), id_Galaxy (integer), id_SolarSystem (integer)
    Output: JSON array of planets in the specified universe, galaxy, and solar system.

    Endpoint: /api/boundary/apiinterface/apigalaxy.php?get_planet_name&id_planet={id_planet}
    Method: GET
    Input: id_planet (integer)
    Output: JSON object with the name of the specified planet.

    Endpoint: /api/boundary/apiinterface/apigalaxy.php
    Method: POST
    Input: JSON object containing id_Planet (integer) and new_planet_name (string)
    Output: HTTPstatus code 200 OK on successful planet name update


Interface `/api/boundary/APIinterface/APIlogin.php`:

    Endpoint: /api/boundary/apiinterface/apilogin.php
    Method: POST
    Input: { "username": string, "password": string, "universe": string }
    Output: { "success": bool, "message": string, "data": mixed } or HTTP error status code with a message

Interface `/api/boundary/APIinterface/APIregister.php`:

    Endpoint: /api/boundary/apiinterface/APIregister.php
    Method: POST
    Input: { "username": string, "password": string, "email": string }
    Output: { "success": bool, "message": string, "data": mixed } or HTTP error status code with a message
    Message: 200 OK: Registration successful.
            - 400 Bad Request: Missing required parameters.
            - 401 Unauthorized: Invalid input or user/email already exists.

Interface `/api/boundary/APIinterface/APIsearch.php`:
 
    Endpoint: /api/boundary/apiinterface/apirecherche.php?get_recherche_info&id_Technologie={id_Technologie}
    Method: GET
    Input: id_Technologie (integer)
    Output: JSON object containing the information for the specified technology ID

    Endpoint: /api/boundary/apiinterface/apirecherche.php?get_recherche_id&nom_Technologie={nom_Technologie}
    Method: GET
    Input: nom_Technologie (string)
    Output: JSON object containing the ID for the specified technology name

    Endpoint: /api/boundary/apiinterface/apirecherche.php?create_recherche
    Method: POST
    Input: JSON object containing id_Labo (integer), id_Technologie_Type (integer), and niveau (integer)
    Output: JSON object containing the new technology ID

    Endpoint: /api/boundary/apiinterface/apirecherche.php?update_recherche
    Method: POST
    Input: JSON object containing id_Technologie (integer) and niveau (integer)
    Output: HTTP status code 200 OK on successful technology information update.


Interface `/api/boundary/APIinterface/APIspacework.php`:

    Endpoint: /api/boundary/apiinterface/APIspacework.php?id_Spacework={id_Spacework}&id_Planet={id_Planet}
    Method: GET
    Input: id_Planet (string)
    Output: {"id_Spacework": "{spaceworkID}"}

    Endpoint: /api/boundary/apiinterface/APIspacework.php?default_ships
    Method: GET
    Input: default_ships (string)
    Output: [{}, {}, ...] (list of default ships)
    
    Endpoint: /api/boundary/apiinterface/APIspacework.php?quantity_ressource_player&id_Player={id_Player}&id_Universe={id_Universe}
    Method: GET
    Input: quantity_ressource_player (string), id_Player, id_Universe
    Output: {"id_Player": "{id_Player}", "id_Universe": "{id_Universe}", "quantity_ressource_player": {}}
    
    Endpoint: /api/boundary/apiinterface/APIspacework.php?nbships&id_Spacework={id_Spacework}
    Method: GET
    Input: nbships (string), id_Spacework
    Output: {"id_Spacework": "{id_Spacework}", "nbships": {}}
    
    Endpoint: /api/boundary/apiinterface/APIspacework.php?technologiesPlayer&id_Planet={id_Planet}
    Method: GET
    Input: technologiesPlayer (string), id_Planet
    Output: [{"id_Technology": "{id_Technology}", "name": "{name}", "level": {level}}, ...]

    Endpoint: /api/boundary/apiinterface/APIspacework.php
    Method: POST
    Input: id_Spacework (string), id_Spacework, type
    Output: 200 OK
    
    Endpoint: /api/boundary/apiinterface/APIspacework.php
    Method: POST
    Input: id_Ressource (string), quantite
    Output: 200 OK

Interface `/api/boundary/APIinterface/APIvaisseaux.php`:

    Endpoint: /api/boundary/apiinterface/apivaisseau.php?get_vaisseau_info&id_Vaisseau={id_Vaisseau}
    Method: GET
    Input: id_Vaisseau (integer)
    Output: JSON object containing the information for the specified spaceship ID

    Endpoint: /api/boundary/apiinterface/apivaisseau.php?create_vaisseau
    Method: POST
    Input: JSON object containing id_Joueur (integer), id_Planet (integer), id_Vaisseau_Type (integer), and quantite (integer)
    Output: JSON object containing the new spaceship ID

    Endpoint: /api/boundary/apiinterface/apivaisseau.php?update_vaisseau
    Method: POST
    Input: JSON object containing id_Vaisseau (integer), quantite (integer), and activite (integer)
    Output: HTTP status code 200 OK on successful spaceship information update
