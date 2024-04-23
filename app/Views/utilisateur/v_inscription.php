<div class="corps flex">
    <div class="gauche">
        <h2><?= $titre; ?></h2>
            <div class="inscription">
                <h1>S'inscrire</h1>
                <?php
                echo form_open(base_url() . "utilisateur/inscription");

                echo '<p>';
                echo form_label('Mail :') . "<br>";

                $data = array(
                    'name' => 'inscrire_mail',
                    'id' => 'inscrire_mail',
                    'value' => set_value('inscrire_mail'),
                    'type' => 'mail',
                    'placeholder' => 'Adresse mail'
                );

                echo form_input($data);
                echo "</p>" . "<p>";
                echo $validation->getError('inscrire_mail');
                echo "</p>" . "<p>";
                echo form_label('Login :') . "<br>";

                $data = array(
                    'name' => 'inscrire_login',
                    'id' => 'inscrire_login',
                    'value' => set_value('inscrire_login'),
                    'type' => 'text',
                    'placeholder' => 'Login'
                );

                echo form_input($data);
                echo "</p>" . "<p>";
                echo $validation->getError('inscrire_login');
                echo "</p>" . "<p>";

                echo form_label('Age :') . "<br>";

                $data = array(
                    'name' => 'inscrire_age',
                    'id' => 'inscrire_age',
                    'value' => set_value('inscrire_age'),
                    'type' => 'number',
                    'placeholder' => 'Ton âge'
                );

                echo form_input($data);
                echo "</p>" . "<p>";
                echo $validation->getError('inscrire_age');
                echo "</p>" . "<p>";

                echo form_label('Mot de passe (Minimum 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractères spécial) :') . "<br>";

                $data = array(
                    'name' => 'inscrire_mdp',
                    'id' => 'inscrire_mdp',
                    'value' => set_value('inscrire_mdp'),
                    'placeholder' => 'Mot de passe',
                    'class' => 'mdp'
                );

                echo form_password($data);
                $data = array(
                    'name' => 'submit_form_inscription',
                    'content' => '<i class="fa-solid fa-eye"></i>',
                    'class' => 'viewpassword'
                );

                echo form_button($data);
                echo "</p>" . "<p>";
                echo $validation->getError('inscrire_mdp');
                echo "</p>" . "<p>";

                echo form_label('Confirmez votre mot de passe:') . "<br>";

                $data = array(
                    'name' => 'inscrire_confirme_mdp',
                    'id' => 'inscrire_confirme_mdp',
                    'value' => set_value('inscrire_confirme_mdp'),
                    'placeholder' => 'Confirme ton mot de passe',
                    'class' => 'mdp'
                );

                echo form_password($data);
                echo "</p>" . "<p>";
                echo $validation->getError('inscrire_confirme_mdp');
                echo "</p>" . "<p>";

                $data = array(
                    'name' => 'inscrire_conditions',
                    'id' => 'inscrire_conditions',
                    'value' => 'accepte',
                    'checked' => false,
                    'type' => 'checkbox'
                );

                echo form_checkbox($data) . "J'accepte les conditions";
                echo "</p>" . "<p>";
                echo $validation->getError('inscrire_conditions');
                echo "</p>" . "<p>";

                $data = array(
                    'name' => 'submit_form_inscription',
                    'content' => "M'inscrire",
                    'type' => 'submit'
                );

                echo form_button($data);
                echo "</p>" . "<p>";

                echo "</p>";



                echo form_close();
                ?>

                <p>Déjà un compte ? <?=anchor(base_url() . 'utilisateur/connexion', "Connecte toi", array('class' => 'redirect'));?></p>
            </div>
    </div>
    <div class="droite">
        <?php
        $proprieteImage =
            [
                'src' => '/img/link_inscription.jpg',
                'alt' => "Link qui s'enregistre",
                'class' => 'image'
            ];

        echo img($proprieteImage);
        ?>
    </div>
</div>
