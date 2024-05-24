<?php

/**
 * Role : 
 *  deconnecter le personnage de la partie et deconnecter la session
 *  afficher le formulaire de connexion
 * Parm : neant
 */

 // initialisation
 include "utils/init.php";

 // verification de la connexion
if ( ! $session->isConnected()) {
    include "templates/pages/form_connexion_view.php";
    exit;
}

 // initialisation
 include "templates/pages/form_connexion_view.php";