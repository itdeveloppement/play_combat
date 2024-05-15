<?php

/**
 * classe : personnage 
 * role : gestion des objet personnage
 */
class personnage extends _model {

 // attributs
 protected $table = "personnage";
 protected $fields = [
    "nom",
    "pseudo",
    "password",
    "pts_vie",
    "pts_force",
    "pts_agilite",
    "pts_resistance",
    "salle",
    "created_date",
    "updated_date"
 ];

 // lien objet
 protected $links = ["evenement" => "evenement"];

/**
      * Rôle : verifie le login et le password de connexion d'un utilisateur
      * @param {string} $log: la valeur de l'identifiant de connexion passé en POST
      * @param {string} $password : la valeur du password passé en POST
      * @return true si connecté , sinon return false 
      */
      function connexionValide ($log, $password) {
        $listePersonnages = $this->listAll();
        foreach ($listePersonnages as $personnage => $values) {
            $logPersonnage = $values->get("pseudo");
            $passwordPersonnage = $values->get("password");
            // vrification concordance
            if (($logPersonnage===$log) && ( $passwordPersonnage ===$password)) {
                $session = new session();
                $session->connect($personnage);
                return true;
            }   
        }
        return false;
    }
}

/**
 * role : récuperer la liste des personnages presnet dans la salle
 * @param : 
 */
