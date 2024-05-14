<?php
// NOTION : affichage des erreur  ----------------------------------------
    // parametre l'affichage des erreurs
    // connexion à la base de donnée via PDO
    // charge le modele (classe) générique
    // charge les modeles (classes) specifiques
// ---------------------------------------------

// affichage des erreurs
ini_set("display_errors", 1);       // Aficher les erreurs
error_reporting(E_ALL);             // Toutes les erreurs

/* NOTION : exception --------------------------
Exception (condition exceptionnelle) : une exception est utilisée pour signaler une anomalie ou une erreur qui se produit pendant l'exécution d'un script.
Lever une exception : sigaler une anomalie, créer un objet exception et le transmettre au bloc catch. D'une magniere générale en appliquant la classe throw dans le try l'exception est lever et transmise au bloc catch.
Avec PDO la lever et la transmission de l'exception se fait sans appeller manuellmeent throw si le mode de gestion des erreurs approprié à l'aide de setAttribute()avec PDO::ATTR_ERRMODE est definie.
Le code dans le catch est executé ce qui permet de traiter l'exeption (affichage d'un message, enregistement des information de debugage, ou d'aures actions pour traiter les exceptions)
Si aucun catch n'est trouvé il se produit une erreur fatale

$exception->getMessage() : retourne le messssage associé
$exception-getCode() : retourne le code du message d'erreur
(voir sur mdn les autres retours possibles)
*/

/* connexion à la BDD
    ouvrir la base de donnée avec PDO dans la variable globale
    lever les exeptions avce PDO 
    Entrée dans le catch executer avec Throwable et executer un code si une exception est detecté
*/
global $bdd;
try { 
$bdd = new PDO("mysql:host=localhost;dbname=projets_combat_mcastellano;charset=UTF8", "mcastellano", "c8?kpn?s2q+Z");
} catch (Throwable $exception) {
    echo "Une erreur a été rencontrée lors de la connexion à la BDD. Message : " . $exception->getMessage() . "Code message : " . $exception->getCode();
} 

// definition des modes de gesion des erreur aec PDO
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

/* NOTION "auto chargement des classes" ----------------------------------
Objectif : charger les classes sans avoir à les inclure une apres l'autre manuellement
Methode : si une classe PHP rencontre une classenon denfnini il appel une fonction de chargement de la classe
- spl_autoload_register(autoloadClasses()) : enrgiste et appel la fonction autoloadClasses() pour le chargement automatique de la classe
- autoloadClasses() : 
    - charge la classe modele , sinon la classe nomée si elle existe.
    - si la classe existe on peut effectuier d'autre traitement (vérifications supplémentaires ou des initialisations spécifiques à la classe. A preciser)
*/

/**
 * Role : trouver la classe et la charger
 * @param {objet} $class : nom de la classe
 * @return : neant
 */
function autoloadClasses ($class) {
    if ($class == "_model") {
        include_once "utils/model.php" ;
     }
     else if (file_exists("modeles/$class.php")) {
         include_once "modeles/$class.php";
     } 
     if (class_exists($class)) {
         // code à preciser si necessaire
         // echo "la classe existe";
     }
}

// initialisatiion du chargement automatique de la classe
spl_autoload_register("autoloadClasses");

// insertion des librairie diverse
include_once "utils/session.php";
// Activer le mécanisme de session
$session = new session();
$session->activation();

