<?php
// page : affichage du message si le personnage est mort
// Paramètres : neant

// Fragment de page : en tête
include "templates/fragments/head_fragment.php";
?>
<body>
    <main class="mainImgS0">
        <h2>Vous êtes mort !</h2>
        <p>Pour rejouer vous devez recréer un personnage</p>
        <button><a href="deconnexion_controleur.php">Quitter ou rejouer</a></button>
    </main>
</body>
<script src="js/form_insert_personnage_controleur.js" defer></script>
<?php
// Fragment de page : footer
include "templates/fragments/footer_fragment.php";
?>