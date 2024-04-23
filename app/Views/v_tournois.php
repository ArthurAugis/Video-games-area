<h1 class="titre"><?= $titre ?></h1>
<div class="corps">
    <?php
    echo "<h1 class='titre'>Inscrivez-vous pour les tournois sur " . $platform . "</h1>";
    // vérifie si il y a des jeux récupérer depuis la base de données
    if (!empty($tournois)) {
        echo '<div class="carrousel">';
        // pour chaque jeu création d'un élément du carrousel (img + data)
        foreach ($tournois as $jeu) {
            echo "<img class='vote-img' onclick='cartevote(\"$jeu->nom\")' src='$jeu->url_image' 
            alt='$jeu->nom' data-plateforme='$platform' data-id='$jeu->id'>";
        }
        echo '</div>';
    }
    ?>
    <!-- Carte par défaut pour afficher les informations du jeu dès que l'on clique sur l'image du jeu -->
    <div class="carte-jeu">
        <img src="" alt="image-jeu" class="image_jeu">
        <h1 class="nom_jeu">Nom du jeu</h1>
        <p class="description_jeu">Description du jeu</p>
        <h2 class="pegi_jeu">PEGI</h2>
        <h3 class="categories">Catégories</h3>
        <?php
        $session = \Config\Services::session();
        // si oui créer le bouton pour voter (+ input invisible)
        echo form_open(base_url() . "tournois", array('class' => 'inscription_form'));

        $data = array(
            'name' => 'jeu-input',
            'id' => 'jeu-input',
            'type' => 'hidden',
        );

        echo form_input($data);

        $data = array(
            'name' => 'plateforme-input',
            'id' => 'plateforme-input',
            'type' => 'hidden',
        );

        echo form_input($data);

        echo form_dropdown('sessions') . "<br><br>";
        // vérifie si l'utilisateur est connecté
        if (session()->get('login')) {
            $data = array(
                'name' => 'submit',
                'id' => 'submit',
                'content' => "S'inscrire",
                'type' => 'submit'
            );

            echo form_button($data);
            echo "</p>";
        }

        echo form_close();
        ?>
        <br><br>
        <!-- Bouton close avec l'évenement on click qui appelle la méthode JS closewindow-->
        <button class="close" onclick="closewindow()">🗙</button>
    </div>
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
        var plateforme = '<?php echo $platform; ?>';

        var data = {
            jeu: nomJeu,
            plateforme: plateforme
        };

        //requête ajax pour récupérer toutes les sessions de tournois
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("")?>/ajax/getSessionsTournoi',
            data: data,
            success: function (response) {
                var categories = [];
                var sessions = [];
                var inscriptions = [];
                var imageJeu = "";
                var nomJeu = "";
                var descriptionJeu = "";
                var pegiJeu = "";

                <?php
                if (!empty($inscriptions)) {
                    foreach ($inscriptions as $inscription) {
                        echo "inscriptions.push($inscription->tournoi);";
                    }
                }
                ?>

                response.data.forEach(function (item) {

                    if (!categories.includes(item.nom_categorie)) {
                        categories.push(item.nom_categorie);
                    }

                    if (!sessions.some(session => session[0] === item.id_session) && new Date(item.date + 'T' + item.heure_debut) > new Date()) {
                        sessions.push([item.id_session, item.date, item.heure_debut, item.nbplaces -
                        item.nb_participants]);
                    }


                    if (imageJeu == "") {
                        imageJeu = item.url_image;
                    }

                    if (nomJeu == "") {
                        nomJeu = item.nom;
                    }

                    if (descriptionJeu == "") {
                        descriptionJeu = item.description;
                    }

                    if (pegiJeu == "") {
                        pegiJeu = item.pegi;
                    }
                });

                <?php
                if (session()->has('age')) {
                ?>
                if (pegiJeu > <?php echo session()->get('age'); ?>) {
                    document.getElementById('submit').style.display = "none";
                } else {
                    document.getElementById('submit').style.display = "inline-block";
                }
                <?php
                }
                ?>

                var categoriesList = categories.join(', ');

                var categoriesText = document.querySelector('.categories');
                if (categoriesText) {
                    categoriesText.textContent = "Catégories: " + categoriesList;
                }

                var imageJeuElement = document.querySelector('.image_jeu');
                if (imageJeuElement) {
                    imageJeuElement.src = imageJeu;
                    imageJeuElement.alt = nomJeu
                }

                var nomJeuText = document.querySelector('.nom_jeu');
                if (nomJeuText) {
                    nomJeuText.textContent = nomJeu;
                }

                var descriptionJeuText = document.querySelector('.description_jeu');
                if (descriptionJeuText) {
                    descriptionJeuText.textContent = descriptionJeu;
                }

                var pegiJeuText = document.querySelector('.pegi_jeu');
                if (pegiJeuText) {
                    pegiJeuText.textContent = "PEGI: " + pegiJeu;
                }

                var selectSessions = document.getElementsByName("sessions")[0];
                selectSessions.innerHTML = '';
                sessions.forEach(function (session) {
                    var sessionID = parseInt(session[0]);

                    if (session[3] !== 0 && !inscriptions.includes(sessionID)) {
                        var option = document.createElement("option");
                        option.text = session[1] + " à " + session[2] + " (" + session[3] + " places restantes)";
                        option.value = session[0];

                        selectSessions.add(option);
                    }
                });

                if (selectSessions.options.length === 0) {
                    document.querySelector('.inscription_form').remove();
                }


            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        var inscriptionTournoisDiv = document.querySelector('.carte-jeu');
        inscriptionTournoisDiv.style.display = "block";
    }

    //#endregion

    //#region méthode pour rendre invisible la carte d'informations d'un jeu
    function closewindow() {
        var inscriptionTournoisDiv = document.querySelector('.carte-jeu');
        inscriptionTournoisDiv.style.display = "none";
    }

    //#endregion

    //#region événement qui détecte le changement de l'option selectionné dans le dropdown plateforme
    document.getElementById('plateforme').addEventListener('change', function () {
        // récupére le texte de l'option selectionnée
        var selectedText = this.options[this.selectedIndex].text;

        // fait une redirection vers la page vote de la plateforme selectionnée
        window.location.href = '<?php echo base_url("tournois"); ?>/' + selectedText;
    });
    //#endregion
</script>
