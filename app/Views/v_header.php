<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag("/public/fontawesome/css/all.css") ?>
    <?= link_tag("/public/css/index.css") ?>
    <title>Espace de jeux vidéo</title>
</head>
<body>
<div class="navbar">
    <div class="left">
        <ul>
            <li>
                <?=anchor(base_url() . 'public/', "Accueil")?>
            </li>
            <li>
                <?=anchor(base_url() . 'public/vote', "Vote")?>
            </li>
            <li>
                <?=anchor(base_url() . 'public/tournois', "Tournois")?>
            </li>
            <li>
                <?=anchor(base_url() . 'public/prix', "Prix")?>
            </li>
            <li>
                <?=anchor(base_url() . 'public/quiz', "Quiz")?>
            </li>
        </ul>
    </div>
    <div class="right">
        <ul>
            <li>
                <?=anchor(base_url() . 'public/utilisateur', '<i class="fa-solid fa-user"></i>')?>
            </li>
        </ul>

    </div>
</div>
<div class="switch-navbar">
    <ul>
        <li class="show-navbar">
            ☰
        </li>
    </ul>
</div>