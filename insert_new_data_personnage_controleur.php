<?php

/**
 * Role : inserer les données en bdd
 * ajouter automatiquement 100 points de vie
 * affiche la page de connaexion
 * Parm : POST
    * non du persopnnage
    * pseudo du personnage
    * nombre de point de force
    * nombre de point d'agilité
    * nombre de point de resistance
    * password du personnage
 */

 // verification de la connexion
if ( ! $session->isConnected()) {
    include "templates/pages/form_connexion_view.php";
    exit;
}

 // Initialisation
require_once "utils/init.php";
if (
    ! empty($_POST["nom"]) && 
    ! empty($_POST["pseudo"]) && 
    ! empty ($_POST["pts_force"]) &&
    ! empty ($_POST["pts_agilite"]) &&
    ! empty ($_POST["pts_resistance"]) &&
    ! empty ($_POST["password"])
    ){
    /*
    print_r($_POST);
    $non = $_POST["nom"];
    $pseudo = $_POST["pseudo"];
    $force = $_POST["pts_force"];
    $agilite = $_POST["pts_agilite"];
    $resistance = $_POST["pts_resistance"];
    $log = $_POST["pseudo"];
    $password = $_POST["password"];
    */
    } else {
        include "afficher_form_insert_personnage_controleur.php";
        exit;
    }

// preparation des données
$_POST["created_date"] =  date("Y-m-d H:i:s");
unset($_POST["passwordConf"]);
$_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
$_POST["pts_vie"] = 100;
$_POST["salle"] = 0;

// insertion des données
$personnage = new personnage();
if ($personnage->loadFromTab($_POST)){
    $personnage->insert();
    include "templates/pages/form_connexion_view.php";
} else {
    include "afficher_form_insert_personnage_controleur.php";
        exit;
}

