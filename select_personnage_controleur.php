<?php

/**
 * Role : selectionne les données (caracteristiques) d'un personnage
 * Parm : neant
 */

 // initialisation
 include "utils/init.php";

 // verification de la connexion
if ( ! $session->isConnected()) {
    include "templates/pages/form_connexion_view.php";
    exit;
}

$personnage = new personnage($session->getIdConnected ());

// verification si personnage vivant
if ($personnage->isDead()) {
    $session->deconnect();
    include "templates/pages/page_message_isdead.php";
    exit;
}

// preparer le retour des données a afficher
$historique = $personnage->histoEvenements();

// preparer et encoder en json le retour des données a afficher
$listePersonnageSalle = $personnage->listePersonnagesSalle($personnage->get("salle"));

$personnage = [
    "salle" => $personnage->get("salle"),
    "pts_vie" => $personnage->get("pts_vie"),
    "pts_force" => $personnage->get("pts_force"),
    "pts_agilite" => $personnage->get("pts_agilite"),
    "pts_resistance" => $personnage->get("pts_resistance"),
];

$data = [
    "personnage" => $personnage,
    "historique" => $historique,
    "listePersonnageSalle" => $listePersonnageSalle
];

$json = json_encode($data);
echo $json;
