<?php

/*
Fonctions de gestion de la session

On a une superglobale $_SESSION (on en fait un tableau)
   - quand PHP est fini : elle est enregistrée
   - quand on lance session_start (un controleur) : elle est restaurée

   On va gérer cette varaible de la manière suivante :
    - l'index id contiendra 0 (ou n'existera pas) quand aucun utilisateur n'est connecté
    - si un utilisateur est connecté $_SESSION["id"] contient l'id de l'utilisateur

    quand un utilisateur est connecté, 
        on va stocker l'objet associé dans la variable globale $utilisateurConnecte
*/

function session_activation() {
    // Rôle : acrtive le mécanisme de session
    // paramètres : néant
    // retour : true si on est connecté, false sinon

    // démarrer le maécanisme
    session_start();

    // Si un utilisateur est connecté :
    if (session_isconnected()) {
        //   - charger l'objet utilisateur connecté 
        global $utilisateurConnecte;
        $utilisateurConnecte = new personnage(session_idconnected());
        //   - vérifier qu'il est actif, encore autorisé, etc....
        // ....
    }

    // Retourner si on est connecté ou pas
    return session_isconnected();

}

function session_isconnected() {
    // Rôle : dire si il y a une connexion active ou pas
    // Paramètres : néant
    // Retour : true si on est connecté, false sinon

    return ! empty($_SESSION["id"]);
}

 function session_idconnected() {
    // Rôle : donné l'id de l'utilisateur connexté
    // Paramètres : néant
    // Retour : l'id ou 0

    if (session_isconnected()) {
        return $_SESSION["id"];
    } else {
        return 0;
    }
 }

 function session_userconnected() {
    // Rôle : donné l'objet correspondant à l'utilisateur connecté
    // Paramètres : néant
    // Retour : un objet de la calsse qui gère les utilisateurs de l'appli

    if (session_isconnected()) {
        global $utilisateurConnecte;
        return $utilisateurConnecte;
    } else {
        return new personnage();
    }
 }

 function session_deconnect() {
    // Rôle : déconnecter la session courante
    // paramètres : néant
    // Retour : true

    $_SESSION["id"] = 0;
 }

 function session_connect($id) {
    // Rôle : connecter un utilisateur
    // paramètres :
    //      $id : id de l'utilisateur connecté
    // Retour : true

    $_SESSION["id"] = $id;
 }

