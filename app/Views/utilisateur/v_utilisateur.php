<div class="corps">
    <div class="gauche">
        <h2><?= $titre; ?></h2>
        <?php
        $session = \Config\Services::session();

        // Vérifie si il y a déjà un compte de connecté
        if (!session()->get('mail') || !session()->get('mdp')) {
            // si non ça affiche les formulaires de connexion/inscription
            ?>
        <div class="inscription">
            <h1>S'inscrire</h1>
            <?php
            echo form_open(base_url() . "public/utilisateur");

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
                'placeholder' => 'Mot de passe'
            );

            echo form_password($data);
            echo "</p>" . "<p>";
            echo $validation->getError('inscrire_mdp');
            echo "</p>" . "<p>";

            echo form_label('Confirmez votre mot de passe:') . "<br>";

            $data = array(
                'name' => 'inscrire_confirme_mdp',
                'id' => 'inscrire_confirme_mdp',
                'value' => set_value('inscrire_confirme_mdp'),
                'placeholder' => 'Confirme ton mot de passe'
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

            <p>Déjà un compte ? <?=anchor(base_url() . 'public/utilisateur/connexion', "Connecte toi");?></p>
        </div>
            <?php
        } else {
            // si oui ça affiche le menu des utilisateurs
            ?>
        <div class="interface">

            <?php if(session()->get('mail')){ ?>
                <div class="mail interface-item">
                    <h4>Mail</h4>
                    <h5><?= session()->get('mail'); ?></h5>
                    <h5><?=anchor(base_url() . 'public/utilisateur/changermail', "Changer de mail");?></h5>
                </div>

            <?php }if(session()->get('login')){ ?>
                <div class="pseudo interface-item">
                    <h4>Pseudo</h4>
                    <h5><?= session()->get('login'); ?></h5>
                    <h5><?=anchor(base_url() . 'public/utilisateur/changerpseudo', "Changer de pseudo");?></h5>
                </div>

            <?php } if(session()->get('age') || session()->get('age') == 0){ ?>
                <div class="age interface-item">
                    <h4>Age</h4>
                    <h5><?= session()->get('age'); ?></h5>
                    <h5><?=anchor(base_url() . 'public/utilisateur/changerage', "Changer ton âge");?></h5>
                </div>
            <?php }if(session()->get('mdp')){ ?>
                <div class="mdp interface-item">
                    <h4>Mot de passe</h4>
                    <h5><?=anchor(base_url() . 'public/utilisateur/changermdp', "Changer ton mot de passe");?></h5>
                </div>
            <?php } if(session()->get('admin')){ ?>
            t'es admin
            <?php } ?>

            <h5><?=anchor(base_url() . 'public/utilisateur/deconnexion', "Me déconnecter");?></h5>

        </div>
            <?php
        }
        ?>
    </div>
    <div class="droite">
        <?php
        $proprieteImage =
            [
                'src' => '/public/img/link_inscription.jpg',
                'alt' => "Link qui s'enregistre",
                'class' => 'register-img'
            ];

        echo img($proprieteImage);
        ?>
    </div>
</div>
