<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/supprPlateforme");

        echo '<p>';
        echo form_label('Supprimer une plateforme :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($plateformeList)) {
            foreach ($plateformeList as $plateforme) {
                $options[$plateforme->nom] = $plateforme->nom;
            }
        }

        // création du dropdown
        echo form_dropdown('plateforme', $options, '', 'id="plateforme" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer la plateforme",
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
