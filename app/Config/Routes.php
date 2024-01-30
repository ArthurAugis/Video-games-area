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

$routes->match(['get', 'post'], '/utilisateur/deconnexion', 'c_utilisateur::deconnexion');

$routes->match(['get', 'post'], '/utilisateur/changerpseudo', 'c_utilisateur::changerpseudo');

$routes->match(['get', 'post'], '/utilisateur/changermail', 'c_utilisateur::changermail');

$routes->match(['get', 'post'], '/utilisateur/changerage', 'c_utilisateur::changerage');

$routes->match(['get', 'post'], '/utilisateur/changermdp', 'c_utilisateur::changermdp');