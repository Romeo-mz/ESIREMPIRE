export class Infrastructure {

    #id;
    #level
    #type;
    #upgradingState;

    constructor(id, level, type) {
        this.#id = id;
        this.#level = level;
        this.#type = type;
        this.#upgradingState = false;
    }

    get id() { return this.#id; }
    get level() { return this.#level; }

    set id(id) { this.#id = id; }
    set level(level) { this.#level = level; }

    get type() { return this.#type; }
    set type(type) { this.#type = type; }

    get upgradingState() { return this.#upgradingState; }
    set upgradingState(upgradingState) { this.#upgradingState = upgradingState; }

    isUpgrading()
    {
        return this.#upgradingState;
    }

}