<div class="corps">
    <div class="flex">
        <div class="gauche">
            <h2>Bienvenue à l'Espace Jeux Vidéo du Festival !</h2>
            <p>Plongez dans l'excitation de l'année à venir, où les jeux emblématiques tels que Final Fantasy VII:
                Rebirth, Star Wars Outlaws Hollow Knight: Silksong, The Plucky Squire, Elden Ring: Shadow of the
                Erdtree, Metroid Prime 4 et bien d'autres sont sur le point de voir le jour. Après une période calme,
                préparez-vous à découvrir les futures pépites du monde du gaming.</p>
            <p>Rejoignez-nous pour une expérience unique où vous pourrez non seulement tester ces titres à venir, mais
                également vous immerger dans des jeux fraîchement sortis cette fin d'année 2023. Des grands classiques
                tels que Super Mario Bros., Rocket League, Spiderman, iRacing, Pokemon Scarlet et Pokemon Violet seront
                également à l'honneur.</p>
            <p>Le festival réserve une place de choix au rétro gaming avec une pléthore de postes de jeu pour
                redécouvrir l'épopée du jeu vidéo. C'est l'occasion pour les parents de partager leurs souvenirs
                vidéoludiques avec leurs enfants et pour tous de revisiter les titres iconiques de l'industrie.</p>
            <p>Pour célébrer cette année exceptionnelle, nous mettons en avant des jeux de tous horizons. Des tournois
                passionnants sont au programme, et nous vous offrons la possibilité de vous inscrire dès maintenant pour
                participer. Choisissez parmi des compétitions telles que League of Legends, Rocket League, Super Smash
                Bros Ultimate, Call of Duty, Fifa et Just Dance.</p>
        </div>
        <div class="droite">
            <?php
            $proprieteImage =
                [
                    'src' => '/img/magicarp.png',
                    'alt' => 'Magicarpe',
                    'class' => 'image'
                ];

            echo img($proprieteImage);
            ?>
        </div>
    </div>
    <div class="avis">
        <h1>Avis</h1>
        <div class="ajout-commentaire">
            <?php
            if (session()->get('login') && $participe) {
                echo form_open(base_url());



                echo '<p>';
                echo form_label('Tournois:') . "<br>";
                $options = array();
                foreach ($participe as $session) {
                    $options[$session->id_session] = $session->nom_jeu . " du " . $session->date_tournois . ' à ' .
                        $session->heure_debut_tournois . ' sur ' . $session->nom_plateforme_tournois;
                }

                // création du dropdown
                echo form_dropdown('ajout_avis_tournois', $options, '', 'id="ajout_avis_tournois"');
                echo "</p>" . "<p>";

                echo form_label('Note :') . "<br>";

                $data = array(
                    'name' => 'ajout_avis_note',
                    'id' => 'ajout_avis_note',
                    'value' => set_value('ajout_avis_note'),
                    'type' => 'number',
                    'placeholder' => 'Note sur 5',
                );

                echo form_input($data);
                echo "</p>" . "<p>";
                if (isset($validation)) {
                    echo $validation->getError('ajout_avis_note');
                }
                echo "</p>" . "<p>";

                echo form_label('Commentaire:') . "<br>";

                $data = array(
                    'name' => 'ajout_avis_commentaire',
                    'id' => 'ajout_avis_commentaire',
                    'value' => set_value('ajout_avis_commentaire'),
                    'placeholder' => 'Commentaire sur le tournois',
                );

                echo form_textarea($data);
                echo "</p>" . "<p>";
                if (isset($validation)) {
                    echo $validation->getError('ajout_avis_commentaire');
                }
                echo "</p>" . "<p>";

                $data = array(
                    'name' => 'submit_form_ajout_avis',
                    'content' => "Ajouter un avis",
                    'type' => 'submit'
                );

                echo form_button($data);
                echo "</p>";

                echo form_close();
            } else {
                echo '<h3>Tu dois être connecté et avoir participer à un tournois pour laisser un avis.</h3>';
            }
            ?>
        </div>
        <div class="commentaires-div">
            <?php
            if (!empty($commentaires)) {
                foreach ($commentaires as $commentaire) {
                    echo '<div class="commentaire">';
                    echo '<h3>' . esc($commentaire->pseudo_utilisateur) . '<span class="note_commentaire"> Note:' . esc($commentaire->note_tournois) . '/5</span></h3>';
                    echo '<p>Tournois ' . esc($commentaire->nom_jeu) . " du " . esc($commentaire->date_tournois) . ' à ' . esc($commentaire->heure_debut_tournois) . ' sur ' . esc($commentaire->nom_plateforme_tournois) . '</p>';
                    echo '<h4>Commentaire</h4>';
                    echo '<p>' . nl2br(esc($commentaire->commentaire_tournois)) . '</p>';

                    if (session()->get('login') === $commentaire->pseudo_utilisateur || session()->get('admin') === "1") {
                        echo form_open(base_url());
                        $data = array(
                            'name' => 'suppr_commentaire',
                            'id' => 'suppr_commentaire',
                            'value' => $commentaire->id,
                            'type' => 'hidden'
                        );

                        echo form_input($data);

                        $data = array(
                            'name' => 'submit_form_suppr_commentaire',
                            'content' => '<i class="fa-solid fa-trash"></i>',
                            'id' => "suppr_comment_btn",
                            'type' => 'submit'
                        );

                        echo form_button($data);
                        echo "</p>";

                        echo form_close();
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>
