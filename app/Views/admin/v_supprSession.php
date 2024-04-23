<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/supprSession");

        echo '<p>';
        echo form_label('Supprimer une session :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($sessionsList)) {
            foreach ($sessionsList as $session) {
                $options[$session->id_session] = $session->nom_jeu . " sur " . $session->nom_plateforme . " le " . $session->date . " à " . $session->heure_debut;
            }
        }

        // création du dropdown
        echo form_dropdown('session', $options, '', 'id="session" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer la session",
            'type' => 'submit'
        );

        echo form_button($data);
        echo "</p>";

        echo form_close();
    } else {
        header("Location: " . base_url() . 'utilisateur');
        exit();
    }
    ?>
</div>
