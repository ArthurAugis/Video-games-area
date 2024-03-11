<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/ajoutQuestion");

        echo '<p>';
        echo form_label('Ajouter une question :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'question',
            'id' => 'question',
            'value' => set_value('question'),
            'type' => 'text',
            'placeholder' => 'Question à ajouter',
            'class' => 'settingsSelect'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('question');
        }
        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter la question",
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
