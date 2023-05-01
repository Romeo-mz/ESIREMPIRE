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

$universes = file_get_contents("http://localhost:5550/ESIREMPIRE/api/boundary/APIinterface/APIadmin.php?universes");
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
                <h1>ESIREMPIRE</h1>
            </div>
        </div>
        <div class="right">
            <h1>ADMIN PANEL</h1>
            <form action="../api/boundary/APIinterface/APIadmin.php" method="POST">

                <!-- Create Univers -->
                <label for="universe_name">Créer un Univers <i>(vide: Univers X)</i>:</label><br>
                <input type="text" name="universe_name" placeholder="Nom Univers" id="universe_name">
                
                <br><br><label for="univers-select">Univers Existants</label><br>
                <select id="univers-select">
                    <option value="" default>--Univers Existants--</option>
                    <?php 
                        foreach($universes as $universe) {
                            echo "<option value='" . $universe['id'] . "'>" . $universe['nom'] . "</option>";
                        }
                    ?>
                </select>

                <input type="submit" value="Créer">
            </form>
        </div>
    </main>

    <script>
        // Get all elements with class="closebtn"
        var close = document.getElementsByClassName("closebtn");
        var i;

        // Loop through all close buttons
        for (i = 0; i < close.length; i++) {
        // When someone clicks on a close button
        close[i].onclick = function(){

            // Get the parent of <span class="closebtn"> (<div class="alert">)
            var div = this.parentElement;

            // Set the opacity of div to 0 (transparent)
            div.style.opacity = "0";

            // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
            setTimeout(function(){ div.style.display = "none"; }, 600);
        }
        }
    </script>

</body>
</html>