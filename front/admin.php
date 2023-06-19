<?php

if(isset($_GET['success'])) {
    if($_GET['success'] == 1)
        echo 
            " <div class='alert' style='background-color: #00b91c'>
                <span class='closebtn' onclick='this.parentElement.style.display='none';\">&times;</span>
                <b>Succès lors de la création de l'univers.</b>
            </div>";
    else
        echo 
            " <div class='alert' style='background-color: red'>
                <span class='closebtn' onclick='this.parentElement.style.display='none';\">&times;</span>
                <b>Erreur lors de la création de l'univers.</b>
            </div>";
}

$adresse = "http://" . $_SERVER['HTTP_HOST']; // Obtient le nom de domaine actuel

if ($_SERVER['SERVER_PORT'] !== '80') {
  $adresse .= ":" . $_SERVER['SERVER_PORT']; // Ajoute le port si différent de 80
}

$adresse .= "/api/boundary/APIinterface/APIadmin.php?universes";

$universes = file_get_contents($adresse);
$universes = json_decode($universes, true);

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
                <img class="img-logo" src="img/logo2_transp.png" alt="logo">
            </div>
        </div>
        <div class="right">
            <h1 class="admin-title">ADMIN PANEL</h1>
            <form action="../api/boundary/APIinterface/APIadmin.php" method="POST">

                <label for="universe_name">Créer un Univers <i>(vide: Univers X)</i>:</label><br>
                <input type="text" name="universe_name" placeholder="Nom Univers" id="universe_name">
                
                <br><br><label for="univers-select">Univers Existants</label><br>
                <select id="univers-select">
                    <?php 
                        foreach($universes as $universe) {
                            echo "<option value='" . $universe['id'] . "'>" . $universe['nom'] . "</option>";
                        }
                    ?>
                </select>

                <br><br><input type="submit" value="Créer">
            </form>
        </div>
    </main>

    <script>
        var close = document.getElementsByClassName("closebtn");
        var i;

        for (i = 0; i < close.length; i++) {
            close[i].onclick = function(){

                var div = this.parentElement;
                div.style.opacity = "0";

                setTimeout(function(){ div.style.display = "none"; }, 600);
            }
        }
    </script>

</body>
</html>