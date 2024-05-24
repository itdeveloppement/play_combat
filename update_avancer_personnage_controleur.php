<?php

/**
 * Role : 
 *  modifier les points d'agilité dans la base quand le personnage avance
 *  inserer l'historique de l'évenement
 * Parm : neant
 */

// Initialisation
require_once "utils/init.php";

// verification de la connexion
if ( ! $session->isConnected()) {
    include "templates/pages/form_connexion_view.php";
    exit;
}

// modification des caracteristiques du personnage et insertion histo evenement
$personnage = new personnage($session->getIdConnected());  
$personnage->avancer();
$historique = $personnage->histoEvenements();
$numSalle = $personnage->get("salle");
// preparer et encoder en json le retour des données a afficher
$listePersonnageSalle = $personnage->listePersonnagesSalle($numSalle);

$personnage = [
    "salle" => $personnage->get("salle"),
    "pts_vie" => $personnage->get("pts_vie"),
    "pts_agilite" => $personnage->get("pts_agilite"),
];

$data = [
    "personnage" => $personnage,
    "historique" => $historique,
    "listePersonnageSalle" => $listePersonnageSalle
];

header('Content-Type: application/json; charset=utf-8');
$json = json_encode($data);
echo $json;