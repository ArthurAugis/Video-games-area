<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/ajoutJeu");

        echo '<h1>Ajouter un jeu</h1>';
        echo '<p>';
        echo form_label('Nom :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'nom',
            'id' => 'nom',
            'value' => set_value('nom'),
            'type' => 'text',
            'placeholder' => 'Nom du jeu',
            'class' => 'settingsSelect'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('nom');
        }
        echo '</p>' . '<p>';
        echo form_label('Description :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'description',
            'id' => 'description',
            'value' => set_value('description'),
            'placeholder' => 'Description du jeu',
            'class' => 'settingsSelect'
        );

        echo form_textarea($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('description');
        }
        echo '</p>' . '<p>';

        echo form_label('Url image :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'url_image',
            'id' => 'url_image',
            'value' => set_value('url_image'),
            'type' => 'text',
            'placeholder' => "Url de l'image pour l'affiche du jeu",
            'class' => 'settingsSelect'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('url_image');
        }
        echo '</p>' . '<p>';

        echo form_label('Pegi :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'pegi',
            'id' => 'pegi',
            'value' => set_value('pegi'),
            'type' => 'number',
            'placeholder' => "PEGI du jeu",
            'class' => 'settingsSelect'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('pegi');
        }
        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter le jeu",
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
