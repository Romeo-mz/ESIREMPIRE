<?php

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

$galaxies = file_get_contents("http://localhost:5550/ESIREMPIRE/api/boundary/APIinterface/APIgalaxy.php?id_Univers=" . $_POST['id_Univers']);
$galaxies = json_decode($galaxies, true);

$sys_sols = file_get_contents("http://localhost:5550/ESIREMPIRE/api/boundary/APIinterface/APIgalaxy.php?id_Galaxy=" . $_POST['id_Galaxy']);
$sys_sols = json_decode($sys_sols, true);

$planets = file_get_contents("http://localhost:5550/ESIREMPIRE/api/boundary/APIinterface/APIgalaxy.php?id_SolarSystem=" . $_POST['id_SolarSystem']);
$planets = json_decode($planets, true);

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
                <form action="galaxy.php" method="POST">
                    <label for="id_Galaxy">Choisissez une galaxie: </label>
                    <select name="id_Galaxy" id="id_Galaxy">
                        <?php foreach ($galaxies as $galaxy) { ?>
                            <option <?php if ($galaxy['id'] == $_POST['id_Galaxy']) echo ' selected';?> value="<?php echo $galaxy['id']; ?>"><?php echo $galaxy['nom']; ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" value="Go">
                </form>
        </div>
        <div class="div-sys-sol">
            <h2 class="sys-sol-title">Systeme Solaire</h2>
            <div class="div-choose-sys-sol">
                <form action="galaxy.php" method="POST">
                    <label for="id_SolarSystem">Choisissez un systeme solaire: </label>
                    <select name="id_SolarSystem" id="id_SolarSystem">
                        <?php foreach ($sys_sols as $sys_sol) { ?>
                            <option <?php if ($sys_sol['id'] == $_POST['id_SolarSystem']) echo ' selected';?> value="<?php echo $sys_sol['id']; ?>"><?php echo $sys_sol['nom']; ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" value="Go">
                </form>
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

</body>
</html>