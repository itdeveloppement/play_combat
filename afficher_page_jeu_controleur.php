<?php

/**
 * Role : 
 * - vérifier les données de connexion
 * - instancier la saison
 * - affiche la page du jeu dans la salle ou se situe la personnage
 * Parm : POST
 *  $log : le log de connexion
 *  $pasword : le password de la connexion
 */

// Initialisation
require_once "utils/init.php";

// recuperation et controle des données POST
if (! empty($_POST["log"]) && ! empty($_POST["password"])) {
    $log = $_POST["log"];
    $password = $_POST["password"];
} else {
    include "templates/pages/form_connexion_view.php";
    exit;
}

// validation de la connexion et rensegnement session id
$personnage = new personnage();
if (! $personnage->connexionValide ($log, $password)) {
   include "templates/pages/form_connexion_view.php";
   exit;
} 

// liste des personnes dans une salle
$personnage->load($session->getIdConnected());
$listePersonnagesSalle = $personnage->listePersonnagesSalle($personnage->get("salle"));

// histroique du personnage
$histoEvents = $personnage->histoEvenements();

//actions possible

include "templates/pages/page_jeu_view.php";

