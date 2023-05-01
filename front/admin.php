<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <title>ESIREMPIRE - Admin</title>
</head>
<body>
    <main>
        <div class="left">
            <div class="overlay">
                <h1>ESIREMPIRE</h1>
            </div>
        </div>
        <div class="right">
            <h1>ADMIN PANEL</h1>
            <form action="../api/boundary/APIinterface/APIadmin.php" method="POST">

                <!-- Create Univers -->
                <label for="universe_name">Créer un Univers <i>(vide: Univers X)</i>:</label><br>
                <input type="text" name="universe_name" placeholder="Nom Univers" id="universe_name">
                
                <br><br><label for="univers-select">Univers Actuel</label><br>
                <select id="univers-select">
                    <option value="" default>--Univers Actuel--</option>
                    <option value="1">Univers 1</option>
                </select>

                <input type="submit" value="Créer">
            </form>
        </div>
    </main>
</body>
</html>