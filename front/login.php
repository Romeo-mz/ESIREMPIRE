<?php
$adresse = "http://" . $_SERVER['HTTP_HOST']; // Obtient le nom de domaine actuel

if ($_SERVER['SERVER_PORT'] !== '80') {
  $adresse .= ":" . $_SERVER['SERVER_PORT']; // Ajoute le port si différent de 80
}

$universes = file_get_contents($adresse . "/api/boundary/APIinterface/APIadmin.php?universes");
$universes = json_decode($universes, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css"/>
    <title>ESIREMPIRE</title>
</head>
<body>
    <main>
        <div class="left">
            <div class="overlay">
                <h1>ESIREMPIRE - Login</h1>
            </div>
           

        </div>
        <div class="right">
            <h1>LOGIN</h1>
            <form id="loginForm">
                <input type="text" name="username" placeholder="Username" required id="usernameInput">
                
                <input type="password" name="password" placeholder="Password" required id="passwordInput">
                <select name="univers" id="universSelect">
                    <?php foreach($universes as $universe): ?>
                        <option value="<?= $universe['id'] ?>"><?= $universe['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
                
                <br/><br/>

                <!-- <label for="remember">Se souvenir de moi</label> -->
                <!-- <input type="checkbox" name="remember" id="remember"> -->
                <button type="submit">Login</button>
            </form>
            <span class="register">Vous n'avez pas de compte ? <a href="register.php">Register</a></p>
        </div>
    </main>
    <script src="js/authentifier/login.js" type="module"></script>
</body>
</html>

