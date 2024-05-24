<?php

/**
 * Role : 
 *  deconnecter  la session
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

// deconnecte la session en passant id = 0
$session->deconnect();

 // initialisation
 include "templates/pages/form_connexion_view.php";