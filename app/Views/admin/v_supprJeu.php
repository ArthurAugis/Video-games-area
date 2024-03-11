<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/supprJeu");

        echo '<p>';
        echo form_label('Supprimer un jeu :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($jeuxList)) {
            foreach ($jeuxList as $jeu) {
                $options[$jeu->id] = $jeu->nom;
            }
        }

        // création du dropdown
        echo form_dropdown('jeu', $options, '', 'id="jeu" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer le jeu",
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
