<h1 class="titre"><?= $titre ?></h1>
<?php
$has_vote = false;
// vérifie si il y a eu des votes venant de l'utilisateur
if (isset($plateformesvote)) {
    // pour chaque vote vérifie si l'utilisateur à déjà voté pour la plateforme
    foreach ($plateformesvote as $plateforme) {
        if ($plateforme->nom === $platform) {
            $has_vote = true;
            break;
        }
    }
}

// vérifie si l'utilisateur n'a pas voté
if (!$has_vote) {
    ?>
    <div class="corps">
        <?php
        echo "<h1 id='titre'>Votez pour votre jeu préféré sur " . $platform . "</h1>";
        $jeux = [];
        // vérifie si il y a des jeux récupérer depuis la base de données
        if (!empty($vote)) {
            // récupére tout les jeux pour les mettre dans une liste et supprimer les doublons
            foreach ($vote as $jeu) {
                $id_jeu = $jeu->id_jeu;
                if (!isset($jeux[$id_jeu])) {
                    $jeux[$id_jeu] = $jeu;
                } else {
                    $jeux[$id_jeu]->categories_jeu .= ', ' . $jeu->categories_jeu;
                }
            }
            echo '<div class="carrousel">';
            // pour chaque jeu création d'un élément du carrousel (img + data)
            foreach ($jeux as $jeu) {
                echo "<img class='vote-img' onclick='cartevote(\"$jeu->nom_jeu\")' src='$jeu->image_jeu' 
            alt='$jeu->nom_jeu' data-nom='$jeu->nom_jeu' data-description='$jeu->description_jeu' 
            data-image='$jeu->image_jeu' data-pegi='$jeu->pegi_jeu' data-categories='$jeu->categories_jeu' 
            data-plateforme='$jeu->plateforme_jeu' data-id='$jeu->id_jeu'>";
            }
            echo '</div>';
        }
        ?>
        <!-- Carte par défaut pour afficher les informations du jeu dès que l'on clique sur l'image du jeu -->
        <div class="carte-jeu">
            <img src="" alt="image-jeu" class="image_jeu">
            <h1>Nom du jeu</h1>
            <p>Description du jeu</p>
            <h2>PEGI</h2>
            <h3>Catégories</h3>
            <?php
            $session = \Config\Services::session();
            // vérifie si l'utilisateur est connecté
            if (session()->get('login')) {
                // si oui créer le bouton pour voter (+ input invisible)
                echo form_open(base_url() . "vote");

                $data = array(
                    'name' => 'jeu-input',
                    'id' => 'jeu-input',
                    'type' => 'hidden',
                );

                echo form_input($data);

                $data = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'content' => 'Voter',
                    'type' => 'submit'
                );

                echo form_button($data);
                echo "</p>";

                echo form_close();
            } ?>
            <br><br>
            <!-- Bouton close avec l'évenement on click qui appelle la méthode JS closewindow-->
            <button class="close" onclick="closewindow()">🗙</button>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="timer">
        <h1>Tu as déjà voté pour cette plateforme</h1>
        <h2>Tu auras les résultats du vote dans: </h2>
        <div class="timer-div">
            <div>
                <h2 class="days">0</h2>
                <h2>Jours</h2>
            </div>
            <div>
                <h2 class="hours">00</h2>
                <h2>Heures</h2>
            </div>
            <div>
                <h2 class="minutes">00</h2>
                <h2>Minutes</h2>
            </div>
            <div>
                <h2 class="seconds">00</h2>
                <h2>Secondes</h2>
            </div>
        </div>
    </div>
    <?php
}
?>
<div class="tournois">
    <h1>Voici les résultats pour le vote des jeux <?= $platform ?></h1>
    <?php
    // vérifie si il y a des jeux
    if (!empty($vote)) {
        // créer un résultat pour chaque jeu
        foreach ($resultats as $resultat) {
            if ($resultat->pourcentage) {
                $pourcentage = $resultat->pourcentage;
            } else {
                $pourcentage = 0;
            }
            echo '<div class="tournoi">';
            echo '<h2>' . $resultat->nom . '<span class="pourcentage">' . $pourcentage . '%</span></h2>';
            echo '<div class="progress-bar">';
            echo '<div class="progression" style="width: ' . $pourcentage . '%"></div>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
</div>
<div class="plateformes-div">
    <h3>Plateformes</h3>
    <?php
    $options = array();
    $plateformeSelectionnee = "";
    // vérifie que plateformes n'est pas vide
    if (!empty($plateformes)) {
        // créer une option de chaque plateforme
        foreach ($plateformes as $plateforme) {
            $options[$plateforme->id] = $plateforme->nom;
            // modifie l'option selectionnée si le nom de l'option = au paramètre plateforme
            if ($plateforme->nom === $platform) {
                $plateformeSelectionnee = $plateforme->id;
            }
        }
    }

    // création du dropdown
    echo form_dropdown('plateforme', $options, $plateformeSelectionnee, 'id="plateforme"');
    ?>
</div>

<script>
    //#region méthode permettant d'afficher la carte d'informations d'un jeu
    function cartevote(nomJeu) {
        // récupére toutes les data de l'image du jeu
        var voteImg = document.querySelector('.vote-img[data-nom="' + nomJeu + '"]');
        var voteTournoisDiv = document.querySelector('.carte-jeu');

        var description = voteImg.getAttribute('data-description');
        var image = voteImg.getAttribute('data-image');
        var pegi = voteImg.getAttribute('data-pegi');
        var categories = voteImg.getAttribute('data-categories');
        var idjeu = voteImg.getAttribute('data-id');

        voteTournoisDiv.querySelector('img').src = image;
        voteTournoisDiv.querySelector('img').alt = "Image du jeu " + nomJeu;
        voteTournoisDiv.querySelector('h1').innerText = nomJeu;
        <?php
        // vérifie si il est connecté pour savoir si il faut afficher le bouton pour voter
        if (session()->get('login')) {
            ?>
        voteTournoisDiv.querySelector('#jeu-input').value = idjeu;
            <?php
        }
        ?>
        voteTournoisDiv.querySelector('p').innerText = description;
        voteTournoisDiv.querySelector('h2').innerText = "PEGI: " + pegi;
        voteTournoisDiv.querySelector('h3').innerText = "Catégories: " + categories;

        // affiche la fenêtre
        voteTournoisDiv.style.display = "block";
    }
    //#endregion

    //#region méthode pour rendre invisible la carte d'informations d'un jeu
    function closewindow() {
        var voteTournoisDiv = document.querySelector('.carte-jeu');
        voteTournoisDiv.style.display = "none";
    }
    //#endregion

    //#region événement qui détecte le changement de l'option selectionné dans le dropdown plateforme
    document.getElementById('plateforme').addEventListener('change', function () {
        // récupére le texte de l'option selectionnée
        var selectedText = this.options[this.selectedIndex].text;

        // fait une redirection vers la page vote de la plateforme selectionnée
        window.location.href = '<?php echo base_url("vote"); ?>/' + selectedText;
    });
    //#endregion

    //#region Test de timer en javascript
    <?php
        // vérifie qu'il y a une date dans la base de données
        if(!empty($datesVote[0]->fin_votes)) {
            // récupére la date de fin de vote dans la base de données
            $jsDatetime = date("Y-m-d H:i:s", strtotime($datesVote[0]->fin_votes));
        }
        else {
            // si il n'y a pas de date alors la date par défaut sera le 1 janvier 1970
            $jsDatetime = date("Y-m-d H:i:s", strtotime('1970-01-01'));
        }

    // affecte cette date à la constante targetDate
    echo "const targetDate = new Date('$jsDatetime');";
    ?>
    let intervalTimer;

    //#region calcul du temps entre aujourd'hui et la fin du vote
    function updateTimer()
    {
        const now = new Date().getTime();
        const difference = targetDate - now;

        if (difference > 0) {
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            // vérifie si il y a un timer et le met à jour
            if(document.querySelector('.timer')){
            document.querySelector('.days').innerText = days;
            document.querySelector('.hours').innerText = ('0' + hours).slice(-2);
            document.querySelector('.minutes').innerText = ('0' + minutes).slice(-2);
            document.querySelector('.seconds').innerText = ('0' + seconds).slice(-2);
            }
        } else {
            // arrête la boucle si le timer est fini
            clearInterval(intervalTimer);

            // vérifier si il y a vote et le rend invisible
            if(document.querySelector('.vote')) {
                document.querySelector('.vote').style.display = 'none';
            }

            // vérifier si il y a timer et le rend invisible
            if(document.querySelector('.timer')){
                document.querySelector('.timer').style.display = 'none';
            }

            // vérifier si il y a tournois et le rend visible
            if(document.querySelector('.tournois')) {
                document.querySelector('.tournois').style.display = 'block';
            }
        }
    }
    //#endregion

    intervalTimer = setInterval(updateTimer, 1000);
    updateTimer();
    //#endregion
</script>
