<?php
// Template de page : page du jeu
// Paramètres : neant

// Fragment de page : en tête
include "templates/fragments/head_fragment.php";
?>
<body>
    <header>
        <button><a href="deconnexion_controleur.php">Quitter la partie</a></button>
        <button><a href="afficher_regles_jeu.php">Regles du jeu</a></button>
    </header>
    <main>
        <h1 >Le grand combat</h1>
        <!-- salle -->
        <p>Salle numéro : <span id="salle"><?= $personnage->get("salle"); ?></span></p>

        <!-- caracteristique du personnage -->
        <h2>Carcateristiques du personnage</h2>
        <?php include "templates/fragments/caracteristiques_personnage_fragment.php"; ?>

        <!-- liste des personnage dans la salle-->
        <h2>Liste des personnages dans la salle</h2>
        <?php include "templates/fragments/liste_personnages_salle_fragment.php"; ?>

        <!-- historique des mouvement -->
        <h2>Historique des mouvements</h2>
        <?php include "templates/fragments/historique_mouvements_personnage_fragment.php"; ?>

        <!-- les actions possibles-->
        <h2>Les actions possibles</h2>
        <?php include "templates/fragments/mouvements_possible_personnage_fragment.php"; ?>
    </main>
</body>
<script src="js/app.js" defer></script>
<?php
include "templates/fragments/footer_fragment.php";
?>