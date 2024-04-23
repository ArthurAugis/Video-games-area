<div class="corps settings">
    <h2><?= $titre; ?></h2>
    <?php
    $session = \Config\Services::session();
    // vérifie qu'il y a bien un login de stocké dans la session
    if (session()->get('login')) {
        echo form_open(base_url() . "utilisateur/changerpseudo");

        echo '<p>';
        echo form_label('Changer ton pseudo :') . "<br>";

        $data = array(
            'name' => 'changerpseudo_pseudo',
            'id' => 'changerpseudo_pseudo',
            'value' => set_value('changerpseudo_pseudo'),
            'type' => 'text',
            'placeholder' => 'Ton pseudo'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        echo $validation->getError('changerpseudo_pseudo');
        echo "</p>" . "<p>";

        $data = array(
            'name' => 'submit_form_changerpseudo',
            'content' => "Changer mon pseudo",
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