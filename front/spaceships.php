<?php
// Fetch the spaceship data from the server

$id_vaisseau = $_GET['id_vaisseau'];
function fetch_data($value, $endpoint) {
    $data = file_get_contents("../api/boundary/APIinterface/APIvaisseau.php$value=$endpoint");
    return json_decode($data, true);
}

$spaceships = fetch_data('id_vaisseau', $id_vaisseau);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ESIREMPIRE - Spaceships</title>
    <link rel="stylesheet" href="css/spaceships.css">
</head>

<body>
    <main>
        <div class="spaceships">
            <h1>Spaceships</h1>
            <div class="spaceship-flotte">
                <?php foreach ($spaceships as $spaceship): ?>
                <h2>Flotte</h2>
                <div class="spaceship">
                    <div class="spaceship-img">
                        <img src="img/spaceship_01.png" alt="spaceship">
                    </div>
                    <div class="spaceship-infos">
                        <h2><?php echo $spaceship['nom']; ?></h2>
                        <p>Attack: <?php echo $spaceship['points_attaque']; ?></p>
                    </div>
                </div>


            <div class="spaceship-disponible">
                <h2>Disponible</h2>
                <div class="spaceship">
                    <div class="spaceship-img">
                        <img src="img/spaceship.png" alt="spaceship">
                    </div>
                    <div class="spaceship-infos">
                        <h2>Spaceship</h2>
                        <p>HP: 100</p>
                        <p>Shield: 100</p>
                        <p>Attack: 100</p>
                        <p>Speed: 100</p>
                    </div>
            </div>
        </div>
    </main>

</body>