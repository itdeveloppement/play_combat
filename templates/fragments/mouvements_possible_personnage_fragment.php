<?php
/**
 * template de page : mise en forme des mouvement possible pour un personnage
 * param : neant
 */
?>

<div id="boutonAction" >
    <!-- affciher avec fonction js boutonAction() -->
    <?php if ($personnage->get("salle")>0){ 
    echo '<button id="btnReculer">Retour</button>';
    } ?> 
    <button id="btnForce">Transformer force en resistance</button>
    <button id="btnResistance"></a>Transformer resistance en force</button> 
    <?php if ($personnage->get("salle")<11){ 
    echo '<button id="btnAvancer">Avancer</button>';
    } ?>
</div>
