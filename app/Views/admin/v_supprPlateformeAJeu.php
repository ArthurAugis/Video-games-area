<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/supprJeuAPlateforme");

        echo '<p>';
        echo form_label('Supprimer une plateforme à un jeu :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($plateformeJeuxList)) {
            foreach ($plateformeJeuxList as $plateforme) {
                $options[$plateforme->id] = $plateforme->jeu . ' - ' . $plateforme->plateforme;
            }
        }

        // création du dropdown
        echo form_dropdown('plateforme', $options, '', 'id="plateforme" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer la plateforme du jeu",
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
