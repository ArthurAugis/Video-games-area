<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/ajoutPlateforme");

        echo '<p>';
        echo form_label('Ajouter une plateforme :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'plateforme',
            'id' => 'plateforme',
            'value' => set_value('plateforme'),
            'type' => 'text',
            'placeholder' => 'Plateforme à ajouter',
            'class' => 'settingsSelect'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('plateforme');
        }
        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter la plateforme",
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
