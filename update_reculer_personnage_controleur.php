<?php

/**
 * Role : 
 *  modifier les points d'agilité dans la base quand le personnage recule
 *  inserer l'historique de l'évenement
 * Parm : neant
 */

// Initialisation
require_once "utils/init.php";

// verification de la connexion
$session = new session ();
if ( ! $session->isConnected()) {
    include "templates/pages/form_connexion_view.php";
    exit;
}

// modification des caracteristiques du personnage et insertion histo evenement
$personnage = new personnage($session->getIdConnected());  
$personnage->reculer();