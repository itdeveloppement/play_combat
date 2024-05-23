<?php

class evenement extends _model {

 // attributs
 protected $table = "evenement";
 protected $fields = [
    "personnage",
    "adversaire",
    "evenement",
    "salle",
    "pts_vie",
    "pts_force",
    "pts_agilite",
    "pts_resistance",
    "created_date",

 ];

 // lien objet
 protected $links = ["personnage" => "personnage"];


 // ------------------------- HISTORIQUE ------------------------------------------
    /**
 * role : recuperer l'historique des 15 derniers evenement du personnage current
 * @param : l'id du personnage
 * @return : le tableau des cararacteristiques des mouvement realisés : 
 *          id / action ou mvt / salle / pts de vie / pts de force / pts de resistance
 */
public function histoEvents($id){
    // int bdd
    $sql = "SELECT `id`, `adversaire`, `evenement`, `salle`, `pts_vie`, `pts_force`, `pts_agilite`, `pts_resistance` FROM `$this->table` WHERE `personnage` = :id ORDER BY `created_date` DESC
    LIMIT 15";
    $param = [ ":id" => $id ];

    // Préparer / exécuter
    global $bdd;
    $req = $bdd->prepare($sql);
    if ( ! $req->execute($param)) {
        return false;
    }
    // recuperation des données
    $tabHisto = $req->fetchAll(PDO::FETCH_ASSOC);
    $tabHistoModifier = $this->modifNomAdverssaireHisto ($tabHisto); 
    return $tabHistoModifier; 
}

/**
 * role : remplace la valeur numerique du champ adversaire par le nom de l'adversaire
 * @param : tableau de l'historique des evenements du personnage
 * @return : le tableau les évenements modifiés
 */
function modifNomAdverssaireHisto ($tabHisto) {
  $tabHistoAdverssaire = [];
foreach($tabHisto as $value){
  // $value["adversaire"]= $personnage->nomdupersonage($value["adversaire"]);
  $personnage = new personnage($value["adversaire"]);
  // $personnage->get("nom");
  $value["adversaire"]= $personnage->get("nom");
  $tabHistoAdverssaire[] = $value;

}
$histoModifier = $this->histoModifAction ($tabHistoAdverssaire);
return $histoModifier;
}

/**
 * role : remplace la valeur du champ action par le nom de l'action
 * @param : tableau de l'historique des evenements du personnage
 * @return : le tableau les évenements modifiés
 */
function histoModifAction ($tabHisto) {
  $tabAction = [
    "ATT" => "Attaquer",
    "DEF" => "Défendre",
    "RIP" => "Riposter",
    "ESQ" => "Esquiver",
    "AVA" => "Avancer",
    "REC" => "Reculer",
    "RES" => "Rester",
    "" => "", // pour les valeur non renseigner en bdd
  ];
  $tabHistoModifie = [];
  foreach($tabHisto as $value){
    $value["evenement"] = $tabAction [$value["evenement"]];
    $tabHistoModifie[] = $value;
  }
  return $tabHistoModifie;
  }

// --------------- AVANCER ------------------------------

/**
 * Role inserrer dans la base le mouvement avancer
 * @param : id du personnage et le numero de la salle atteinte
 * @return : true si insertion realisé, sinon false
 */
public function insertMvtAvancer ($id, $salle) { 
    $this->set("personnage", $id);
    $this->set("evenement", "AVA");
    $this->set("salle", $salle);
    $this->set("pts_agilite", "-$salle");
    $this->set("created_date", date('Y-m-d H:i:s'));
    
    if ($this->insert()) { 
      return true;
    }
    return false;
  }

// --------------- RECULER ------------------------------
/**
 * Role inserrer dans la base le mouvement avancer
 * @param : id du personnage et le numero de la salle à atteinte
 * @return : true si insertion realisé, sinon false
 */
public function insertMvtReculer ($id, $salle) { 
  $this->set("personnage", $id);
  $this->set("evenement", "REC");
  $this->set("salle", $salle);
  $this->set("pts_vie", "$salle");
  $this->set("created_date", date('Y-m-d H:i:s'));
  
  if ($this->insert()) { 
    return true;
  }
  return false;
}

// --------------- MOURRIR------------------------------

/**
 * Role detecte si un personnage est mort
 * @param : id du personnage
 * @return : true si mort, sinon false
 */
function dead ($id) {

  if ($this->get("pts_vie" == 0)) {
    return true;
  } return false;

}


}
