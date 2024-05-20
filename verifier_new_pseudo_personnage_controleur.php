<?php

/**
 * Role : vérifier si le pseudo est unique
 * Parm : peseudo
 */

 // Initialisation
require_once "utils/init.php";

// verifier le peseudo
if(! isset($_GET["idt"])) {
    include "afficher_form_insert_personnage_controleur.php";
    exit; 
} else {  
    $idt = $_GET["idt"];

}

$personnage=new personnage();
// verification unicité identifiant
$result = $personnage->identifiantValide($idt);
$response = json_encode($result);
echo $response;