<?php
// Template de page : formulaire d'ajout d'un personnage
// Paramètres : neant

// Fragment de page : en tête
include "templates/fragments/head_fragment.php";
?>
<body>
    <header>
        <button><a href="afficher_form_connexion_controleur.php">Quitter</a></button>
    </header>
    <main >
        <h2>Créer votre personnage</h2>
        <div>
            <?php include "templates/fragments/form_insert_personnage_fragment.php"; ?>
        </div>
        <div>
            <h2>Répartition des points</h2>
            <p>Tu dois répartir 15 points de vie pour : </p>
            <ul>
                <li>la force qui est utilisée lors les attaques</li>
                <li>l'agilité qui est utilisé lors des déplacements et des esquives</li>
                <li>la résistance qui est utilisé pour ce défendre</li>
            </ul>
            <p>Tu ne peux pas affecter plus de 10 points à une caracteristique de ton personnage</p>
            <p>100 points de vie sont automatiquement afféctés à ton personnage</p>
        </div>
    </main>
</body>

<?php
// Fragment de page : footer
include "templates/fragments/footer_fragment.php";
?>