<?php

/**
 * Role : afficher les regles du jeux
 * Parm : neant
 */

// Initialisation
require_once "utils/init.php";

print_r($_SESSION);
// verification de la connexion
if ( ! $session->isConnected()) {
    include "templates/pages/form_connexion_view.php";
    exit;
}
// verification si personnage vivant
if (! $personnage->isDead()) {
    $session->deconnect();
    include "templates/pages/page_message_isdead.php";
    exit;
}

 // affiche la page du jeux
include "templates/pages/page_regles_jeu_view.php";