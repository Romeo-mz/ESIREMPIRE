import { Observer } from "../pattern/observer.js";

export class View extends Observer 
{
    #controller;

    constructor(controller)
    {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);

        // document.getElementById("btn-increment").addEventListener("click", () => this.#controller.incrementCounter());
        // document.getElementById("btn-decrement").addEventListener("click", () => this.#controller.decrementCounter());

    }

    notify()
    {
        // document.getElementById("txt-counter").innerHTML = this.#controller.getCounterValue();
    }
}