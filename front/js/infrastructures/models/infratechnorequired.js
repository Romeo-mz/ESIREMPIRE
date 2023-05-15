export class InfraTechnoRequired
{
    #infra_type;
    #technoRequired;
    #technoRequiredLevel;

    constructor(infra_type, technoRequired, technoRequiredLevel)
    {
        this.#infra_type = infra_type;
        this.#technoRequired = technoRequired;
        this.#technoRequiredLevel = technoRequiredLevel;
    }

    get infra_type() { return this.#infra_type; }
    get technoRequired() { return this.#technoRequired; }
    get technoRequiredLevel() { return this.#technoRequiredLevel; }

    set infra_type(infra_type) { this.#infra_type = infra_type; }
    set technoRequired(technoRequired) { this.#technoRequired = technoRequired; }
    set technoRequiredLevel(technoRequiredLevel) { this.#technoRequiredLevel = technoRequiredLevel; }

}