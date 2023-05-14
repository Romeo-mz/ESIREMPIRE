<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EsirEmpire - Infrastructures</title>
    <link rel="stylesheet" href="css/infrastructure.css">
</head>
<body>
    <main>
        <div class="div-title">
            <h1>Infrastructures</h1>
        </div>

        <div class="div-ressources">
            <div class="div-ressource">
                <img class="img-ressource" src="img/metal.png" alt="metal">
                <p class="number-ressource" id="metal">200000</p>
            </div>
            <div class="div-ressource">
                <img class="img-ressource" src="img/energie.png" alt="energie">
                <p class="number-ressource" id="energie">100000</p>
            </div>
            <div class="div-ressource">
                <img class="img-ressource" src="img/deuterium.png" alt="deuterium">
                <p class="number-ressource" id="deuterium">100000</p>
            </div>
        </div>

        <hr class="infra-hr">

        <div class="div-infrastructures">
            <div class="div-infrastructures-title">
                <h2>Installations</h2>
            </div>
            <div class="div-list-infrastructures" id="div-list-installations">
                
            </div>
        </div>

        <hr class="infra-hr">

        <div class="div-infrastructures">
            <div class="div-infrastructures-title">
                <h2>Ressources</h2>
            </div>
            <div class="div-list-infrastructures" id="div-list-ressources">
                
            </div>
        </div>

        <hr class="infra-hr">

        <div class="div-infrastructures">
            <div class="div-infrastructures-title">
                <h2>Défenses</h2>
            </div>
            <div class="div-list-infrastructures" id="div-list-defenses">
                
            </div>
        </div>

    </main>

    <script src="js/infrastructures/application/application.js" type="module"></script>
</body>
</html>