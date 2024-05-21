<?php
/**
 * Role : 
 *  determine le personnage qui à gagner un combat
 *  inserer le resulat dans la base de données
 * Parm : id de la personne attaquée
 */

// Initialisation
require_once "utils/init.php";

// verification de la connexion
$session = new session ();
if ( ! $session->isConnected()) {
    include "templates/pages/form_connexion_view.php";
    exit;
}

// verification donnée GET
if (! empty ($_GET)) {
    $idSubirAttaque = $_GET['id'];
} else {
    include "templates/pages/form_connexion_view.php";
    exit;
}
$personnage = new personnage($session->getIdConnected()); 
$personnage->subirAttaque($idSubirAttaque);