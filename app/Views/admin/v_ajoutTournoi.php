<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/ajoutTournoi");

        echo "<h1>Ajouter un tournoi</h1>";

        echo '<p>';
        echo form_label('Jeu :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($nonTournoisList)) {
            foreach ($nonTournoisList as $nonTournoi) {
                $options[$nonTournoi->id_jeu] = $nonTournoi->nom_jeu . " sur " . $nonTournoi->plateforme_jeu;
            }
        }

        // création du dropdown
        echo form_dropdown('jeu', $options, '', 'id="jeu" class="settingsSelect"');

        echo "</p>";

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter la catégorie au jeu",
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