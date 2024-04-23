<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/supprReponse");

        echo '<p>';
        echo form_label('Supprimer une réponse :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($reponseList)) {
            foreach ($reponseList as $reponse) {
                $options[$reponse->libelle] = $reponse->libelle;
            }
        }

        // création du dropdown
        echo form_dropdown('reponse', $options, '', 'id="reponse" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer la réponse",
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
