<?php 


// role : test de la fonction
 // initialisation
 include "utils/init.php";

 $session = new session ();
 $session->connect(17);

$personnage = new personnage(17);
 
/*
$idAdversaire=17;

// print($personnage->defendreRiposte ($idAdversaire));
// print($personnage->esquiver ($idAdversaire));
// print($personnage->defendre ($idAdversaire));

// print($personnage->esquiverRiposte ($idAdversaire));
// print($personnage->riposte ($idAdversaire));

// print($personnage->defendreRiposte ($idAdversaire));
// print($personnage->subirAttaqueRiposte ($idAdversaire));

print($personnage->subirAttaque($idAdversaire));

// include "templates/pages/test_affichage.php";


*/

// print_r($personnage->isDead())
?>


