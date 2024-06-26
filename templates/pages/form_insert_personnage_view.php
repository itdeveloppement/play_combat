<?php
// Template de page : formulaire d'ajout d'un personnage
// Paramètres : neant

// Fragment de page : en tête
include "templates/fragments/head_fragment.php";
?>
<body>
    <main class="formInsertPerso mainImgS0" >
    <button><a href="afficher_page_jeu_controleur.php">Quitter</a></button>
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
            <p>Tu ne peux pas affecter moins de 3 poits ou plus de 10 points à une caracteristique de ton personnage</p>
            <p>100 points de vie sont automatiquement afféctés à ton personnage</p>
        </div>
    </main>
</body>
<script src="js/form_insert_personnage_controleur.js" defer></script>
<?php
// Fragment de page : footer
include "templates/fragments/footer_fragment.php";
?>