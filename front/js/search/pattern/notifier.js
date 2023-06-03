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

    notify(oldId, newId) 
    {
        this.#observers.forEach(observer => observer.notify(oldId, newId));
    }

    notifyResources()
    {
        this.#observers.forEach(observer => observer.notifyResources());
    }
}