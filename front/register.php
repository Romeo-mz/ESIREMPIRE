<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css"/>
    <title>ESIREMPIRE - register</title>
</head>
<body>
    <main>
        <div class="left">
            <div class="overlay">
                <h1>ESIREMPIRE</h1>
            </div>
           

        </div>
        <div class="right">
            <h1>REGISTER</h1>
            <form action="../api/boundary/APIinterface/APIregister.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="text" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <br/><br/>

                <input type="submit" value="Register">
            </form>
            <span class="register">Vous avez déjà un compte <a href="login.php">Login</a></p>
        </div>
    </main>
</body>
</html>