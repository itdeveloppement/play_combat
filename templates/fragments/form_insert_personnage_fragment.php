<?php
/*
Fragment de page : formulaire de creation d'un formulaire personnage
Paramètres : 
*/
?>

<form class="form_profil" action="insert_personnage_controleur.php" method="POST">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" >
    </div>
    <div>
        <label for="force">Points de force :</label>
        <input type="number" name="force">
    </div>
    <div>
        <label for="agilite">Points d'agilite' :</label>
        <input type="number" name="agilite">
    </div>
    <div>
        <label for="resistance">Points de resistance :</label>
        <input type="number" name="resistance">
    </div>
    
    <div>
        <label for="log">Créer un identifiant :</label>
        <input type="text" name="log">
    </div>
    <div>
        <label for="password">Créer un mot de passe :</label>
        <input type="text" name="password">
    </div>
    <input type="submit" value="Ajouter">
</form>