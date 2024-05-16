<?php
/**
 * template de page : liste des personnages dans la salle
 * param : tableau de la liste des personnages dans une salle
 */
?>
<div class= "flex">
   <?php foreach ($listePersonnagesSalle as $key => $value){
      echo "<button><a href='js/attaquer_personnage.js'>Attaquer " . $value . "</a></button>";
   }
   ?> 
</div>