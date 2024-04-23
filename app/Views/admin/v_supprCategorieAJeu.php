<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/supprCategorieAJeu");

        echo '<p>';
        echo form_label('Supprimer une catégorie à un jeu :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($categoriesJeuxList)) {
            foreach ($categoriesJeuxList as $categorie) {
                $options[$categorie->id] = $categorie->nom . ' - ' . $categorie->nom_categorie;
            }
        }

        // création du dropdown
        echo form_dropdown('categorie', $options, '', 'id="categorie" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer la catégorie du jeu",
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
