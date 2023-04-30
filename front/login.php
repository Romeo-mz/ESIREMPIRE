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
        <div class="left login">
            <h1>ESIREMPIRE</h1>

        </div>
        <div class="right">
            <h1>LOGIN</h1>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="univers" id="univers-select">
                    <option value="">--Choisissez un univers--</option>
                    <option value="1">Univers 1</option>
                </select>
                <label for="remember">Remember me</label>
                <input type="checkbox" name="remember" id="remember">
                <input type="submit" value="Login">
            </form>
            <span class="register">Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </main>
</body>
</html>