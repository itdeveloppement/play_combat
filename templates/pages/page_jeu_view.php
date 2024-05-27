<?php
// Template de page : page du jeu
// Paramètres : neant

// Fragment de page : en tête
include "templates/fragments/head_fragment.php";
?>
<body>
    <header class="flex justifyBetewen">
        <h1>Le grand combat</h1>
        <p>Salle numéro : <span id="salle"><?= $personnage->get("salle"); ?></span></p>
        <nav>
            <ul class="flex">
                <li><a href="deconnexion_controleur.php">Quitter la partie</a></li>
                <li><a href="afficher_regles_jeu.php">Regles du jeu</a></li>
            </ul>
        </nav>  
    </header>
    <main> 
        <div class = "container-1200">
            <div class = "flex justifyBetewen">
                <!-- caracteristique du personnage -->
                <section>
                    <h2>Carcateristiques du personnage</h2>
                    <?php include "templates/fragments/caracteristiques_personnage_fragment.php"; ?>
                </section>
                <!-- liste des personnage dans la salle-->
                <section>
                    <h2>Liste des personnages dans la salle</h2>
                    <?php include "templates/fragments/liste_personnages_salle_fragment.php"; ?>
                </section>
            </div>
            <!-- historique des mouvement -->
            <section>
                <h2>Historique des mouvements</h2>
                <?php include "templates/fragments/historique_mouvements_personnage_fragment.php"; ?>
            </section>

            <!-- les actions possibles-->
            <section>
                <h2>Les actions possibles</h2>
                <?php include "templates/fragments/mouvements_possible_personnage_fragment.php"; ?>
            </section>
        </div>  
    </main>
</body>
<script src="js/app.js" defer></script>
<?php
include "templates/fragments/footer_fragment.php";
?>