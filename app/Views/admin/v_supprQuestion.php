<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/supprQuestion");

        echo '<p>';
        echo form_label('Supprimer une question :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($questionList)) {
            foreach ($questionList as $question) {
                $options[$question->libelle] = $question->libelle;
            }
        }

        // création du dropdown
        echo form_dropdown('question', $options, '', 'id="question" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer la question",
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
