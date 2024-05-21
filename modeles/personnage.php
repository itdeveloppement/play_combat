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
        if (($logPersonnage==$log) && (password_verify($password, $passwordPersonnage))) {
            $session = new session();
            $session->connect($personnage);
            return true;
        }   
    }
    return false;
    }

// ---------------------- IDENTIFIANT ------------------------------------
/**
 * Role : compare l'identifiant en creation aux identifiants de ala base
 * @param : l'identifiant en création
 * @return : true si different, false sinon
 */
public function identifiantValide ($identifiant) {
    $listAllPersonnage = $this->listAll();
    foreach ($listAllPersonnage as $values) {
        $valuePersonnage = $values->values;
        if ($valuePersonnage["pseudo"] == $identifiant) {
            return false;
        }
    }
    return true;
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
 * role : retourner l'historique des 15 derniers evenements du personnage current
 * @param : neant
 * @return : le tableau des cararacteristiques des mouvement realisés : 
 */
public function histoEvenements(){
    // $historique = new evenement();
    $historique = $this->getTarget('evenement');
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
   // $mvt = new evenement();
    $mvt=$this->getTarget('evenement');
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

// --------------------- TRANSFORMER POINTS FORCE---------------------------------------
 
/**
 * Role transforme un point de force en un point de resistance
 * @param : neant
 * @return : true si les modifications sont realisées, sinon false
 */
public function transformerForce() {
    // transforme un point de force en un point de resistance
   // consomme trois point d'agilité.
   if ($this->verifTransformerForce()) {
    $this->set("pts_force", $this->values["pts_force"]-1);
    $this->set("pts_resistance", $this->values["pts_resistance"]+1);
    $this->set("pts_agilite", $this->values["pts_agilite"]-3);
    if ($this->update()) {
        return true;
    }
    return false;
    }
}
/**
 * Role verifier si la transformation de point de force en points de resistance est possible
 * @param : neant
 * @return : true si modifications sont realisées, sinon false
 */
public function verifTransformerForce() {
    /* 
    possible si :
        point de force strictement dif de 0
        point d'agilité egal ou sup à 3
        point de resistance strictement inf à 15
    */

    if ($this->values["pts_force"] == "0") {
        return false;
    } else if ($this->values["pts_agilite"] < "3") {
        return false;
    } else if ($this->values["pts_resistance"]>"14") {
        return false;
    }
    return true;
}


// --------------------- TRANSFORMER POINTS RESISTANCE---------------------------------------
 
/**
 * Role transforme un point de resistance en un point de force
 * @param : neant
 * @return : true si les modifications sont realisées, sinon false
 */
public function transformerResistance() {
    // transforme un point de resistance en un point de force
   // consomme trois point d'agilité.
   if ($this->verifTransformerResistance()) {
    $this->set("pts_force", $this->values["pts_force"]+1);
    $this->set("pts_resistance", $this->values["pts_resistance"]-1);
    $this->set("pts_agilite", $this->values["pts_agilite"]-3);
    if ($this->update()) {
        return true;
    }
    return false;
    }
}
/**
 * Role verifier si la transformation de point de resistance en points de force est possible
 * @param : neant
 * @return : true si modifications sont realisées, sinon false
 */
public function verifTransformerResistance() {
    /* 
    possible si :
        point de resistance strictement dif de 0
        point d'agilité egal ou sup à 3
        point de resistance strictement inf à 15
    */
    if ($this->values["pts_resistance"] == "0") {
        return false;
    } else if ($this->values["pts_agilite"] < "3") {
        return false;
    } else if ($this->values["pts_force"]>"14") {
        return false;
    }
    return true;
}

}