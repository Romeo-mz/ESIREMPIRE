import { Observer } from "../pattern/observer.js";
import { Vaisseau } from "../models/vaisseau.js";
export class View extends Observer 
{
    #controller;

    constructor(controller) 
    {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);
    }   

    

}