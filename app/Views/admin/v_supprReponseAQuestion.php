<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/supprReponseAQuestion");

        echo '<p>';
        echo form_label('Supprimer une réponse à une question :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($quiz)) {
            foreach ($quiz as $questionreponse) {
                $options[$questionreponse->id] = $questionreponse->Questions . ' - ' . $questionreponse->Reponses;
            }
        }

        // création du dropdown
        echo form_dropdown('reponse', $options, '', 'id="reponse" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer la réponse à la question",
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
