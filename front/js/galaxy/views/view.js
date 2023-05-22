import { Observer } from "../pattern/observer.js";

export class View extends Observer 
{
    #controller;
    canvas;
    context;
    #solarSystem;

    constructor(controller) 
    {
        super();
        this.#controller = controller;
        this.#controller.addObserver(this);

        // Copy the solar system from the controller
        this.#solarSystem = this.#controller.solarSystem;

        this.canvas = document.getElementById("canvas");
        if (!this.canvas) 
        {
            throw new Error("Could not find canvas element");
        }

        this.context = this.canvas.getContext("2d");
        if (!this.context) 
        {
            throw new Error("Could not get 2D context for canvas");
        }

        this.canvas.addEventListener("click", (event) => {
            const mousePosition = {
                x: event.clientX,
                y: event.clientY,
            };
        
            const sunPosition = {
                x: this.canvas.width / 2,
                y: this.canvas.height / 2,
            };
        
            const distance = Math.sqrt(
                Math.pow(mousePosition.x - sunPosition.x, 2) +
                Math.pow(mousePosition.y - sunPosition.y, 2)
            );

            if (distance < this.#solarSystem.sun.radius) 
            {
                console.log("Developped by Hugo with love <3");
            } 
            else 
            {
                const planet = this.#solarSystem.sun.satellites.find((satellite) => {
                    return distance < satellite.distance + satellite.radius;
                });

                if (planet) 
                {
                    if(planet.id === this.#controller.session.id_Planet.toString())
                        // Go to infrastructure page
                        window.location.href = "./infrastructures.html";
                }
            }
        });

        this.canvas.addEventListener("mousemove", (event) => {
          const mousePosition = {
            x: event.clientX,
            y: event.clientY,
          };
          const sunPosition = {
            x: this.canvas.width / 2,
            y: this.canvas.height / 2,
          };
          const distance = Math.sqrt(
            Math.pow(mousePosition.x - sunPosition.x, 2) +
            Math.pow(mousePosition.y - sunPosition.y, 2)
          );
          if (distance < this.#solarSystem.sun.radius) {
            document.getElementById("planetName").innerHTML = "Sun";
            document.getElementById("playerName").innerHTML = "";
          } else {
            const planet = this.#solarSystem.sun.satellites.find(
              (satellite) => {
                return distance < satellite.distance + satellite.radius;
              }
            );
            if (planet) {
              document.getElementById("planetName").innerHTML =
                "Planet Name: " + planet.name;
              document.getElementById("playerName").innerHTML =
                "Player Name: " +
                (planet.playerName == "" ? "No player" : planet.playerName);
            }
          }
        });

        window.addEventListener("resize", () => {
          this.resize();
          this.animate(0);
        });

        this.canvas.width = this.canvas.clientWidth;
        this.canvas.height = this.canvas.clientHeight;

        this.context.beginPath();

