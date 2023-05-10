<?php
session_start();

$_SESSION['id_Univers'] = 1;
$_POST['id_Univers'] = $_SESSION['id_Univers'];

// Default galaxy
if (!isset($_POST['id_Galaxy'])) {
    $_POST['id_Galaxy'] = 1;
}

// Default solar system
if (!isset($_POST['id_SolarSystem'])) {
    $_POST['id_SolarSystem'] = 1;
}

function fetch_data($id_param, $value) {
    $data = file_get_contents("http://esirempire/esirempire/api/boundary/APIinterface/APIgalaxy.php?$id_param=$value");
    return json_decode($data, true);
}

$galaxies = fetch_data('id_Univers', $_POST['id_Univers']);
$sys_sols = fetch_data('id_Galaxy', $_POST['id_Galaxy']);
$planets = fetch_data('id_SolarSystem', $_POST['id_SolarSystem']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/galaxy.css">
    <title>EsirEmpire - Galaxy</title>
</head>
<body>
    <main>
        <div class="div-galaxy">
            <h2 class="galaxy-title">Galaxie</h2>
            <div class="div-choose-galaxy">
                <form action="#">
                    <label for="id_Galaxy">Choisissez une galaxie: </label>
                    <select name="id_Galaxy" id="id_Galaxy">
                        <?php foreach ($galaxies as $galaxy) { ?>
                            <option <?php if ($galaxy['id'] == $_POST['id_Galaxy']) echo ' selected';?> value="<?php echo $galaxy['id']; ?>"><?php echo $galaxy['nom']; ?></option>
                        <?php } ?>
                    </select>
                </form>
        </div>
        <div class="div-sys-sol">
            <h2 class="sys-sol-title">Systeme Solaire</h2>
            <div class="div-choose-sys-sol">
                <form action="#">
                    <label for="id_SolarSystem">Choisissez un systeme solaire: </label>
                    <select name="id_SolarSystem" id="id_SolarSystem">
                        <?php foreach ($sys_sols as $sys_sol) { ?>
                            <option <?php if ($sys_sol['id'] == $_POST['id_SolarSystem']) echo ' selected';?> value="<?php echo $sys_sol['id']; ?>"><?php echo $sys_sol['nom']; ?></option>
                        <?php } ?>
                    </select>
                </form>
            </div>
        </div>
        
        <div class="div-planet">
            <h2 class="planet-title">Planète</h2>
            <div class="div-choose-planet">
                <table class="planet-tab">
                    <tr>
                        <th>Position</th>
                        <th>Planète</th>
                        <th>Joueur</th>
                    </tr>
                    <?php for ($i = 1; $i <= 10; $i++) { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <?php foreach ($planets as $planet) { ?>
                                <?php if ($planet['position'] == $i) { ?>
                                    <td><?php echo $planet['nom']; ?></td>
                                    <td><?php echo $planet['pseudo']; ?></td>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                    
                </table>
        </div>
        
    </main>

    <script>
        document.getElementById('id_Galaxy').addEventListener('change', updateSolarSystems);
        document.getElementById('id_SolarSystem').addEventListener('change', updatePlanets);

        async function updateSolarSystems() {
            let galaxyId = document.getElementById('id_Galaxy').value;
            let response = await fetch(`http://localhost:5550/ESIREMPIRE/api/boundary/APIinterface/APIgalaxy.php?id_Galaxy=${galaxyId}`);
            let solarSystems = await response.json();
            let solarSystemSelect = document.getElementById('id_SolarSystem');

            // Clear previous options
            solarSystemSelect.innerHTML = '';

            // Populate new options
            solarSystems.forEach(solarSystem => {
                let option = document.createElement('option');
                option.value = solarSystem.id;
                option.text = solarSystem.nom;
                solarSystemSelect.add(option);
            });

            // Update planets as well
            updatePlanets();
        }

        async function updatePlanets() {
            let solarSystemId = document.getElementById('id_SolarSystem').value;
            let response = await fetch(`http://localhost:5550/ESIREMPIRE/api/boundary/APIinterface/APIgalaxy.php?id_SolarSystem=${solarSystemId}`);
            let planets = await response.json();
            let planetTable = document.querySelector('.planet-tab');

            // Clear previous table rows
            while (planetTable.rows.length > 1) {
                planetTable.deleteRow(-1);
            }

            // Populate new table rows
            for (let i = 1; i <= 10; i++) {
                let row = planetTable.insertRow(-1);
                let positionCell = row.insertCell(0);
                let planetCell = row.insertCell(1);
                let playerCell = row.insertCell(2);

                positionCell.textContent = i;

                planets.forEach(planet => {
                    if (planet.position == i) {
                        planetCell.textContent = planet.nom;
                        playerCell.textContent = planet.pseudo;
                    }
                });
            }
        }
    </script>
</body>
</html>