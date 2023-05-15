export class TechnoRequired 
{
    #techno;
    #technoRequired;
    #technoRequiredLevel;

    constructor(techno, technoRequired, technoRequiredLevel)
    {
        this.#techno = techno;
        this.#technoRequired = technoRequired;
        this.#technoRequiredLevel = technoRequiredLevel;
    }

    get techno() { return this.#techno; }
    get technoRequired() { return this.#technoRequired; }
    get technoRequiredLevel() { return this.#technoRequiredLevel; }

}