<?php

/**
 * Role : 
 * - vérifier les données de connexion
 * - instancier la saison
 * - affiche la page du jeu dans la salle ou se situe la personnage
 * Parm : neant
 */

// Initialisation
require_once "utils/init.php";

// controle et recuperation des données 
if (((! empty($_POST["log"])) && (! empty($_POST["password"]))) && ((isset($_POST["log"])&&(isset($_POST["password"]))))) {
    $log = $_POST["log"];
    $password = $_POST["password"];
} else {
    include "templates/pages/form_connexion_view.php";
    exit;
}
// validation connexion et rensgnement session id
$personnage = new personnage();
if (! $personnage->connexionValide ($log, $password)) {
   include "templates/pages/form_connexion_view.php";
    exit;
} 

include "templates/pages/page_jeu_view.php";

