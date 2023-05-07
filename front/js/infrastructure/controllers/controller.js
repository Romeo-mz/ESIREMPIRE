import { Infrastructure } from "../models/infrastructure";

export class Controller extends Notifer
{
    #infrastructures;

    constructor()
    {
        super();
        this.#infrastructures = [];

        this.#infrastructures.push(new Infrastructure(1, 'Mine de métal', 1, 60, 15, 0));
        this.#infrastructures.push(new Infrastructure(2, 'Chantier spatial', 2, 75, 20, 0));
        this.#infrastructures.push(new Infrastructure(3, 'Laboratoire', 3, 90, 25, 0));
        this.#infrastructures.push(new Infrastructure(4, 'Synthétiseur de deutérium', 4, 105, 30, 0));
        this.#infrastructures.push(new Infrastructure(5, 'Bouclier', 5, 120, 35, 0));
    }

    get infrastructures() { return this.#infrastructures; }
    set infrastructures(infrastructures) { this.#infrastructures = infrastructures; }

    addInfrastructure(infrastructure)
    {
        this.#infrastructures.push(infrastructure);
        this.notify();
    }

    getInfrastructures() { return this.#infrastructures; }

    // async loadInfrastructures() 
    // {
    //     const response = await fetch('http://localhost:3000/infrastructures');
    //     const infrastructures = await response.json();
    //     this.infrastructures = infrastructures.map(infrastructure => new Infrastructure(infrastructure.id, infrastructure.name, infrastructure.level, infrastructure.metal, infrastructure.energie, infrastructure.temps));

    //     this.notify();
    // }

    // async loadInfrastructureById(id)

    // {
    //     let infrastructure = await Infrastructure.loadInfrastructureById(id);
    //     this.#infrastructures.push(infrastructure);
    //     this.notify();
    // }

    // async updateInfrastructure(infrastructure) 
    // {
    //     const response = await fetch(`http://localhost:3000/infrastructures/${infrastructure.id}`, {
    //         method: 'PUT',
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify(infrastructure)
    //     });
    //     const updatedInfrastructure = await response.json();
    //     return new Infrastructure(updatedInfrastructure.id, updatedInfrastructure.name, updatedInfrastructure.level, updatedInfrastructure.metal, updatedInfrastructure.energie, updatedInfrastructure.temps);
    // }
        
}