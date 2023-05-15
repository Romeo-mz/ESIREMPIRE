export class InfraTechnoRequired
{
    #infra;
    #technoRequired;
    #technoRequiredLevel;

    constructor(infra, technoRequired, technoRequiredLevel)
    {
        this.#infra = infra;
        this.#technoRequired = technoRequired;
        this.#technoRequiredLevel = technoRequiredLevel;
    }

    get infra() { return this.#infra; }
    get technoRequired() { return this.#technoRequired; }
    get technoRequiredLevel() { return this.#technoRequiredLevel; }

    set infra(infra) { this.#infra = infra; }
    set technoRequired(technoRequired) { this.#technoRequired = technoRequired; }
    set technoRequiredLevel(technoRequiredLevel) { this.#technoRequiredLevel = technoRequiredLevel; }

}