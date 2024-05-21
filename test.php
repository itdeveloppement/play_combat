<?php 
// role : test de la fonction
 // initialisation
 include "utils/init.php";

 $session = new session ();
 $session->connect(17);

 // print_r($_SESSION);
 // instance
 $personnage = new personnage(15);
 // $mvt = new evenement();
 
// recuperation liste des personnage dans une salle
//$personnage->listePersonnagesSalle();

// historique des mouvement d'un d'un personnage
// $id=1;
// print_r($histoEvent->histoEvents($id));


// $personnage->reculer () ;

// print_r($personnage->identifiantValide("x"));

//$idSallle = 1;
//print_r ($personnage->listePersonnagesSalle ($idSallle)); 

$idSubirAttaque=17;
$personnage->subirAttaque($idSubirAttaque);