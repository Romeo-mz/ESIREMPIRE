class CelestialBody
{
    constructor(name, playerName, radius, distance, color, rotationSpeed, orbitalSpeed, hasShadow)
    {
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

const sun = new CelestialBody("Sun", "", 40, 0, "#fff68f", 0.1, 0);
const P1 = new CelestialBody("P1", "Hugo", 15, 70, "#4f4160", 0.5, 0.5, true);
const P2 = new CelestialBody("P2", "", 20, 130, "#d3a147", 0.2, 0.2, true);
const P3 = new CelestialBody("P3", "", 30, 180, "#355ca3", 0.35, 0.35, true);
const P4 = new CelestialBody("P4", "Max", 18, 240, "#a33a35", 0.05, 0.05, true);
const P5 = new CelestialBody("P5", "", 20, 290, "#a33a35", 0.45, 0.45, true);
const P6 = new CelestialBody("P6", "", 22, 350, "#a33a35", 0.2, 0.2, true);
const P7 = new CelestialBody("P7", "Enry", 15, 400, "#a33a35", 0.15, 0.15, true);
const P8 = new CelestialBody("P8", "", 12, 440, "#a33a35", 0.4, 0.4, true);
const P9 = new CelestialBody("P9", "", 20, 490, "#a33a35", 0.08, 0.08, true);
const P10 = new CelestialBody("P10", "", 25, 550, "#a33a35", 0.1, 0.1, true);

sun.addSatellite(P1);
sun.addSatellite(P2);
sun.addSatellite(P3);
sun.addSatellite(P4);
sun.addSatellite(P5);
sun.addSatellite(P6);
sun.addSatellite(P7);
sun.addSatellite(P8);
sun.addSatellite(P9);
sun.addSatellite(P10);

const solarSystem = { sun };