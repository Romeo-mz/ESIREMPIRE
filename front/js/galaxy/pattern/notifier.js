export class Notifier
{
    #observers = [];

    constructor()
    {
        this.#observers = [];
    }

    addObserver(observer)
    {
        this.#observers.push(observer);
    }

    notify(galaxyId, systemId) 
    {
        this.#observers.forEach(observer => observer.notify(galaxyId, systemId));
    }
}