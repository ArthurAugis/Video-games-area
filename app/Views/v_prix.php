<div class="corps">
    <?php
    echo "<h1 id='titre'>Récompenses pour les jeux sur " . $platform . "</h1>";
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
        <div class="prix">

        </div>
        <?php
        echo form_dropdown('selectSessions') . "<br><br>";
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

        // requete ajax pour afficher toutes les sessions du tournoi
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("public")?>/ajax/getSessionsTournoi',
            data: data,
            success: function (response) {
                var sessions = [];
                var imageJeu = "";
                var nomJeu = "";

                response.data.forEach(function (item) {

                    if (!sessions.some(session => session[0] === item.id_session)) {
                        sessions.push([item.id_session, item.date, item.heure_debut, item.nbplaces - item.nb_participants]);
                    }

                    if (imageJeu == "") {
                        imageJeu = item.url_image;
                    }

                    if (nomJeu == "") {
                        nomJeu = item.nom;
                    }
                });

                var imageJeuElement = document.querySelector('.image_jeu');
                if (imageJeuElement) {
                    imageJeuElement.src = imageJeu;
                    imageJeuElement.alt = nomJeu
                }

                var nomJeuText = document.querySelector('.nom_jeu');
                if (nomJeuText) {
                    nomJeuText.textContent = nomJeu;
                }

                var selectSessions = document.getElementsByName("selectSessions")[0];
                selectSessions.innerHTML = '';
                sessions.forEach(function (session) {
                    var sessionID = parseInt(session[0]);

                    if (session[3] !== 0) {
                        var option = document.createElement("option");
                        option.text = session[1] + " à " + session[2];
                        option.value = session[0];

                        selectSessions.add(option);
                    }
                });
                if (selectSessions) {
                    var firstOption = selectSessions.options[0];

                    if (firstOption) {
                        var firstOptionValue = firstOption.value;
                        getRecompenses(firstOptionValue);
                    }
                }

                if (selectSessions.options.length === 0) {
                    document.querySelector('.selectSessions').remove();
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
        window.location.href = '<?php echo base_url("public/prix"); ?>/' + selectedText;
    });
    //#endregion

    // evenemebt de changement d'élément selectionné dans le select Sessions pour afficher les récompenses
    document.getElementsByName("selectSessions")[0].addEventListener('change', function () {
        var selectedId = this.options[this.selectedIndex].value;
        getRecompenses(selectedId);
    });

    // méthode permettant de récupérer toutes les récompenses à partir d'une requête ajax
    function getRecompenses(session) {
        var data = {
            session: session,
        };

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("public")?>/ajax/getRecompenses',
            data: data,
            success: function (response) {
                if(response.data !== null) {

                    var recompensesList = response.data.map(function (item) {
                        return item.place + ' - ' + item.libelle;
                    });

                    var recompensesText = recompensesList.join('\n');

                    document.querySelector('.prix').innerText = recompensesText;
                }
                else
                {
                    document.querySelector('.prix').innerText = "";
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
