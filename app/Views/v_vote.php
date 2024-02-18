<h1 class="titre"><?= $titre ?></h1>
<?php
$has_vote = false;
if (isset($plateformesvote)) {
    foreach ($plateformesvote as $plateforme) {
        if ($plateforme->nom === $platform) {
            $has_vote = true;
            break;
        }
    }
}

if (!$has_vote) {
    ?>
    <div class="vote">
        <?php
        echo "<h1 id='titre'>Votez pour votre jeu préféré sur " . $platform . "</h1>";
        $jeux = [];
        if (!empty($vote)) {
            foreach ($vote as $jeu) {
                $id_jeu = $jeu->id_jeu;
                if (!isset($jeux[$id_jeu])) {
                    $jeux[$id_jeu] = $jeu;
                } else {
                    $jeux[$id_jeu]->categories_jeu .= ', ' . $jeu->categories_jeu;
                }
            }
            echo '<div class="carrousel">';
            foreach ($jeux as $jeu) {
                echo "<img class='vote-img' onclick='cartevote(\"$jeu->nom_jeu\")' src='$jeu->image_jeu' 
            alt='$jeu->nom_jeu' data-nom='$jeu->nom_jeu' data-description='$jeu->description_jeu' 
            data-image='$jeu->image_jeu' data-pegi='$jeu->pegi_jeu' data-categories='$jeu->categories_jeu' 
            data-plateforme='$jeu->plateforme_jeu' data-id='$jeu->id_jeu'>";
            }
        }
        echo '</div>';
        ?>
        <div class="vote-tournois">
            <img src="" alt="image-jeu">
            <h1>Nom du jeu</h1>
            <p>Description du jeu</p>
            <h2>PEGI</h2>
            <h3>Catégories</h3>
            <?php
            $session = \Config\Services::session();
            if (session()->get('login')) {
                echo form_open(base_url() . "public/vote");

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
    <div class="tournoi">
        <h2>Smash Bros Ultimate <span class="pourcentage">35%</span></h2>
        <div class="progress-bar">
            <div class="progression" style="width: 35%"></div>
        </div>
    </div>
    <div class="tournoi">
        <h2>Elden Ring <span class="pourcentage">15%</span></h2>
        <div class="progress-bar">
            <div class="progression" style="width: 15%"></div>
        </div>
    </div>
    <div class="tournoi">
        <h2>Metroid Prime 4 <span class="pourcentage">13%</span></h2>
        <div class="progress-bar">
            <div class="progression" style="width: 13%"></div>
        </div>
    </div>
    <div class="tournoi">
        <h2>Pokemon Scarlet <span class="pourcentage">17%</span></h2>
        <div class="progress-bar">
            <div class="progression" style="width: 17%"></div>
        </div>
    </div>
    <div class="tournoi">
        <h2>Rocket League <span class="pourcentage">20%</span></h2>
        <div class="progress-bar">
            <div class="progression" style="width: 20%"></div>
        </div>
    </div>
</div>
<div class="plateformes-div">
    <h3>Plateformes</h3>
    <?php
    $options = array();
    $plateformeSelectionnee = "";

    foreach ($plateformes as $plateforme) {
        $options[$plateforme->id] = $plateforme->nom;
        if ($plateforme->nom === $platform) {
            $plateformeSelectionnee = $plateforme->id;
        }
    }


    echo form_dropdown('plateforme', $options, $plateformeSelectionnee, 'id="plateforme"');
    ?>
</div>

<script>
    function cartevote(nomJeu) {
        var voteImg = document.querySelector('.vote-img[data-nom="' + nomJeu + '"]');
        var voteTournoisDiv = document.querySelector('.vote-tournois');

        var description = voteImg.getAttribute('data-description');
        var image = voteImg.getAttribute('data-image');
        var pegi = voteImg.getAttribute('data-pegi');
        var categories = voteImg.getAttribute('data-categories');
        var idjeu = voteImg.getAttribute('data-id');

        voteTournoisDiv.querySelector('img').src = image;
        voteTournoisDiv.querySelector('img').alt = "Image du jeu " + nomJeu;
        voteTournoisDiv.querySelector('h1').innerText = nomJeu;
        <?php
        if (session()->get('login')) {
        ?>
        voteTournoisDiv.querySelector('#jeu-input').value = idjeu;
        <?php
        }
        ?>
        voteTournoisDiv.querySelector('p').innerText = description;
        voteTournoisDiv.querySelector('h2').innerText = "PEGI: " + pegi;
        voteTournoisDiv.querySelector('h3').innerText = "Catégories: " + categories;

        voteTournoisDiv.style.display = "block";
    }

    function closewindow() {
        var voteTournoisDiv = document.querySelector('.vote-tournois');
        voteTournoisDiv.style.display = "none";
    }

    document.getElementById('plateforme').addEventListener('change', function () {
        var selectedValue = this.value;
        var selectedText = this.options[this.selectedIndex].text;

        var redirectUrl = '<?php echo base_url("public/vote"); ?>/' + selectedText;
        window.location.href = redirectUrl;

    });
</script>
