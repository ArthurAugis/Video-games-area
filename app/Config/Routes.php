<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->match(['get', 'post'], '/', 'c_accueil::index');

$routes->match(['get', 'post'], '/vote', 'c_vote::index');

$routes->match(['get', 'post'], '/tournois', 'c_tournois::index');

$routes->match(['get', 'post'], '/prix', 'c_prix::index');

$routes->match(['get', 'post'], '/quiz', 'c_quiz::index');

$routes->match(['get', 'post'], '/utilisateur', 'c_utilisateur::index');

$routes->match(['get', 'post'], '/utilisateur/connexion', 'c_utilisateur::connexion');

$routes->match(['get', 'post'], '/utilisateur/inscription', 'c_utilisateur::inscription');

$routes->match(['get', 'post'], '/utilisateur/deconnexion', 'c_utilisateur::deconnexion');

$routes->match(['get', 'post'], '/utilisateur/changerpseudo', 'c_utilisateur::changerpseudo');

$routes->match(['get', 'post'], '/utilisateur/changermail', 'c_utilisateur::changermail');

$routes->match(['get', 'post'], '/utilisateur/changerage', 'c_utilisateur::changerage');

$routes->match(['get', 'post'], '/utilisateur/changermdp', 'c_utilisateur::changermdp');

$routes->match(['get', 'post'], '/utilisateur/supprimer', 'c_utilisateur::supprimer');

$routes->match(['get', 'post'], '/admin/ajoutAdmin', 'c_admin::ajoutAdmin');

$routes->match(['get', 'post'], '/admin/supprAdmin', 'c_admin::supprAdmin');

$routes->match(['get', 'post'], '/admin/ajoutQuestion', 'c_admin::ajoutQuestion');

$routes->match(['get', 'post'], '/admin/supprQuestion', 'c_admin::supprQuestion');

$routes->match(['get', 'post'], '/admin/ajoutReponse', 'c_admin::ajoutReponse');

$routes->match(['get', 'post'], '/admin/supprReponse', 'c_admin::supprReponse');

$routes->match(['get', 'post'], '/admin/ajoutPlateforme', 'c_admin::ajoutPlateforme');

$routes->match(['get', 'post'], '/admin/supprPlateforme', 'c_admin::supprPlateforme');

$routes->match(['get', 'post'], '/admin/ajoutJeu', 'c_admin::ajoutJeu');

$routes->match(['get', 'post'], '/admin/supprJeu', 'c_admin::supprJeu');

$routes->match(['get', 'post'], '/admin/ajoutCategorie', 'c_admin::ajoutCategorie');

$routes->match(['get', 'post'], '/admin/supprCategorie', 'c_admin::supprCategorie');

$routes->match(['get', 'post'], '/admin/ajoutReponseAQuestion', 'c_admin::ajoutReponseAQuestion');

$routes->match(['get', 'post'], '/admin/supprReponseAQuestion', 'c_admin::supprReponseAQuestion');

$routes->match(['get', 'post'], '/admin/ajoutCategorieAJeu', 'c_admin::ajoutCategorieAJeu');

$routes->match(['get', 'post'], '/admin/supprCategorieAJeu', 'c_admin::supprCategorieAJeu');

$routes->match(['get', 'post'], '/admin/ajoutJeuAPlateforme', 'c_admin::ajoutJeuAPlateforme');

$routes->match(['get', 'post'], '/admin/supprJeuAPlateforme', 'c_admin::supprPlateformeAJeu');

$routes->match(['get', 'post'], '/admin/ajoutTournoi', 'c_admin::ajoutTournoi');

$routes->match(['get', 'post'], '/admin/supprTournoi', 'c_admin::supprTournoi');

$routes->match(['get', 'post'], '/admin/ajoutSession', 'c_admin::ajoutSession');

$routes->match(['get', 'post'], '/admin/supprSession', 'c_admin::supprSession');

$routes->match(['get', 'post'], '/admin/modifDatesVote', 'c_admin::modifDatesVote');

$routes->match(['get', 'post'], '/admin/ajoutRecompense', 'c_admin::ajoutRecompense');

$routes->match(['get', 'post'], '/admin/supprRecompense', 'c_admin::supprRecompense');

$routes->match(['get', 'post'], '/scoreboardQuiz', 'c_quiz::scoreboardQuiz');

$routes->match(['get', 'post'], '/prix/(:segment)', 'c_prix::prixPlateforme/$1');

$routes->match(['get', 'post'], '/vote/(:segment)', 'c_vote::VoteJeux/$1');

$routes->match(['get', 'post'], '/tournois/(:segment)', 'c_tournois::InscriptionTournois/$1');

$routes->post('/ajax/getSessionsTournoi', 'c_tournois::getSessionsTournoi');

$routes->post('/ajax/getRecompenses', 'c_prix::getRecompensesTournoi');