        // Init textures
        this.#solarSystem.sun.initTexture()
        this.#solarSystem.sun.satellites.forEach((satellite) => {
            satellite.initTexture();
        });

        this.resize();
        this.animate(0);

        this.createGalaxiesList();
        this.createSolarSystemList();
    }

    get solarSystem()
    {
        return this.#solarSystem;
    }

    set solarSystem(solarSystem)
    {
        this.#solarSystem = solarSystem;
    }

    createGalaxiesList()
    {
        const galaxiesListElement = document.getElementById("galaxy");
        const galaxiesList = this.#controller.galaxiesList;       

        galaxiesList.forEach((galaxy) => {
            const galaxyElement = document.createElement("option");
            galaxyElement.value = galaxy.id;
            galaxyElement.innerHTML = galaxy.nom;
            galaxiesListElement.appendChild(galaxyElement);

            galaxyElement.addEventListener("click", () => {
                const solarSystemId = document.getElementById("solarsystem"); 

                console.log("galaxy id: " + galaxyElement.value);
                console.log("sys id: " + solarSystemId.value);

                this.#controller.loadNewPlanets(galaxyElement.value, solarSystemId.value);
            }

            );
        });
    }


    createSolarSystemList()
    {
        const solarSystemListElement = document.getElementById("solarsystem");
        const solarSystemList = this.#controller.solarSystemList;

        solarSystemList.forEach((solarSystem) => {
            const solarSystemElement = document.createElement("option");
            solarSystemElement.value = solarSystem.id;
            solarSystemElement.innerHTML = solarSystem.nom;
            solarSystemListElement.appendChild(solarSystemElement);

            solarSystemElement.addEventListener("click", () => {
                const galaxyElement = document.getElementById("galaxy");

                console.log("galaxy id: " + galaxyElement.value);
                console.log("sys id: " + solarSystemElement.value);

                this.#controller.loadNewPlanets(galaxyElement.value, solarSystemElement.value);
            }

            );
        });
    }


  resize() {
    const width = this.canvas.clientWidth;
    const height = this.canvas.clientHeight;
    if (this.canvas.width !== width || this.canvas.height !== height) {
      this.canvas.width = width;
      this.canvas.height = height;
      this.drawSolarSystem();
    }
  }

  drawCelestialBody(celestialBody) {
    this.context.save();
    this.context.rotate(celestialBody.orbitalAngle);
    this.context.translate(celestialBody.distance, 0);

    if (celestialBody.hasShadow) {
      this.context.beginPath();
      this.context.arc(0, 0, celestialBody.radius, 0, 2 * Math.PI);
      this.context.fillStyle = "#000000";
      this.context.fill();
      this.context.save();
      this.context.beginPath();
      this.context.arc(-celestialBody.radius * 2, 0, celestialBody.radius * 2, 0, 2 * Math.PI);
      this.context.clip();
    }

    this.context.beginPath();
    this.context.arc(0, 0, celestialBody.radius, 0, 2 * Math.PI);
    const pattern = this.context.createPattern(celestialBody.texture, "no-repeat");
    const coef = (celestialBody.radius * 2) / celestialBody.texture.width;
    this.context.save();
    this.context.rotate(celestialBody.rotationAngle);
    this.context.translate(-celestialBody.radius, -celestialBody.radius);
    this.context.scale(coef, coef);
    this.context.fillStyle = pattern;
    this.context.fill();
    this.context.restore();    

    if (celestialBody.hasShadow) {
      this.context.restore();
      this.context.save();

      this.context.beginPath();
      this.context.arc(0, 0, celestialBody.radius, 0, 2 * Math.PI);
      this.context.clip();

      const gradient = this.context.createRadialGradient(-celestialBody.radius * 2, 0, 0, -celestialBody.radius * 2, 0, celestialBody.radius * 2);
      gradient.addColorStop(0, "rgba(0, 0, 0, 0)");
      gradient.addColorStop(0.8, "rgba(0, 0, 0, 0)");
      gradient.addColorStop(1, "rgba(0, 0, 0, 1)");

      this.context.fillStyle = gradient;
      this.context.fill();
    
        // Restore the context and remove the clipping mask
        this.context.restore();

    }

    this.context.save();
    this.context.textAlign = "center";
    this.context.textBaseline = "middle";
    this.context.font = "30px Arial";

    if (celestialBody.name !== "Sun") {
      this.context.fillStyle = "#FFFFFF";
      const textOffset = celestialBody.radius + 20;
      this.context.translate(0, -textOffset);
    } else {
      this.context.fillStyle = "#000000";
    }

    if (celestialBody.name !== "Sun") {
      this.context.rotate(-celestialBody.rotationAngle);
    }
    this.context.fillText(celestialBody.name, 0, 0);

    if(celestialBody.id === this.#controller.session.id_Planet.toString())
        this.context.fillText("Your Planet", 0, 0);
    else
        this.context.fillText(celestialBody.name, 0, 0);

    this.context.restore();

    celestialBody.satellites.forEach((satellite) => {
      this.drawOrbit(satellite);
      this.drawCelestialBody(satellite);
    });

    this.context.restore();
  }

  drawSolarSystem() {
    //Saves the context
    this.context.save();
    //Moves the coordinate system to the center of the canvas
    this.context.translate(this.canvas.width / 2, this.canvas.height / 2);
    //Draws the solar system starting with the sun
    this.drawCelestialBody(this.#solarSystem.sun);
    //Restores the context to its states at the previous call of save
    this.context.restore();
  }

  drawOrbit(celestialBody) {
    // Starts the drawing
    this.context.beginPath();
    // Prepare the drawing of a complete circle
    this.context.arc(0, 0, celestialBody.distance, 0, 2 * Math.PI);
    // Sets the outline color of the circle
    this.context.strokeStyle = "#333333";
    // Draws the outline of the circle
    this.context.stroke();
  }

  animate(lastUpdateTime) {
    // Gets the number of milliseconds elapsed from the beginning of the program
    const now = performance.now();
    // Computes the elpased time from the last update.
    // If lastUpdateTime is equel to 0, it is the first frame, so update is not required.
    const elapsedTime = lastUpdateTime === 0 ? 0 : now - lastUpdateTime;
    // Clears the canvas
    this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    // Draws the solar system
    this.drawSolarSystem();
    // Updates celestial bodies position
    this.#solarSystem.sun.update(elapsedTime);
    // Requests a new frame as soon as possible
    requestAnimationFrame(() => this.animate(now));
  }

    updateSolarSystemList(systemId = null)
    {
        const solarSystemListElement = document.getElementById("solarsystem");
        const solarSystemList = this.#controller.solarSystemList;

        solarSystemListElement.innerHTML = "";

        solarSystemList.forEach((solarSystem) => {
            const solarSystemElement = document.createElement("option");
            solarSystemElement.value = solarSystem.id;

            if (solarSystem.id === systemId)
                solarSystemElement.setAttribute("selected", "selected");

            solarSystemElement.innerHTML = solarSystem.nom;
            solarSystemListElement.appendChild(solarSystemElement);

            solarSystemElement.addEventListener("click", () => {
                const galaxyId = document.getElementById("galaxy");

                this.#controller.loadNewPlanets(galaxyId.value, solarSystemElement.value);
            }
            );
        });
    }

    updateGalaxiesList(galaxyId) 
    {
        const galaxyListElement = document.getElementById("galaxy");
        const galaxyList = this.#controller.galaxiesList;

        galaxyListElement.innerHTML = "";

        galaxyList.forEach((galaxy) => {
            const galaxyElement = document.createElement("option");
            galaxyElement.value = galaxy.id;

            if (galaxy.id === galaxyId) 
                galaxyElement.setAttribute("selected", "selected");

            galaxyElement.innerHTML = galaxy.nom;
            galaxyListElement.appendChild(galaxyElement);

            galaxyElement.addEventListener("click", () => {
                const solarSystemId = document.getElementById("solarsystem");

                this.#controller.loadNewPlanets(galaxyElement.value);
            }
            );
        });

    }
  

    notify(galaxyId, systemId) 
    {
        this.updateSolarSystemList(systemId);
        this.updateGalaxiesList(galaxyId);

        this.#solarSystem.sun.initTexture()
        this.#solarSystem.sun.satellites.forEach((satellite) => {
            satellite.initTexture();
        });

        this.solarSystem = this.#controller.solarSystem;

        console.log(this.#controller.solarSystem);
    }

}