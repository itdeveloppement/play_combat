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


// --------------------- PASSWORD LOGIN -------------------------------
/**
 * Rôle : verifie le login et le password de connexion d'un utilisateur
* @param {string} $log: la valeur de l'identifiant de connexion passé en POST
* @param {string} $password : la valeur du password passé en POST
* @return true si connecté , sinon return false 
*/
public function connexionValide ($log, $password) {
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

// --------------------- LISTE PERSONNAGE DANS UNE SALLLE -------------------------------

/**
 * role : récuperer la liste des personnages present dans la salle
 * @param : le numero de la salle
 * @return : le tableau des nom des personnage indexé par l'id du personnage
 */
 public function listePersonnagesSalle ($idSallle) {
    // interogation bdd
    $sql = "SELECT `id`, `nom` FROM `$this->table` WHERE `salle` = :id "; 
   
    $param = [ ":id" => $idSallle];

    // Préparer / exécuter
    global $bdd;
    $req = $bdd->prepare($sql);
    if ( ! $req->execute($param)) {
        return false;
    }

    $listePersonnages = $req->fetchAll(PDO::FETCH_ASSOC);
    // construction tableau indexé par l'id des personnages et supression du personnage current
    $listePerso = [];
    foreach ($listePersonnages as $value){
        if ($value["id"] != $this->id() ) {
        $listePerso [$value["id"]] = $value["nom"];
        }
    }
    return $listePerso;
}

// --------------------- HISTORIQUE MVT -------------------------------
/**
 * role : retourner l'historique des 15 derniers evenement du personnage current
 * @param : neant
 * @return : le tableau des cararacteristiques des mouvement realisés : 
 */
public function histoEvenements(){
    $historique = new evenement();
    return $historique->histoEvents($this->id());
}

// --------------------- AVANCER ---------------------------------------

/**
 * Role faire avancer le personnage dans une salle
 * @param : neant
 * @return : true si deplacement realisé, sinon false
 */
public function avancer(){
    if ($this->verifMvtAvancer ()) {
        $this->updateCaracteristiquesPersoAvancer ();
        // insert mouvement avancer
        $mvt = new evenement();
        $mvt->insertMvtAvancer($this->id(),  $this->values["salle"]);
    return true;
    }
    return false;
}

/**
 * Role verifier si le deplacement est possible
 * Condition : avoir au moins autant de points d'agilite que le numero de la salle a atteindre
 * @param : neant
 * @return : true si deplacement realisé, sinon false
 */
public function verifMvtAvancer(){
    if ($this->values["pts_agilite"] > $this->values["salle"]) {
      return true; 
    }
    return false;
}

/**
 * Role modifir les caracteristique du personnage quand il avance
 * @param : neant
 * @return : true si modif realisé, sinon false
 */
public function updateCaracteristiquesPersoAvancer(){
    $ptsAgilite = $this->values["pts_agilite"] - ($this->values["salle"]+1) ;
    $this->set("salle", ($this->values["salle"]+1));
    $this->set("pts_agilite",$ptsAgilite);
    if ($this->update()){
        return true;
    }
    return false;
}

// --------------------- RECULER ---------------------------------------

/**
 * Role faire reculer le personnage dans une salle
 * @param : numero de la piece à attiendre
 * @return : true si deplacement realisé
 */
public function reculer(){
    $this->updateCaracteristiquesPersoReculer();
    // insert mouvement avancer
    $mvt = new evenement();
    if ($mvt->insertMvtReculer($this->id(), $this->values["salle"])) {
        return true;
    }
    return false;
}

/**
 * Role modifir les caracteristiques du personnage quand il recule
 * @param : neant
 * @return : true si modif realisé, sinon false
 */
public function updateCaracteristiquesPersoReculer(){
    $ptVie = ($this->values["salle"]-1) + $this->values["pts_vie"];
    $this->set("salle", ($this->values["salle"]-1));
    $this->set("pts_vie",$ptVie);
    if ($this->update()){
        return true;
    }
    return false;
}


// --------------------- TRANSFORMER POINTS ---------------------------------------
 
/**
 * Role transforme un point de force en un point de resistance
 * consoome trois point d'agilité. Impossible de dépasser 15 points de force
 * @param : neant
 * @return : true si modif realisé, sinon false
 */
public function transformerForce() {

}

}