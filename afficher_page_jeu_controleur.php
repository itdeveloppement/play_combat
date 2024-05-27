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

// si deja connecté
if  ($session->isConnected()) {

    $personnage = new personnage($session->getIdConnected());

    // verification si personnage vivant
    if ($personnage->isDead()) {
        $session->deconnect();
        include "templates/pages/page_message_isdead.php";
        exit;
    }

    // afficher liste des personnes dans une salle
    $personnage->load($session->getIdConnected());
    $listePersonnagesSalle = $personnage->listePersonnagesSalle($personnage->get("salle"));

    // afficher histroique du personnage
    $histoEvents = $personnage->histoEvenements();

    include "templates/pages/page_jeu_view.php";
    exit;

} else if ((isset($_POST["log"]) && isset($_POST["password"]))) {

    /*
    if (! $personnage->connexionValide ($log, $password)) {
    include "templates/pages/form_connexion_view.php";
    exit;
    } 
    */

    // recuperation et controle des données POST
    $log = $_POST["log"];
    $password = $_POST["password"];
    
    // validation de la connexion et rensegnement session id
    $personnage = new personnage();
    $personnage->connexionValide ($log, $password);

    // instenciation du personnage en cours
    $personnage = new personnage($session->getIdConnected());
   
    // verification si personnage vivant
    if ($personnage->isDead()) {
        $session->deconnect();
        include "templates/pages/page_message_isdead.php";
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