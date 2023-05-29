<?php
$universes = file_get_contents("http://esirloc/api/boundary/APIinterface/APIadmin.php?universes");
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
            <form action="../api/boundary/APIinterface/APIlogin.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                
                <input type="password" name="password" placeholder="Password" required>
                <select name="univers" id="univers-select">
                    <?php foreach($universes as $universe): ?>
                        <option value="<?= $universe['id'] ?>"><?= $universe['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
                
                <br/><br/>

                <label for="remember">Se souvenir de moi</label>
                <input type="checkbox" name="remember" id="remember">
                <input type="submit" value="Login">
            </form>
            <span class="register">Vous n'avez pas de compte <a href="register.php">Register</a></p>
        </div>
    </main>
</body>
</html>

