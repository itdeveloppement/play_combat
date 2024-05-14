<?php
// Template de page : page du jeu
// Paramètres : neant

// Fragment de page : en tête
include "templates/fragments/head_fragment.php";
?>

<body>
    <header>

    </header>
    <main >
        <h1>Le grand combat</h1>
        <!-- salle -->
        <p>Nom de la salle</p>

        <!-- caracteristique du personnage -->
        <h2>Carcateristiques du personnage</h2>
        <?php include "templates/fragments/caracteristiques_personnage_fragment.php"; ?>

        <!-- liste des personnage dans la salle-->
        <h2>Liste des personnages dans la salle</h2>
        <?php include "templates/fragments/liste_personnages_salle_fragment.php"; ?>

        <!-- historique des mouvement -->
        <h2>Historique de mes mouvements</h2>
        <?php include "templates/fragments/historique_mouvements_personnage_fragment.php"; ?>
        <!-- les actons possibles-->
        <h2>Les actions possibles</h2>

    </main>
</body>

<?php
// Fragment de page : footer
include "templates/fragments/footer_fragment.php";
?>