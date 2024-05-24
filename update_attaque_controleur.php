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
if ( ! $session->isConnected()) {
    include "templates/pages/form_connexion_view.php";
    exit;
}

// verification donnée GET
if (! empty ($_GET)) {
    $idAdversaire = $_GET['id'];
} else {
    include "templates/pages/form_connexion_view.php";
    exit;
}
// print_r( $idAdversaire);
// subir une attaque
$personnage = new personnage($session->getIdConnected()); 
$personnage->subirAttaque($idAdversaire);


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
