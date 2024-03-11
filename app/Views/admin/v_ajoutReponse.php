<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/ajoutReponse");

        echo '<p>';
        echo form_label('Ajouter une réponse :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'reponse',
            'id' => 'reponse',
            'value' => set_value('reponse'),
            'type' => 'text',
            'placeholder' => 'Réponse à ajouter',
            'class' => 'settingsSelect'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('reponse');
        }
        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter la réponse",
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
