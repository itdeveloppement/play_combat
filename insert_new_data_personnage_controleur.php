<?php

/**
 * Role : inserer les données en bdd
 * ajouter automatiquement 100 points de vie
 * affiche la page de connaexion
 * 
 * Parm : POST
    * non du persopnnage
    * nombre de point de force
    * nombre de point d'agilité
    * nombre de point de resistance
    * pseudo
* password
 */

 // Initialisation
require_once "utils/init.php";

print_r($_POST);
 // initialisation
 include "templates/pages/form_connexion_view.php";