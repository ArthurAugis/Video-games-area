<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/supprAdmin");

        echo '<p>';
        echo form_label('Supprimer un administrateur :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($adminList)) {
            foreach ($adminList as $admin) {
                $options[$admin->pseudo] = $admin->pseudo;
            }
        }

        // création du dropdown
        echo form_dropdown('admin', $options, '', 'id="admin" class="settingsSelect"');

        echo '</p>';

        $data = array(
            'name' => 'submit_form',
            'content' => "Supprimer l'administrateur",
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
