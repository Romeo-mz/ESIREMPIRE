export class Bonus 
{
    #energie;
    #deuterium;
    #metal;

    constructor(energie, deuterium, metal)
    {
        this.#energie = energie;
        this.#deuterium = deuterium;
        this.#metal = metal;
    }

    get energie() { return this.#energie; }
    set energie(energie) { this.#energie = energie; }

    get deuterium() { return this.#deuterium; }
    set deuterium(deuterium) { this.#deuterium = deuterium; }

    get metal() { return this.#metal; }
    set metal(metal) { this.#metal = metal; }

}