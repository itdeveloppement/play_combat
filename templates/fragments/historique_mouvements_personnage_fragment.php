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
            <th>Mouvement</th>
            <th>Action</th>
            <th>Salle</th>
            <th>Adverssaire</th>
            <th>Points de vie</th>
            <th>Points de force</th>
            <th>Points d'agilité</th>
            <th>Points de résistance</th>
        </tr>
    </thead>
        <tbody>
            <?php foreach ($histoEvents as $Value) {
        echo "<tr>";
            echo "<td>" . $Value['mouvement'] ."</td>";
            echo "<td>" . $Value['action'] ."</td>";
            echo "<td>" . $Value['salle'] ."</td>";
            echo "<td>" . $Value['adverssaire'] ."</td>";
            echo "<td>" . $Value['pts_vie'] ."</td>";
            echo "<td>" . $Value['pts_force'] ."</td>";
            echo "<td>" . $Value['pts_agilite'] ."</td>";
            echo "<td>" . $Value['pts_resistance'] ."</td>";
        echo "</tr>";
    } ?>   
        </tbody>
</table>