<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/ajoutRecompense");

        echo "<h1>Ajouter une récompense</h1>";

        echo '<p>';
        echo form_label('Session :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($sessionsList)) {
            foreach ($sessionsList as $session) {
                $options[$session->id_session] = $session->nom_jeu . " sur " . $session->nom_plateforme . " le " . $session->date . " à " . $session->heure_debut;
            }
        }

        // création du dropdown
        echo form_dropdown('session', $options, '', 'id="session" class="settingsSelect"');
        echo '</p>' . '<p>';
        echo form_label('Place :') . "<br>";
        $data = array(
            'type' => 'number',
            'name' => 'place',
            'id' => 'place',
            'class' => 'settingsSelect'
        );
        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('place');
        }
        echo '</p>' . '<p>';
        echo form_label('Récompense :') . "<br>";
        $data = array(
            'name' => 'recompense',
            'id' => 'recompense',
            'class' => 'settingsSelect'
        );
        echo form_textarea($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('recompense');
        }
        echo "</p>";

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter la session de tournoi",
            'type' => 'submit'
        );

        echo form_button($data);
        echo "</p>";

        echo form_close();
    } else {
        header("Location: " . base_url() . 'public/utilisateur');
        exit();
    }
    ?>
</div>