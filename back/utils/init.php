<?php
// Role ------------------------------------------ 
    // parametre l'affichage des erreurs
    // connexion à la base de donnée via PDO
    // charge le modele (classe) générique
    // charge les modeles (classes) specifiques
// -----------------------------------------------

// affichage des erreurs
ini_set("display_errors", 1);       // Aficher les erreurs
error_reporting(E_ALL);             // Toutes les erreurs

// connexion base avec PDO
global $bdd;
$bdd = new PDO("mysql:host=localhost;dbname=projets_concert_mcastellano;charset=UTF8", "mcastellano", "c8?kpn?s2q+Z");

// Charger les librairies diverses
include_once "utils/model.php";
include_once "modeles/personnage.php";
include_once "utils/session.php";
// Activer le mécanisme de session
session_activation();

// Pour debugger, on peut ajouter une propriété
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

// Charger les objets du mdèle de données
include_once "modeles/evenement.php";
