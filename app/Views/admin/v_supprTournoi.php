<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/supprTournoi");

        echo '<p>';
        echo form_label('Supprimer un tournoi :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($tournoisList)) {
            foreach ($tournoisList as $tournoi) {
                $options[$tournoi->id_tournoi] = $tournoi->jeu_tournoi . ' sur ' . $tournoi->plateforme_tournoi;
            }
        }

        // création du dropdown
        echo form_dropdown('tournoi', $options, '', 'id="tournoi" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer le tournoi",
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
