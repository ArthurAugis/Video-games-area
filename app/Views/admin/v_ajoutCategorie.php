<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/ajoutCategorie");

        echo '<p>';
        echo form_label('Ajouter une catégorie :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'categorie',
            'id' => 'categorie',
            'value' => set_value('categorie'),
            'type' => 'text',
            'placeholder' => 'Catégorie à ajouter',
            'class' => 'settingsSelect'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('categorie');
        }
        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter la catégorie",
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
