<?php

class evenement extends _model {

 // attributs
 protected $table = "evenement";
 protected $fields = [
    "personnage",
    "adverssaire",
    "mouvement",
    "salle",
    "action",
    "pts_vie",
    "pts_force",
    "pts_agilite",
    "pts_resistance",
    "created_date",

 ];

 // lien objet
 protected $links = ["personnage" => "personnage"];

    /**
 * role : recuperer l'historique des 15 derniers evenement du personnage current
 * @param : l'id du personnage
 * @return : le tableau des cararacteristiques des mouvement realisés : 
 *          id / action ou mvt / salle / pts de vie / pts de force / pts de resistance
 */
public function histoEvents($id){
    // int bdd
    $sql = "SELECT `id`, `adverssaire`, `mouvement`, `salle`, `action`, `pts_vie`, `pts_force`, `pts_agilite`, `pts_resistance` FROM `$this->table` WHERE `personnage` = :id ORDER BY `created_date` DESC
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
    $tabHistoModifier = modifNomAdverssaireHisto ($tabHisto); 
    return $tabHistoModifier; 
    }
}

/**
 * role : remplace la valeur numerique du champ adverssaire par le nom de l'adverssaire
 * @param : tableau de l'historique des evenements du personnage
 * @return : le tableau les évenements modifiés
 */
function modifNomAdverssaireHisto ($tabHisto) {
// $personnage = new personnage(); 
foreach($tabHisto as $value){
  // $value["adverssaire"]= $personnage->nomdupersonage($value["adverssaire"]);
  $personnage = new personnage($value["adverssaire"]);
  $personnage->get("nom");
  $value["adverssaire"]= $personnage->get("nom");
  return $value;
}

}

