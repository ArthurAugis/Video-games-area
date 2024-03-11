<div class="corps">
    <div class="interface">

        <?php if (session()->get('mail')) { ?>
            <div class="interface-item">
                <h4>Mail</h4>
                <h5><?= session()->get('mail'); ?></h5>
                <h5><?= anchor(base_url() . 'public/utilisateur/changermail', "Changer de mail", array('class' => 'redirect')); ?></h5>
            </div>

        <?php }
        if (session()->get('login')) { ?>
            <div class="interface-item">
                <h4>Pseudo</h4>
                <h5><?= session()->get('login'); ?></h5>
                <h5><?= anchor(base_url() . 'public/utilisateur/changerpseudo', "Changer de pseudo", array('class' => 'redirect')); ?></h5>
            </div>

        <?php }
        if (session()->get('age') || session()->get('age') == 0) { ?>
            <div class="interface-item">
                <h4>Age</h4>
                <h5><?= session()->get('age'); ?></h5>
                <h5><?= anchor(base_url() . 'public/utilisateur/changerage', "Changer ton âge", array('class' => 'redirect')); ?></h5>
            </div>
        <?php }
        if (session()->get('mdp')) { ?>
            <div class="interface-item">
                <h4>Mot de passe</h4>
                <h5><?= anchor(base_url() . 'public/utilisateur/changermdp', "Changer ton mot de passe", array('class' => 'redirect')); ?></h5>
            </div>
    </div>
    <?php }
        // vérifie si l'utilisateur est administrateur
    if (session()->get('admin')) { ?>
    <div class="interface">
        <div class="interface-item">
            <h4>Administrateurs</h4>
            <h5><?= anchor(base_url() . 'public/admin/ajoutAdmin', "Ajouter un administrateur", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprAdmin', "Supprimer un administrateur", array('class' => 'redirect')); ?></h5>
        </div>
        <div class="interface-item">
            <h4>Quiz</h4>
            <h5><?= anchor(base_url() . 'public/admin/ajoutQuestion', "Ajouter une question", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprQuestion', "Supprimer une question", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/ajoutReponse', "Ajouter une réponse", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprReponse', "Supprimer une réponse", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/ajoutReponseAQuestion', "Ajouter une réponse à une question", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprReponseAQuestion', "Supprimer une réponse à une question", array('class' => 'redirect')); ?></h5>
        </div>
        <div class="interface-item">
            <h4>Tournois</h4>
            <h5><?= anchor(base_url() . 'public/admin/ajoutPlateforme', "Ajouter une plateforme", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprPlateforme', "Supprimer une plateforme", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/ajoutJeu', "Ajouter un jeu", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprJeu', "Supprimer un jeu", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/ajoutJeuAPlateforme', "Ajouter un jeu à une plateforme", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprJeuAPlateforme', "Supprimer un jeu à une plateforme", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/ajoutTournoi', "Ajouter un tournois", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprTournoi', "Supprimer un tournois", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/ajoutCategorie', "Ajouter une categorie", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprCategorie', "Supprimer une categorie", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/ajoutCategorieAJeu', "Ajouter une catégorie à un jeu", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprCategorieAJeu', "Supprimer une catégorie à un jeu", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/ajoutSession', "Ajouter une session de tournois", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprSession', "Supprimer une session de tournois", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/ajoutRecompense', "Ajouter une récompense", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/supprRecompense', "Supprimer une récompense", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/admin/modifDatesVote', "Modifier la date de début et de fin de vote", array('class' => 'redirect')); ?></h5>
        </div>
    </div>
    <?php } ?>
    <div class="interface">
        <div class="interface-item">
            <h5><?= anchor(base_url() . 'public/utilisateur/deconnexion', "Me déconnecter", array('class' => 'redirect')); ?></h5>
            <h5><?= anchor(base_url() . 'public/utilisateur/supprimer', "Supprimer mon compte", array('class' => 'redirect')); ?></h5>
        </div>
    </div>

    </div>
</div>
