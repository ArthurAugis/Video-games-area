<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/supprCategorie");

        echo '<p>';
        echo form_label('Supprimer une catégorie :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($categoriesList)) {
            foreach ($categoriesList as $categorie) {
                $options[$categorie->nom_categorie] = $categorie->nom_categorie;
            }
        }

        // création du dropdown
        echo form_dropdown('categorie', $options, '', 'id="categorie" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer la catégorie",
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
