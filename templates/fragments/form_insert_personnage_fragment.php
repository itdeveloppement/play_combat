<?php
/*
Fragment de page : formulaire de creation d'un formulaire personnage
Paramètres : neant
*/
?>

<form class="form_profil" action="insert_new_data_personnage_controleur.php" method="POST">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" >
    </div>
    <div>
        <label for="force">Points de force :</label>
        <input type="range" id="force" name="force" min="0" max="15" value="0">
    </div>
    <div>
        <label for="agilite">Points d'agilite :</label>
        <input type="range" id="agilite" name="agilite" min="0" max="15" value="0">
    </div>
    <div>
        <label for="resistance">Points de resistance :</label>
        <input type="range" id="resistance" name="resistance" min="0" max="15" value="0">
    </div>
    
    <div>
        <label for="log">Créer un identifiant :</label>
        <input type="text" name="log" placeholder="Identifiant" required>
    </div>
    <div classe="flex">
        <label for="password">Créer un mot de passe :</label>
        <input id="createPasswordInput" type="password" name="password" placeholder="Mot de passe"required>
        <div>
            <img id="createPassword" src="images/icons/oeil_ouvert.png" alt="Oeil pour faire apparaitre le mot de passe">
        </div>
    </div>
    <div>
        <label for="passwordConf">Confirmer votre mot de passe :</label>
        <div>
            <input id="confPasswordInput" type="password" name="passwordConf" placeholder="Confirmer mot de passe" required>
        </div>
    </div>
    <input type="submit" value="Créer votre personnage">
</form>