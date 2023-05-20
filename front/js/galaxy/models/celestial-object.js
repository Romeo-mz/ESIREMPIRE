export class CelestialBody
{

    // #id;

    constructor(id, name, playerName, radius, distance, color, rotationSpeed, orbitalSpeed, hasShadow)
    {
        this.id = id;
        this.name = name ?? "";
        this.playerName = playerName ?? "";
        this.radius = radius;
        this.distance = distance ?? 0;
        this.color = color ?? "#FFFF00";
        this.hasShadow = hasShadow ?? false;
        this.rotationSpeed = rotationSpeed ?? 0;
        this.orbitalSpeed = orbitalSpeed ?? 0;

        this.texture = null;

        this.rotationAngle = 0;
        this.orbitalAngle = 0;
        this.absoluteOrbitalAngle = 0;

        this.satellites = [];
    }

    // get id() { return this.#id; }
    // set id(id) { this.#id = id; }

    addSatellite(star)
    {
        this.satellites.push(star);
    }

    update(elapsedTime)
    {
        this.rotationAngle += elapsedTime * this.rotationSpeed / 1000.0;
        this.orbitalAngle += elapsedTime * this.orbitalSpeed / 1000.0;

        this.satellites.forEach((satellite) =>
        {
            satellite.update(elapsedTime);

            this.computeSatelliteAbsoluteOrbitalAngle(satellite);
        });
    }

    // initTexture(callback) {
    //     if (this.textureUrl) {
    //         this.texture = new Image();
    //         this.texture.src = this.textureUrl;
            
    //     }
    // }

    async initTexture(callback)
    {
        return new Promise((resolve, reject) =>
        {
            this.texture = new Image();
            this.texture.src = `./img/${this.name.toLowerCase()}.png`;
            this.texture.onload = callback;
        });
    }

    computeSatelliteAbsoluteOrbitalAngle(satellite)
    {
        const x = Math.cos(satellite.orbitalAngle) * satellite.distance;
        const y = Math.sin(satellite.orbitalAngle) * satellite.distance;

        const x2 = this.distance - x;
        const d3 = Math.sqrt(Math.pow(x2, 2) + Math.pow(y, 2));
        const angleTemp = Math.acos(this.distance / d3);

        satellite.absoluteOrbitalAngle = this.absoluteOrbitalAngle - angleTemp;
    }
}