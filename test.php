<?php 
// role : test de la fonction
 // initialisation
 include "utils/init.php";

 $session = new session ();
 $session->connect(15);

 $personnage = new personnage(15);
 

$idAdversaire=19;

// $personnage->defendreRiposte ($idSubirAttaque);
// $personnage->esquiver ($idAdversaire);
// $personnage->defendre ($idAdversaire);
// $personnage->defendreRiposte ($idAdversaire);
// $personnage->esquiverRiposte ($idAdversaire);
// $personnage->riposte ($idAdversaire);
// $personnage->subirAttaqueRiposte ($idAdversaire);
$personnage->subirAttaque($idAdversaire);