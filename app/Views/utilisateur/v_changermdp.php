<div class="corps block">
    <h2><?= $titre; ?></h2>
    <?php
    $session = \Config\Services::session();
    if (session()->get('login')) {
        echo form_open(base_url() . "public/utilisateur/changermdp");

        echo '<p>';
        echo form_label('Changer ton mot de passe (Minimum 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractères spécial) :') . "<br>";

        $data = array(
            'name' => 'changermdp_mdp',
            'id' => 'changermdp_mdp',
            'value' => set_value('changermdp_mdp'),
            'type' => 'password',
            'placeholder' => 'Ton mot de passe'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        echo $validation->getError('changermdp_mdp');
        echo "</p>" . "<p>";

        echo form_label('Confirme ton mot de passe :') . "<br>";
        $data = array(
            'name' => 'changermdp_confirmmdp',
            'id' => 'changermdp_confirmmdp',
            'value' => set_value('changermdp_confirmmdp'),
            'type' => 'password',
            'placeholder' => 'Confirme ton mot de passe'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        echo $validation->getError('changermdp_confirmmdp');
        echo "</p>" . "<p>";

        $data = array(
            'name' => 'submit_form_changermdp',
            'content' => "Changer mon mot de passe",
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