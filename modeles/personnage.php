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

// --------------------- CARACTERISTIQUE D4UN PERSONNAGE  -------------------------------
/**
 * Role : recupere eles caracteristiques d'un personnage
 * @param : 
 * @return : tableau des caracteristique sans le password et log
 */
public function caracteristiquesPerso () {
    $data = [ 
        "id" => $this->id(),
    "nom" => $this->get("nom"),
    "pts_vie" => $this->get("pts_vie"),
    "pts_force" => $this->get("pts_force"),
    "pts_agilite" => $this->get("pts_agilite"),
    "pts_resistance" => $this->get("pts_resistance"),
    "salle" => $this->get("salle"),
    ];
    return $data;
}


// --------------------- LISTE PERSONNAGE DANS UNE SALLLE -------------------------------

/**
 * role : récuperer la liste des personnages present dans la salle
 * @param : le numero de la salle
 * @return : le tableau des noms des personnages indexé par l'id du personnage
 */
 public function listePersonnagesSalle ($idSalle) {
    // supression salle 1 et 11
    if ($idSalle <1 || $idSalle>10)  {
        $listePerso = [];
    return $listePerso;
    }
    // interogation bdd
    $sql = "SELECT `id`, `nom` FROM `$this->table` WHERE `salle` = :id "; 
   
    $param = [ ":id" => $idSalle];

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

// --------------------- SUBIR UNE ATTAQUE -------------------------------

/**
 * role : determine le gagant du combat et effectue le calcul des points
 * @param : id de de l'adversaire
 * @return : return true si la procedure subir une attaque c'est bien deroulée, sinon false
 */
function subirAttaque($idAdversaire) {
  
if ($this->esquiver ($idAdversaire)) {
    return true;
    exit;
    
}else if ($this->riposte($idAdversaire) ) {
    $perso = new personnage($idAdversaire);
    $perso->subirAttaqueRiposte($this->id());
    return true;
    exit;

} else if ($this->defendre($idAdversaire)) {
    return true;
    exit;
}
}

// --------------------- EFFECTUER UNE RIPOSTE ------------------------------- OK /
/**
 * role : determine le gagnant de la riposte donc du combat et calcul les points
 * @param : id de de l'adversaire
 * @return : true si la procedure de riposte c'est bien deroulée, sinon false
 */
function subirAttaqueRiposte ($idAdversaire) {
    if ($this->esquiverRiposte ($idAdversaire)) {
        return true;
        exit;
    } else if ($this->defendreRiposte($idAdversaire)) {
        return true;
        exit;
    } else {
        return true;
        exit;
    }
}

// --------------------- ESQUIVER ------------------------------- OK/
/**
 * role : determine si l'adversaire à esquivé et calculer les points
 * @param : id de de l'adversaire
 * @return : true si l'esquive à reussi , sinon false
 * obs : l'adversaire reussi l'esquive si ses pts d'agilité sont au moins sup aux pts de force de l'attaquant
 */
function esquiver ($idAdversaire) {
    $adversaire = new personnage($idAdversaire);
    $adversaireAgilite =  $adversaire->get("pts_agilite");
    $result = intval($adversaire->get("pts_agilite")) - intval($this->values["pts_force"]);
    if ($result>=3) {
        // // echo "esquive reussit le combat s'arrete";

        // l'adversaire perd 1 point d'agilite
        $adversaire->set("pts_agilite", (intval($adversaireAgilite)-1));
        $adversaire->update();
        // creation historique evenement adversaire
        $historiqueAdverssaire = new evenement();
        $historiqueAdverssaire->set("personnage", $idAdversaire);
        $historiqueAdverssaire->set("adversaire", $this->id());
        $historiqueAdverssaire->set("evenement", "ESQ");
        $historiqueAdverssaire->set("salle", intval($adversaire->get("salle")));
        $historiqueAdverssaire->set("pts_agilite", -1);
        $historiqueAdverssaire->set("created_date", date('Y-m-d H:i:s'));
        $historiqueAdverssaire->insert();
        
        // l'attaquant transforme un point de force en un point de resistance si 10pt de forces ou plus,
        if ($this->get("pts_force")>=10) {
            $this->set("pts_force", intval($this->values["pts_force"]-1));
            $this->set("pts_resistance", intval($this->values["pts_resistance"]+1));
            $this->update();
            // creation historique evenement attaquant
            $historiqueAttaquant = new evenement();
            $historiqueAttaquant->set("personnage", $this->id());
            $historiqueAttaquant->set("adversaire", $idAdversaire);
            $historiqueAttaquant->set("evenement", "ATT");
            $historiqueAttaquant->set("salle", intval($adversaire->get("salle")));
            $historiqueAttaquant->set("pts_force", -1);
            $historiqueAttaquant->set("pts_resistance", 1);
            $historiqueAttaquant->set("created_date", date('Y-m-d H:i:s'));
            $historiqueAttaquant->insert();
        
        } else { 
            // creation historique evenement attaquant
            $historiqueAttaquant = new evenement();
            $historiqueAttaquant->set("personnage", $this->id());
            $historiqueAttaquant->set("adversaire", $idAdversaire);
            $historiqueAttaquant->set("evenement", "ATT");
            $historiqueAttaquant->set("salle", $adversaire->get("salle"));
            $historiqueAttaquant->set("created_date", date('Y-m-d H:i:s'));
            $historiqueAttaquant->insert(); 
        }
        
        return true;
        exit;
    } else {
        // echo "esquive ratée le combat continu";
        return false;
    }
}

// --------------------- DEFENDRE ------------------------------- OK/
/**
 * role : determiner si l'adversaire se defend et calculer les points
 * @param : id de de l'adversaire
 * @return : true si la defence à reussi , sinon false
 * obs : se defend si les pts de resistance du personnage attaqué sont sup ou egal aux pts de force du personnage attaquant
 */
function defendre ($idAdversaire) {
    $adversaire = new personnage($idAdversaire);
    if(intval($adversaire->get("pts_resistance")) >= intval($this->get("pts_force"))) {
        // echo "defendre combat gagné par l'attaqué ";
        // points gagné par l'adversaire : neant
        // creation historique evenement adversaire
        $historiqueAdverssaire = new evenement();
        $historiqueAdverssaire->set("personnage", $idAdversaire);
        $historiqueAdverssaire->set("adversaire", $this->id());
        $historiqueAdverssaire->set("evenement", "DEF");
        $historiqueAdverssaire->set("salle", $adversaire->get("salle"));
        $historiqueAdverssaire->set("created_date", date('Y-m-d H:i:s'));
        $historiqueAdverssaire->insert();

        // points perdu par l'attaquant : 1 point de vie.
        $this->set("pts_vie", ($this->get("pts_vie") - 1));
        $this->update();
        // creation historique evenement attaquant
        $historiqueAttaquant = new evenement();
        $historiqueAttaquant->set("personnage", $this->id());
        $historiqueAttaquant->set("adversaire", $idAdversaire);
        $historiqueAttaquant->set("evenement", "ATT");
        $historiqueAttaquant->set("salle", $adversaire->get("salle"));
        $historiqueAttaquant->set("pts_vie", 1);
        $historiqueAttaquant->set("created_date", date('Y-m-d H:i:s'));
        $historiqueAttaquant->insert();
        return true ;
        exit;
    } else {
        // echo "defence combat gagné par l'attaquant ";
        // combat gagné par l'attaquant 

        // points de vie perdu par l'attaqué : en points de vie la différence entre notre résistance et la force de l'attaque.
        $result = intval($this->get("pts_force")) - intval($adversaire->get("pts_resistance"));
        $adversaire->set("pts_vie", ($adversaire->get("pts_vie")-$result));
        $adversaire->update();
        // creation historique evenement adversaire
        $historiqueAdverssaire = new evenement();
        $historiqueAdverssaire->set("personnage", $idAdversaire);
        $historiqueAdverssaire->set("adversaire", $this->id());
        $historiqueAdverssaire->set("evenement", "DEF");
        $historiqueAdverssaire->set("salle", $adversaire->get("salle"));
        $historiqueAdverssaire->set("pts_vie", (-$result));
        $historiqueAdverssaire->set("created_date", date('Y-m-d H:i:s'));
        $historiqueAdverssaire->insert();

        // creation historique evenement attaquant
        $historiqueAttaquant = new evenement();
        $historiqueAttaquant->set("personnage", $this->id());
        $historiqueAttaquant->set("adversaire", $idAdversaire);
        $historiqueAttaquant->set("evenement", "ATT");
        $historiqueAttaquant->set("salle", $adversaire->get("salle"));
        $historiqueAttaquant->set("created_date", date('Y-m-d H:i:s'));
        
        // points gagné par l'attaquant : ajout un point d'agilite ou un point de vie si deja 15 pt d'agilite
        if ($this->get("pts_agilite") > 15) {
            $this->set("pts_vie", ($this->get("pts_vie")+1));
            $historiqueAttaquant->set("pts_vie", 1);

        } else {
            $this->set("pts_agilite", ($this->get("pts_agilite")+1));
            $historiqueAttaquant->set("pts_agilite", 1);
        }
        // si l'adversaire meurt l'attaquant gagne ses points de vie
        if ($adversaire->get("pts_vie") <= 0) {
            $this->set("pts_vie", $this->get("pts_vie") + $adversaire->get("pts_vie"));
            $historiqueAttaquant->set("pts_vie", $adversaire->get("pts_vie"));
        }
        $this->update();
        $historiqueAttaquant->insert();
        return false ; 
        exit;
    };
}

// --------------------- RIPOSTER ------------------------------- OK
/**
 * role : determine si l'adversaire riposte
 * @param : id de de l'adversaire
 * @return : true si la riposte à reussi , sinon false
 * obs : si la force de l'adversaire est strictement sup à la force de l'attaquant, riposte reussit
 */
function riposte ($idAdversaire) {
    $personnageAdversaire = new personnage($idAdversaire);
    if(intval($personnageAdversaire->get("pts_force")) > intval($this->get("pts_force"))) {
        // echo "il y a une ripsote ";
        return true;
        exit;
    } else { 
        // echo " pas de riposte le combat continu ";
        return false;
    }
}

// --------------------- ESQUIVER (RIPOSTE) ------------------------------- OK
/**
 * role : determine si l'adversaire à esquiver dans la phase de risposte et calcul les points
 * @param : id de du personnage attaqué
 * @return : true si l'esquive à reussi , sinon false
 * obs : l'esquive est reussi si les pts agilité de l'adversaire sont au moins sup à pts force attaquant d'au moins 3 points
 */
function esquiverRiposte ($idAdversaire) {
    $personnageAdversaire = new personnage($idAdversaire); // 15
    $result = intval($personnageAdversaire->get("pts_agilite")) - intval($this->values["pts_force"]);

    if ($result>=3) {
        // echo "esquive (riposte) reussit le combat s'arrete (egalité) ";
        // calcul des points

        // l'adversaire initial perd 1 point de vie (17)
        $this->set("pts_vie", (intval($this->get("pts_vie"))-1));
        $historiqueAttaquant = new evenement();
        $historiqueAttaquant->set("personnage", $this->id());
        $historiqueAttaquant->set("adversaire", $idAdversaire);
        $historiqueAttaquant->set("evenement", "RIP");
        $historiqueAttaquant->set("salle", $this->get("salle"));
        $historiqueAttaquant->set("created_date", date('Y-m-d H:i:s'));
        $historiqueAttaquant->insert();
        $this->update();

        // l'attaquant initial transforme un point de force en un point de resistance si 10pt de forces ou plus, (15)
        if ($personnageAdversaire->get("pts_force")>=10) {
            $personnageAdversaire->set("pts_force", $personnageAdversaire->values["pts_force"]-1);
            $personnageAdversaire->set("pts_resistance", $personnageAdversaire->values["pts_resistance"]+1);
            // creation historique evenement adversaire
            $historiqueAdverssaire = new evenement();
            $historiqueAdverssaire->set("personnage", $idAdversaire);
            $historiqueAdverssaire->set("adversaire", $this->id());
            $historiqueAdverssaire->set("evenement", "ATT");
            $historiqueAdverssaire->set("salle", $personnageAdversaire->get("salle"));
            $historiqueAdverssaire->set("pts_force", -1);
            $historiqueAdverssaire->set("pts_resistance", 1);
            $historiqueAdverssaire->set("created_date", date('Y-m-d H:i:s'));
            $historiqueAdverssaire->insert();
        }
        $personnageAdversaire->update();
        return true;
        exit;
    } else {
        // echo "esquive (riposte) le combat continu ";
        return false;
    }
}

// --------------------- DEFENDRE (EN RIPOSTE) ------------------------------- OK/
/**
 * role : determine si l'adversaire se defend dans une ripsote et calcul des points
 * @param : id de de l'adversaire
 * @return : true si la defence à reussi , sinon false
 * obs : l'adversaire se defend si ses pts de resistance sont sup ou egal aux pts de force du personnage attaquant
 */
function defendreRiposte ($idAdversaire) {
    $adversaire = new personnage($idAdversaire); //15
    if(intval($adversaire->get("pts_resistance")) >= intval($this->get("pts_force"))) {
        // echo "riposte gagné par l'attaqué (cad l'attaquant inititial) ";
        // combat gagné par l'attaquant initial
        // historique combat attaquant initial
        $historiqueAdverssaire = new evenement();
        $historiqueAdverssaire->set("personnage", $idAdversaire);
        $historiqueAdverssaire->set("adversaire", $this->id());
        $historiqueAdverssaire->set("evenement", "ATT");
        $historiqueAdverssaire->set("salle", $adversaire->get("salle"));
        $historiqueAdverssaire->set("created_date", date('Y-m-d H:i:s'));

         //points gagné par l'attaquant initial : ajout un point d'agilite ou un point de vie si deja 15 pt d'agilite
         if ($adversaire->get("pts_agilite") > 15) {
            $adversaire->set("pts_vie", $adversaire->get("pts_vie")+1);
            $historiqueAdverssaire->set("pts_vie", 1);
            
        } else {
            $adversaire->set("pts_agilite", ($adversaire->get("pts_agilite")+1));
            $historiqueAdverssaire->set("pts_agilite", 1);
        }
        // si l'adversaire meurt l'attaquant initial gagne ses points de vie
        if ($this->get("pts_vie") <= 0) {
            $adversaire->set("pts_vie", ($adversaire->get("pts_vie") + $adversaire->get("pts_vie")));
            $historiqueAdverssaire->set("pts_vie", $adversaire->get("pts_vie"));
        }
        $adversaire->update();
        $historiqueAdverssaire->insert();

        // pts perdu par adversaire initil : 2 points de vie
        $this->set("pts_vie", $this->get("pts_vie")-2);
        $this->update();
        // historique adversaire
        $this->set("pts_vie", (intval($this->get("pts_vie"))-1));
        // historique combat adversaire intitial
        $historiqueAttaquant = new evenement();
        $historiqueAttaquant->set("personnage", $this->id());
        $historiqueAttaquant->set("adversaire", $idAdversaire);
        $historiqueAttaquant->set("evenement", "RIP");
        $historiqueAttaquant->set("salle", $this->get("salle"));
        $historiqueAttaquant->set("pts_vie", -2);
        $historiqueAttaquant->set("created_date", date('Y-m-d H:i:s'));
        $historiqueAttaquant->insert();
        $this->update();
        
        return true ; 
        exit;

    } else {
        // echo "riposte gagné par l'attaquant (cad l'attaqué inititial) ";
        // combat gagnépar l'attaqué initial

        // points de vie gagné par l'adversaire initial : 2 point de vie.
        $this->set("pts_vie", $this->get("pts_vie")+2);
        $this->update();
        // historique combat adversaire initial
        $historiqueAttaquant = new evenement();
        $historiqueAttaquant->set("personnage", $this->id());
        $historiqueAttaquant->set("adversaire", $idAdversaire);
        $historiqueAttaquant->set("evenement", "ATT");
        $historiqueAttaquant->set("salle", $this->get("salle"));
        $historiqueAttaquant->set("pts_vie", 2);
        $historiqueAttaquant->set("created_date", date('Y-m-d H:i:s'));
        $historiqueAttaquant->insert();

        // points de vie perdu par l'attaquant initial : 1 pt de vie
        $adversaire->set("pts_vie", $adversaire->get("pts_vie")-1);
        $adversaire->update();
        // historique combat adversaire
        $historiqueAdverssaire = new evenement();
        $historiqueAdverssaire->set("personnage", $idAdversaire);
        $historiqueAdverssaire->set("adversaire", $this->id());
        $historiqueAdverssaire->set("evenement", "ATT");
        $historiqueAdverssaire->set("salle", $adversaire->get("salle"));
        $historiqueAdverssaire->set("pts_vie", 1);
        $historiqueAdverssaire->set("created_date", date('Y-m-d H:i:s'));
        return true ; 
        exit;
    };
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


// --------------------- PERSONNAGE MORT ---------------------------------------

/**
 * Role verifier si le personnage et viviant ou mort
 * @param : neant
 * @return : true si mort, sinon false
 */
public function isDead() {
    if ($this->get("pts_vie")<=1) {
        return true;
    } else { return false;} 
}

}