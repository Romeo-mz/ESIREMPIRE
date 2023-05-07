<?php

$installations = array(
    array(
        "type" => "Laboratoire",
        "level" => 0,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "1"
    ),
    array(
        "type" => "Usine de Nanites",
        "level" => 1,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "10"
    ),
    array(
        "type" => "Chantier spatial",
        "level" => 1,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "100"
    )
);

$ressources = array(
    array(
        "type" => "Mine de métal",
        "level" => 1,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "1"
    ),
    array(
        "type" => "Synthétiseur de deutérium",
        "level" => 1,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "10"
    ),
    array(
        "type" => "Centrale éléctrique solaire",
        "level" => 1,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "100"
    ),
    array(
        "type" => "Centrale éléctrique de fusion",
        "level" => 1,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "1000"
    )
);

$defenses = array(
    array(
        "type" => "Artillerie à laser",
        "level" => 1,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "50"
    ),
    array(
        "type" => "Canon à ions",
        "level" => 1,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "100"
    ),
    array(
        "type" => "Bouclier",
        "level" => 1,
        "metal" => "1000",
        "energie" => "500",
        "temps" => "500"
    )
);

?>

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

        <hr class="infra-hr">

        <div class="div-infrastructures">
            <div class="div-infrastructures-title">
                <h2>Installations</h2>
            </div>
            <div class="div-list-infrastructures">
                <?php foreach($installations as $installation) { ?>
                    <div class="div-infrastructure">
                        <div class="div-infrastructure-image">
                            <?php if($installation["type"] == "Laboratoire") { ?>
                                <img src="img/laboratory.webp" alt="Laboratoire">
                            <?php } else if($installation["type"] == "Usine de Nanites") { ?>
                                <img src="img/usine-nanites.webp" alt="Usine de Nanites">
                            <?php } else if($installation["type"] == "Chantier spatial") { ?>
                                <img src="img/chantier-spatial.webp" alt="Chantier spatial">
                            <?php } ?>
                        </div>
                        <div class="div-infrastructure-information">
                            <div class="div-infrastructure-type">
                                <p><?php echo $installation["type"]; ?></p>
                            </div>
                            <div class="div-infrastructure-level">
                                <p>Niveau actuel: <?php echo $installation["level"]; ?></p>
                            </div>
                            <div class="div-infrastructure-metal">
                                <p>Métal: <?php echo $installation["metal"]; ?></p>
                            </div>
                            <div class="div-infrastructure-energie">
                                <p>Energie: <?php echo $installation["energie"]; ?></p>
                            </div>
                        </div>
                        <div class="div-infrastructure-upgrade">
                            <?php if ($installation['level'] < 1) { ?>
                                <button class="upgrade-button">Construire<?php echo '<br>'.$installation['temps'].'s' ?></button>
                            <?php } else { ?>
                                <button class="upgrade-button">Améliorer<?php echo '<br>'.$installation['temps'].'s' ?></button>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if($installation != end($installations)) echo "<hr class='mid-hr'>"; } ?>
            </div>
        </div>

        <hr class="infra-hr">

        <div class="div-infrastructures">
            <div class="div-infrastructures-title">
                <h2>Ressources</h2>
            </div>
            <div class="div-list-infrastructures">
                <?php foreach($ressources as $ressource) { ?>
                    <div class="div-infrastructure">
                        <div class="div-infrastructure-image">
                            <?php if($ressource["type"] == "Mine de métal") { ?>
                                <img src="img/mine-metal.webp" alt="Mine de métal">
                            <?php } else if($ressource["type"] == "Synthétiseur de deutérium") { ?>
                                <img src="img/synthetiseur-deuterium.webp" alt="Synthétiseur de deutérium">
                            <?php } else if($ressource["type"] == "Centrale éléctrique solaire") { ?>
                                <img src="img/centrale-solaire.webp" alt="Synthétiseur de deutérium">
                            <?php } else if($ressource["type"] == "Centrale éléctrique de fusion") { ?>
                                <img src="img/centrale-fusion.webp" alt="Centrale éléctrique fusion">
                            <?php } ?>
                        </div>
                        <div class="div-infrastructure-information">
                            <div class="div-infrastructure-type">
                                <p><?php echo $ressource["type"]; ?></p>
                            </div>
                            <div class="div-infrastructure-level">
                                <p>Niveau actuel: <?php echo $ressource["level"]; ?></p>
                            </div>
                            <div class="div-infrastructure-metal">
                                <p>Métal: <?php echo $ressource["metal"]; ?></p>
                            </div>
                            <div class="div-infrastructure-energie">
                                <p>Energie: <?php echo $ressource["energie"]; ?></p>
                            </div>
                        </div>
                        <div class="div-infrastructure-upgrade">
                            <?php if ($ressource['level'] < 1) { ?>
                                <button class="upgrade-button">Construire<?php echo '<br>'.$ressource['temps'].'s' ?></button>
                            <?php } else { ?>
                                <button class="upgrade-button">Améliorer<?php echo '<br>'.$ressource['temps'].'s' ?></button>
                            <?php } ?>
                        </div>
                    </div>
                <?php if($ressource != end($ressources)) echo "<hr class='mid-hr'>"; } ?>                
            </div>
        </div>

        <hr class="infra-hr">

        <div class="div-infrastructures">
            <div class="div-infrastructure-title">
                <h2>Défenses</h2>
            </div>
            <div class="div-list-infrastructures">
                <?php foreach($defenses as $defense) { ?>
                    <div class="div-infrastructure">
                        <div class="div-infrastructure-image">
                            <?php if($defense["type"] == "Artillerie à laser") { ?>
                                <img src="img/laser.webp" alt="Laser">
                            <?php } else if($defense["type"] == "Bouclier") { ?>
                                <img src="img/bouclier.webp" alt="Bouclier">
                            <?php } else if($defense["type"] == "Canon à ions") { ?>
                                <img src="img/canon.webp" alt="Canon à ions">
                            <?php } ?>
                        </div>
                        <div class="div-infrastructure-information">
                            <div class="div-infrastructure-type">
                                <p><?php echo $defense["type"]; ?></p>
                            </div>
                            <div class="div-infrastructure-level">
                                <p>Niveau actuel: <?php echo $defense["level"]; ?></p>
                            </div>
                            <div class="div-infrastructure-metal">
                                <p>Métal: <?php echo $defense["metal"]; ?></p>
                            </div>
                            <div class="div-infrastructure-energie">
                                <p>Energie: <?php echo $defense["energie"]; ?></p>
                            </div>
                        </div>
                        <div class="div-infrastructure-upgrade">
                            <?php if ($defense['level'] < 1) { ?>
                                <button class="upgrade-button">Construire<?php echo '<br>'.$defense['temps'].'s' ?></button>
                            <?php } else { ?>
                                <button class="upgrade-button">Améliorer<?php echo '<br>'.$defense['temps'].'s' ?></button>
                            <?php } ?>
                        </div>
                    </div>
                <?php if($defense != end($defenses)) echo "<hr class='mid-hr'>"; } ?>
            </div>
        </div>

    </main>
</body>
</html>