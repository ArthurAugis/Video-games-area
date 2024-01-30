<div class="corps block">
    <h2><?= $titre; ?></h2>
    <?php
    $session = \Config\Services::session();
    if (session()->get('login')) {
        echo form_open(base_url() . "public/utilisateur/changermail");

        echo '<p>';
        echo form_label('Changer ton mail :') . "<br>";

        $data = array(
            'name' => 'changermail_mail',
            'id' => 'changermail_mail',
            'value' => set_value('changermail_mail'),
            'type' => 'mail',
            'placeholder' => 'Ton mail'
        );

        echo form_input($data);
        echo "</p>" . "<p>";
        echo $validation->getError('changermail_mail');
        echo "</p>" . "<p>";

        $data = array(
            'name' => 'submit_form_changermail',
            'content' => "Changer mon mail",
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