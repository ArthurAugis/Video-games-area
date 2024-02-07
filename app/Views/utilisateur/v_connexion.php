<div class="corps">
    <div class="gauche">
        <h2><?= $titre; ?></h2>
        <?php
        $session = \Config\Services::session();
        ?>
            <div class="connexion">
                <h1>Se connecter</h1>
                <?php
                echo form_open(base_url() . "public/utilisateur/connexion");

                echo '<p>';
                echo form_label('Mail :') . "<br>";

                $data = array(
                    'name' => 'connexion_mail',
                    'id' => 'connexion_mail',
                    'value' => set_value('connexion_mail'),
                    'type' => 'mail',
                    'placeholder' => 'Adresse mail'
                );

                echo form_input($data);
                echo "</p>" . "<p>";
                echo $validation->getError('connexion_mail');
                echo "</p>" . "<p>";

                echo form_label('Mot de passe :') . "<br>";

                $data = array(
                    'name' => 'connexion_mdp',
                    'id' => 'connexion_mdp',
                    'value' => set_value('connexion_mdp'),
                    'placeholder' => 'Mot de passe'
                );

                echo form_password($data);
                echo "</p>" . "<p>";
                echo $validation->getError('connexion_mdp');
                echo "</p>" . "<p>";

                $data = array(
                    'name' => 'submit_form_connexion',
                    'content' => "Me connecter",
                    'type' => 'submit'
                );

                echo form_button($data);
                echo "</p>";

                echo form_close();
                ?>

                <p>Pas encore de compte ? <?=anchor(base_url() . 'public/utilisateur', "Inscrit toi");?></p>
            </div>
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
