<?php

/**
 * Fragment de page : mise en forme des caracteristiques du personnage
 * parm : tableau d'objet des cracateristiques du personnage
 * 
 */
 ?>

<p>Nom : <?= $utilisateurConnecte->get("nom") ?></p>
<div>
    <label for="ptsVie">Points de vie : </label>
    <progress id="ptsVie" value="<?= $utilisateurConnecte->get("pts_vie"); ?>" max="100"></progress>
</div>
<div>
    <label for="ptsForce">Points de force : </label>
    <progress id="ptsForce" value="<?= $utilisateurConnecte->get("pts_force"); ?>" max="15"></progress>
</div>
<div>
    <label for="ptsAgilité">Points d'agilité : </label>
    <progress id="ptsAgilite" value="<?= $utilisateurConnecte->get("pts_agilite"); ?>" max="15"></progress>
</div>
<div>
    <label for="ptsResistance">Points de résistance : </label>
    <progress id="ptsResistance" value="<?= $utilisateurConnecte->get("pts_resistance"); ?>" max="15"></progress>
</div>
