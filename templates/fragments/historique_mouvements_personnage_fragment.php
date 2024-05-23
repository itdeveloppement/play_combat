<?php
/**
 * fragment de page : mise en forme de l'historique des mouvements d'un personnage
 * param : * parm : tableau d'objet de l'historique du personnage
 */
?>

<!-- historique des evenement du personnage -->
<table>
    <thead>
        <tr>
            <th>Evenement</th>
            <th>Salle atteinte</th>
            <th>Adverssaire</th>
            <th>Points de vie</th>
            <th>Points de force</th>
            <th>Points d'agilité</th>
            <th>Points de résistance</th>
        </tr>
    </thead>
        <tbody id="zoneHistorique">
            <?php foreach ($histoEvents as $Value) {
        echo "<tr>";
            echo "<td>" . $Value['evenement'] ."</td>";
            echo "<td>" . $Value['salle'] ."</td>";
            echo "<td>" . $Value['adversaire'] ."</td>";
            echo "<td>" . $Value['pts_vie'] ."</td>";
            echo "<td>" . $Value['pts_force'] ."</td>";
            echo "<td>" . $Value['pts_agilite'] ."</td>";
            echo "<td>" . $Value['pts_resistance'] ."</td>";
        echo "</tr>";
    } ?>   
        </tbody>
</table>