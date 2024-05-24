<?php

/**
 * Role : 
 * - affiche la page de jeu en fonction du statut de connexion (connecté ou pas)
 * Parm : POST
 *  $log : le log de connexion
 *  $pasword : le password de la connexion
 */

// Initialisation
require_once "utils/init.php";

if  ($session->isConnected()) {

    // liste des personnes dans une salle
    $personnage = new personnage();
    $personnage->load($session->getIdConnected());
    $listePersonnagesSalle = $personnage->listePersonnagesSalle($personnage->get("salle"));

    // histroique du personnage
    $histoEvents = $personnage->histoEvenements();

    include "templates/pages/page_jeu_view.php";
    exit;

} else if ((isset($_POST["log"]) && isset($_POST["password"]))) {

    // recuperation et controle des données POST
        $log = $_POST["log"];
        $password = $_POST["password"];
    
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
    exit;

} else {
    include "templates/pages/form_connexion_view.php";
    exit;
}