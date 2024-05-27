<?php

/**
 * Role : 
 *  modifier les points de forceen resistance
 *  inserer l'historique de l'évenement
 * Parm : neant
 */

// Initialisation
require_once "utils/init.php";

// verification de la connexion
if ($personnage->isDead()) {
    $session->deconnect();
    include "templates/pages/page_message_isdead.php";
    exit;
}

// modification des caracteristiques du personnage et insertion histo evenement
$personnage = new personnage($session->getIdConnected());  
$personnage->transformerForce();
// preparer le retour des données a afficher
$data = [
    "pts_force" => $personnage->get("pts_force"),
    "pts_agilite" => $personnage->get("pts_agilite"),
    "pts_resistance" => $personnage->get("pts_resistance"),
];
header('Content-Type: application/json; charset=utf-8');
$json = json_encode($data);
echo $json;