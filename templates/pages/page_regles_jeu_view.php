<?php
// Template de page : page du jeu
// Paramètres : neant
// Fragment de page : en tête
include "templates/fragments/head_fragment.php";
?>
<body>
    <main >
    <button><a href="afficher_page_jeu_controleur.php">Retourner jouer</a></button>
        <h2>Le Grand combat, les régles du jeu</h2>
        <!-- salle -->
        <h3>But du jeu</h3>
        <p>L'objectif est de parcourir les dix salles pour atteindre la sortie vivant. Tu peux avancer, reculer, attaquer un autre personnage qui se trouve avec toi dans la salle, et te faire attaquer</p>
        <h3>Les differentes salles</h3>
        <p>Dans la premiere salle, c'est l'entrée. Tu ne vois pas les autre joueurs, tu ne peux pas etre attaqué ni attaquer. Dans les autres salles tu vois tous les joueurs present, tu peux attaquer, etre attaqué, avancer ou retourner de la salle d'ou tu viens. Une fois la zone de sortie atteinte tu as gagné</p>
        <h3>Avancer</h3>
        <p>Un déplacement vers l'avant (dans la pièce suivante ou la zone de sortie) consomme des points d'agilité : il te faut autant de points d'agilité que le numéro de la pièce qui s'affiche, et 10 points pour passer dans la zone de sortie. Si tu n'a pas assez de points d'agilité, tu n'as pas accès à la pièce suivante</p>
        <h3>Retour</h3>
        <p>Un déplacement vers l'arrière (dans la pièce précédente ou la zone d'entrée) est toujours possible et ne consomme pas de points d'agilité. Tu peux le faire même avec zéro point d'agilité. Tu gagne alors en points de vie le numéro de la pièce atteinte.</p>
        <h3>Rester</h3>
        <p>Si on reste dans une pièce sans rien faire (sans attaquer) pendant 3 secondes, on récupère 1 point d'agilité. Cela ne s'applique pas à la zone d'entrée. Attention : les points d'agilité sont plafonnés à 15 !</p>
        <h3>Attaquer</h3>
        <p>Attaquer ou etre attaquer peux te faire gagner ou perdre des points de vie, de force, d'agilité et de resitance</p>
        <h3>Transformer des points de force ou de resistance</h3>
        <p>Tu peux transformer un point de force en point de résistance, ou réciproquement, sela consomme 3 points d’agilité. Cela ne permet pas de dépasser 15 points de force ou 15 points de résistance.</p>
    </main>
</body>
<?php
// Fragment de page : footer
include "templates/fragments/footer_fragment.php";
?>