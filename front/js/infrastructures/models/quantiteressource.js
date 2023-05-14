export class QuantiteRessource {

    #id_Metal;
    #metal;
    #id_Energie;
    #energie;
    #id_Deuterium;
    #deuterium;

    constructor(id_Metal, metal, id_Energie, energie, id_Deuterium, deuterium) {
        this.#id_Metal = id_Metal;
        this.#metal = metal;
        this.#id_Energie = id_Energie;
        this.#energie = energie;
        this.#id_Deuterium = id_Deuterium;
        this.#deuterium = deuterium;
    }

    get id_Metal() { return this.#id_Metal; }
    set id_Metal(id_Metal) { this.#id_Metal = id_Metal; }
    get metal() { return this.#metal; }
    set metal(metal) { this.#metal = metal; }

    get id_Energie() { return this.#id_Energie; }
    set id_Energie(id_Energie) { this.#id_Energie = id_Energie; }
    get energie() { return this.#energie; }
    set energie(energie) { this.#energie = energie; }

    get id_Deuterium() { return this.#id_Deuterium; }
    set id_Deuterium(id_Deuterium) { this.#id_Deuterium = id_Deuterium; }
    get deuterium() { return this.#deuterium; }
    set deuterium(deuterium) { this.#deuterium = deuterium; }

}