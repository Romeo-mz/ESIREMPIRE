function resize()
{
    canvas.width = canvas.clientWidth;
    canvas.height = canvas.clientHeight;
    drawSolarSystem()
}

function drawCelestialBody(celestialBody)
{
    //Saves the context in its current state [*0]
    context.save();
    context.rotate(celestialBody.orbitalAngle);
    //Translates the coordinate system with the vector (celestialBody.distance ; 0)
    context.translate(celestialBody.distance, 0);

    if(celestialBody.hasShadow)
    {
        //Draws a black disque which will be the shadowed part of the planet
        context.beginPath();
        context.arc(0, 0, celestialBody.radius, 0, 2 * Math.PI);
        context.fillStyle = "#000000";
        context.fill();
        //Saves the current context [*1]
        context.save();
        //Prepares the drawing of the mask
        context.beginPath();
        context.arc(-celestialBody.radius * 2, 0, celestialBody.radius * 2, 0, 2 *
        Math.PI);
        //Create a mask from the previous prepared drawing
        // context.clip();
    }
    //Starts the drawing
    context.beginPath();
    //Prepare the drawing of a complete circle
    context.arc(0, 0, celestialBody.radius, 0, 2 * Math.PI);
    //Creates a pattern from the texture of the celestial body
    const pattern = context.createPattern(celestialBody.texture, "no-repeat");
    const coef = (celestialBody.radius * 2) / celestialBody.texture.width;
    //Saves the current context [*2]
    context.save();
    //Rotates the celestial body on its own axis
    context.rotate(celestialBody.rotationAngle);
    //Moves and scales the coordinate system to apply the pattern
    context.translate(-celestialBody.radius, -celestialBody.radius);
    context.scale(coef, coef);
    //Sets the filling color
    context.fillStyle = pattern; //celestialBody.color;
    //Fills the circle
    context.fill();
    //Restores the context [*2]
    context.restore();

    // Draw the name of the planet at the top of the celestial body
    context.save(); // Save context before applying text styles and transformations
    context.textAlign = 'center'; // Set the text alignment to center
    context.textBaseline = 'middle'; // Set the text baseline to middle
    context.font = '30px Arial'; // Set the font size and family
    if(celestialBody.name !== "Sun") {
        context.fillStyle = '#FFFFFF'; // Set the font color to white
        const textOffset = celestialBody.radius + 20; // Offset from the center of the celestial body
        context.translate(0, -textOffset); // Move the drawing context to the top of the celestial body
    }
    else {
        context.fillStyle = '#000000'; // Set the font color to black
    }

    // Apply inverse rotation to keep the text horizontal
    if(celestialBody.name != "Sun"){
        context.rotate(-celestialBody.rotationAngle);
    }
        

    context.fillText(celestialBody.name, 0, 0); // Draw the name of the celestial body
    context.restore(); // Restore context after drawing text

    if(celestialBody.hasShadow)
    {
        //Restores the context and disable the mask [*1]
        context.restore();
    }
    //Draws each satellite of the celestial body
    celestialBody.satellites.forEach((satellite) => {
        drawOrbit(satellite);
        drawCelestialBody(satellite);
    });
    //Restores the context on its initial state [*0]
    context.restore();

    
}

function drawSolarSystem()
{
    //Saves the context
    context.save();
    //Moves the coordinate system to the center of the canvas
    context.translate(canvas.width / 2, canvas.height / 2);
    //Draws the solar system starting with the sun
    drawCelestialBody(solarSystem.sun);
    //Restores the context to its states at the previous call of save
    context.restore();
}

function drawOrbit(celestialBody)
{
    // Starts the drawing
    context.beginPath();
    // Prepare the drawing of a complete circle
    context.arc(0, 0, celestialBody.distance, 0, 2 * Math.PI);
    // Sets the outline color of the circle
    context.strokeStyle = "#333333";
    // Draws the outline of the circle
    context.stroke();
}

function animate(lastUpdateTime)
{
    // Gets the number of milliseconds elapsed from the beginning of the program
    const now = performance.now();
    // Computes the elpased time from the last update.
    // If lastUpdateTime is equel to 0, it is the first frame, so update is not required.
    const elapsedTime = lastUpdateTime === 0 ? 0 : now - lastUpdateTime;
    // Clears the canvas
    context.clearRect(0, 0, canvas.width, canvas.height);
    // Draws the solar system
    drawSolarSystem();
    // Updates celestial bodies position
    solarSystem.sun.update(elapsedTime);
    // Requests a new frame as soon as possible
    requestAnimationFrame(() => { animate(now) });
}

const canvas = document.querySelector("canvas");

canvas.width = canvas.clientWidth;
canvas.height = canvas.clientHeight;

const context = canvas.getContext("2d");

context.beginPath();


window.addEventListener("resize", () => {
    resize();
});

window.addEventListener("load", async () => {
    await solarSystem.sun.initTexture()
    resize();
    animate(0);


        // Add onClick event listener for each planet
        canvas.addEventListener('click', (event) => {
            // Get the mouse position
            const mousePosition = {
                x: event.clientX,
                y: event.clientY
            };

            // Get the position of the sun
            const sunPosition = {
                x: canvas.width / 2,
                y: canvas.height / 2
            };

            // Get the distance between the sun and the mouse position
            const distance = Math.sqrt(
                Math.pow(mousePosition.x - sunPosition.x, 2) +
                Math.pow(mousePosition.y - sunPosition.y, 2)
            );

            // Check if the mouse is inside the sun
            if (distance < solarSystem.sun.radius) {
                // Display the sun information
                console.log("Developped by Hugo with love <3")
            } else {
                // Check if the mouse is inside a planet
                const planet = solarSystem.sun.satellites.find((satellite) => {
                    return distance < satellite.distance + satellite.radius;
                });

                // If a planet is found, display its information
                if (planet) {
                    // Go to the planet page
                }
            }
        });

        // Add onHover event listener for each planet
        canvas.addEventListener('mousemove', (event) => {
            // Get the mouse position
            const mousePosition = {
                x: event.clientX,
                y: event.clientY
            };

            // Get the position of the sun
            const sunPosition = {
                x: canvas.width / 2,
                y: canvas.height / 2
            };

            // Get the distance between the sun and the mouse position
            const distance = Math.sqrt(
                Math.pow(mousePosition.x - sunPosition.x, 2) +
                Math.pow(mousePosition.y - sunPosition.y, 2)
            );

            // Check if the mouse is inside the sun
            if (distance < solarSystem.sun.radius) {
                // Display the sun information
                document.getElementById("planetName").innerHTML = "Sun";
                document.getElementById("playerName").innerHTML = "";
            } else {
                // Check if the mouse is inside a planet
                const planet = solarSystem.sun.satellites.find((satellite) => {
                    return distance < satellite.distance + satellite.radius;
                });

                // If a planet is found, display its information
                if (planet) {
                    document.getElementById("planetName").innerHTML = "Planet Name: " + planet.name;
                    document.getElementById("playerName").innerHTML = "Player Name: " + (planet.playerName == "" ? "No player" : planet.playerName);

                }

            }
        });  

});