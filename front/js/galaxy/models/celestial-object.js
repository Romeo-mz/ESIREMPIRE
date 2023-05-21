export class CelestialBody
{

    id;

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

    addSatellite(star)
    {
        this.satellites.push(star);
    }

    removeSatellite(star)
    {
        const index = this.satellites.indexOf(star);
        if (index > -1)
            this.satellites.splice(index, 1);
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

    async initTexture()
    {
        return new Promise((resolve, reject) =>
        {
            this.texture = new Image();
            this.texture.src = `img/${this.name.toLowerCase()}.png`;
            this.texture.onload = async () =>
            {
                for (const satellite of this.satellites)
                    await satellite.initTexture();

                resolve();
            }
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