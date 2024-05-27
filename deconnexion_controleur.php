<?php

/**
 * Role : 
 *  deconnecter  la session
 *  afficher le formulaire de connexion
 * Parm : neant
 */

 // initialisation
 include "utils/init.php";

 $personnage = new personnage($session->getIdConnected());
 
 // verification de la connexion
 if ($personnage->isDead()) {
    $session->deconnect();
    include "templates/pages/page_message_isdead.php";
    exit;
}

// deconnecte la session en passant id = 0
$session->deconnect();

 // initialisation
 include "templates/pages/form_connexion_view.php";