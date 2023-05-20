export class ShipTechnoRequired
{
    #type;
    #technoRequired;
    #technoRequiredLevel;

    constructor(type, technoRequired, technoRequiredLevel)
    {
        this.#type = type;
        this.#technoRequired = technoRequired;
        this.#technoRequiredLevel = technoRequiredLevel;
    }

    get type() { return this.#type; }
    get technoRequired() { return this.#technoRequired; }
    get technoRequiredLevel() { return this.#technoRequiredLevel; }

    set type(type) { this.#type = type; }
    set technoRequired(technoRequired) { this.#technoRequired = technoRequired; }
    set technoRequiredLevel(technoRequiredLevel) { this.#technoRequiredLevel = technoRequiredLevel; }

}