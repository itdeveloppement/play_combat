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
 
// deconnecte la session en passant id = 0
$session->deconnect();

 // initialisation
 include "templates/pages/form_connexion_view.php";