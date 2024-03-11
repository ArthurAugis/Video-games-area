<div class="corps settings">
    <h2><?= $titre; ?></h2>
    <?php
    $session = \Config\Services::session();
    // vérifie qu'il y a bien un age de stocké dans la session
    if (session()->get('age') || session()->get('age') == 0) {
        echo form_open(base_url() . "public/utilisateur/changerage");

        echo '<p>';
        echo form_label('Changer ton âge :') . "<br>";

        $data = array(
            'name' => 'changerage_age',
            'id' => 'changerage_age',
            'value' => set_value('changerage_age'),
            'type' => 'number',
            'placeholder' => 'Ton âge'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        echo $validation->getError('changerage_age');
        echo "</p>" . "<p>";

        $data = array(
            'name' => 'submit_form_changerage',
            'content' => "Changer mon âge",
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
