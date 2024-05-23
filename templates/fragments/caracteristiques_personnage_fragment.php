<?php

/**
 * Fragment de page : mise en forme des caracteristiques du personnage
 * parm : tableau d'objet des cracateristiques du personnage
 * 
 */
 ?>

<p>Nom : <?= $personnage->get("nom") ?></p>
<div class="flex">
    <label for="ptsVie">Points de vie : </label>
    <p id="ptsVie"><?= $personnage->get("pts_vie"); ?></p>
</div>
<div class="flex">
    <label for="ptsForce">Points de force : </label>
    <progress id="ptsForce" value="<?= $personnage->get("pts_force"); ?>" max="15"></progress>
    <p id="ptsForce2"><?= $personnage->get("pts_force"); ?></p>
</div>
<div class="flex">
    <label for="ptsAgilité">Points d'agilité : </label>
    <progress id="ptsAgilite" value="<?= $personnage->get("pts_agilite"); ?>" max="15"></progress>
    <p id="ptsAgilite2"><?= $personnage->get("pts_agilite"); ?></p>
</div>
<div class="flex">
    <label for="ptsResistance">Points de résistance : </label>
    <progress id="ptsResistance" value="<?= $personnage->get("pts_resistance"); ?>" max="15"></progress>
    <p id="ptsResistance2"><?= $personnage->get("pts_resistance"); ?></p>
</div>