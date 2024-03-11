<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/ajoutJeuAPlateforme");

        echo "<h1>Ajouter un jeu à une plateforme</h1>";

        echo '<p>';
        echo form_label('Jeu :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($jeuxList)) {
            foreach ($jeuxList as $jeu) {
                $options[$jeu->id] = $jeu->nom;
            }
        }

        // création du dropdown
        echo form_dropdown('jeu', $options, '', 'id="jeu" class="settingsSelect"');

        echo '</p>' . '<p>';
        echo form_label('Plateforme :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($plateformeList)) {
            foreach ($plateformeList as $plateforme) {
                $options[$plateforme->id] = $plateforme->nom;
            }
        }

        // création du dropdown
        echo form_dropdown('plateforme', $options, '', 'id="plateforme" class="settingsSelect"');
        echo "</p>";

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter le jeu à la plateforme",
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
