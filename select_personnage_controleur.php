<?php

/**
 * Role : selectionne les données (caracteristiques) d'un personnage
 * Parm : neant
 */

 // initialisation
 include "utils/init.php";
/*
 // verification de la connexion
if ( ! $session->isConnected()) {
    include "templates/pages/form_connexion_view.php";
    exit;
}
*/

$personnage = new personnage($session->getIdConnected ());
$caracteristiques = $personnage->caracteristiquesPerso();

$json = json_encode($data);
echo $json;
