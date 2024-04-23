<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/ajoutReponseAQuestion");

        echo "<h1>Ajouter une réponse à une question</h1>";

        echo '<p>';
        echo form_label('Question :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($questionsList)) {
            foreach ($questionsList as $question) {
                $options[$question->id] = $question->libelle;
            }
        }

        // création du dropdown
        echo form_dropdown('question', $options, '', 'id="question" class="settingsSelect"');

        echo '</p>' . '<p>';
        echo form_label('Réponse :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($reponsesList)) {
            foreach ($reponsesList as $reponse) {
                $options[$reponse->id] = $reponse->libelle;
            }
        }

        // création du dropdown
        echo form_dropdown('reponse', $options, '', 'id="reponse" class="settingsSelect"');

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'bonne',
            'id' => 'bonne',
            'checked' => false,
            'type' => 'checkbox'
        );

        echo form_checkbox($data) . "Bonne réponse ?";
        echo "</p>";

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter la réponse à la question",
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
