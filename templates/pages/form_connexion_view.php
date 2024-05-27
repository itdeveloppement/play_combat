<?php

/**
 * Role : met en forme le formulaire de connexion
 * Parm : neant
 */

 // Fragment de page : entete
include "templates/fragments/head_fragment.php";
?>
<body>
        <main class="formConnexion mainImgS0">
                <section>
                    <h2>Créer un compte</h2>
                    <button><a href="afficher_form_insert_personnage_controleur.php">Créer un personnage</a></button>
                </section>
                <section>
                    <h2>Se connecter</h2>
                    <form method="post" action="afficher_page_jeu_controleur.php">
                        <div>
                            <label for="log">Identifiant</label>
                            <input type="text" name="log" id="log">
                        </div>
                        <div >
                            <label for="password">Mot de passe</label>
                            <input type="text" name="password" id="password">
                        </div>
                        <input type="submit" value="Connectez-vous et jouer">
                    </form>
                </section>
        </main>
    </body>
<?php
// Fragment de page : footer
include "templates/fragments/footer_fragment.php";
?>