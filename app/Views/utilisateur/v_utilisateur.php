<div class="corps">
    <div class="interface">

        <?php if (session()->get('mail')) { ?>
            <div class="interface-item">
                <h4>Mail</h4>
                <h5><?= session()->get('mail'); ?></h5>
                <h5><?= anchor(base_url() . 'utilisateur/changermail', "Changer de mail", array('class' => 'redirect')); ?></h5>
            </div>

        <?php }
        if (session()->get('login')) { ?>
            <div class="interface-item">
                <h4>Pseudo</h4>
                <h5><?= session()->get('login'); ?></h5>
                <h5><?= anchor(base_url() . 'utilisateur/changerpseudo', "Changer de pseudo", array('class' => 'redirect')); ?></h5>
            </div>

        <?php }
        if (session()->get('age') || session()->get('age') == 0) { ?>
            <div class="interface-item">
                <h4>Age</h4>
                <h5><?= session()->get('age'); ?></h5>
                <h5><?= anchor(base_url() . 'utilisateur/changerage', "Changer ton âge", array('class' => 'redirect')); ?></h5>
            </div>
        <?php }
        if (session()->get('mdp')) { ?>
            <div class="interface-item">
                <h4>Mot de passe</h4>
                <h5><?= anchor(base_url() . 'utilisateur/changermdp', "Changer ton mot de passe", array('class' => 'redirect')); ?></h5>
            </div>
    </div>
    <?php }
        // vérifie si l'utilisateur est administrateur
    if (session()->get('admin')) { ?>
    <div class="interface">
        <div class="interface-item">
            <h4>Administrateurs</h4>
            <h5><?= anchor(base_url() . 'admin/ajoutAdmin', "Ajouter un administrateur", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprAdmin', "Supprimer un administrateur", array('class' => 'redirect')); ?></h5>
        </div>
        <div class="interface-item">
            <h4>Quiz</h4>
            <h5><?= anchor(base_url() . 'admin/ajoutQuestion', "Ajouter une question", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprQuestion', "Supprimer une question", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/ajoutReponse', "Ajouter une réponse", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprReponse', "Supprimer une réponse", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/ajoutReponseAQuestion', "Ajouter une réponse à une question", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprReponseAQuestion', "Supprimer une réponse à une question", array('class' => 'redirect')); ?></h5>
        </div>
        <div class="interface-item">
            <h4>Tournois</h4>
            <h5><?= anchor(base_url() . 'admin/ajoutPlateforme', "Ajouter une plateforme", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprPlateforme', "Supprimer une plateforme", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/ajoutJeu', "Ajouter un jeu", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprJeu', "Supprimer un jeu", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/ajoutJeuAPlateforme', "Ajouter un jeu à une plateforme", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprJeuAPlateforme', "Supprimer un jeu à une plateforme", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/ajoutTournoi', "Ajouter un tournois", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprTournoi', "Supprimer un tournois", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/ajoutCategorie', "Ajouter une categorie", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprCategorie', "Supprimer une categorie", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/ajoutCategorieAJeu', "Ajouter une catégorie à un jeu", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprCategorieAJeu', "Supprimer une catégorie à un jeu", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/ajoutSession', "Ajouter une session de tournois", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprSession', "Supprimer une session de tournois", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/ajoutRecompense', "Ajouter une récompense", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/supprRecompense', "Supprimer une récompense", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'admin/modifDatesVote', "Modifier la date de début et de fin de vote", array('class' => 'redirect')); ?></h5>
        </div>
    </div>
    <?php } ?>
    <div class="interface">
        <div class="interface-item">
            <h5><?= anchor(base_url() . 'utilisateur/deconnexion', "Me déconnecter", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'utilisateur/supprimer', "Supprimer mon compte", array('class' => 'redirect')); ?></h5>
        </div>
    </div>

    </div>
</div>
