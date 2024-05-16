<?php 
// role : test de la fonction
 // initialisation
 include "utils/init.php";

 // instance
 $personnage = new personnage(1);
 $mvt = new evenement();
 
// recuperation liste des personnage dans une salle
//$personnage->listePersonnagesSalle();

// historique des mouvement d'un d'un personnage
$id=1;
// print_r($histoEvent->histoEvents($id));


$personnage->reculer () ;