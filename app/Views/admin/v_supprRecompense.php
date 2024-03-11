<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/supprRecompense");

        echo '<p>';
        echo form_label('Supprimer une récompense :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($recompensesList)) {
            foreach ($recompensesList as $recompense) {
                $options[$recompense->id] = $recompense->jeu . ' sur ' . $recompense->plateforme . ' pour la place ' . $recompense->place . '  - ' . $recompense->libelle;
            }
        }

        // création du dropdown
        echo form_dropdown('recompense', $options, '', 'id="recompense" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer la récompense",
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
