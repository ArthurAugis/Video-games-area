<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/ajoutAdmin");

        echo '<p>';
        echo form_label('Ajouter un administrateur :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($nonAdminList)) {
            foreach ($nonAdminList as $nonAdmin) {
                $options[$nonAdmin->pseudo] = $nonAdmin->pseudo;
            }
        }

        // création du dropdown
        echo form_dropdown('nonAdmin', $options, '', 'id="nonAdmin" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter l'administrateur",
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
