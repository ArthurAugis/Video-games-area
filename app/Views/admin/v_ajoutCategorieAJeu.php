<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/ajoutCategorieAJeu");

        echo "<h1>Ajouter une catégorie à un jeu</h1>";

        echo '<p>';
        echo form_label('Jeu :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($jeuxList)) {
            foreach ($jeuxList as $jeu) {
                $options[$jeu->id] = $jeu->nom;
            }
        }

        // création du dropdown
        echo form_dropdown('jeu', $options, '', 'id="jeu" class="settingsSelect"');

        echo '</p>' . '<p>';
        echo form_label('Catégorie :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($categoriesList)) {
            foreach ($categoriesList as $categorie) {
                $options[$categorie->id] = $categorie->nom_categorie;
            }
        }

        // création du dropdown
        echo form_dropdown('categorie', $options, '', 'id="categorie" class="settingsSelect"');
        echo "</p>";

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter la catégorie au jeu",
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
