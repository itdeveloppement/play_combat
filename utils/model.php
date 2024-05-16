<?php

/*
Classe _model : classe générique de gestion des objets du modèle de données
(on a un _ dans le nom pour être sûr de ne pas avoir de table de ce nom)

Pour l'utiliser, on a mles méthode
    load(id) : chargement d'un objet depuis la BDD par son id
    is() : indique si l'objet est chargé / existe (true si existe, false sinon)
    get(nomChamp) : récupération de la valeur d'un champ (valeur physique)
    getTarget(nomChamp) : récupère l'objet associé à un champ qui est un lien
    id() : récupère l'id
    set(nomChamp, valeur) : affectation d'une valeur à un champ
    insert() : ajout de l'objet courant dans la BDD
    update() : mise à jour de l'objet courant dans la BDD
    delete() : suppression de l'objet courant de la BDD
    listAll(+:-tri1, +/-tri2) : récupération de tous les champs

*/

class _model {

    // ATTRIBUTS
    // Description du modèle de l'objet (de la table)

    protected $table = "";       // Nom de la table, à valoriser pour les classes réelles;
    protected $fields = [];      // Liste simple des noms des champs, avec le type de champ

    protected $links = [];      // Liste des liens sortants : 
        //tableau qui pour cahque lien met en index le nom du champ qui est un lien, et en valeur le nom de l'objet
        //  (exemple : [ "fournisseur" => "fournisseur"])

    // Stoker un objet précis
    protected $id = 0;      // id de l'objet chargé
    protected $values = []; // On stockera les valeurs sous la forme [ "nomChamp1" => valeur1, ... ]
    protected $targets = [];    // On stockera pour les liens [ "nomChamp" => objetLié, .. ]


    // A INTEGRER AVEC UN APPEL D'OBJET ET NON LA CLASSE STATIC
    /*
     // Base de données ouverte
     protected static $bdd;

     // Ouverture de la base de données
 
 
     static function bdd() {
         // Rôle : retourne l'objet PDO vers la bdd, le créée si nécessaire
         // Paramètres néant
         // Retour : l'objet PDO
 
         if (empty(static::$bdd)) {
             static::$bdd = new PDO("mysql:host=localhost;dbname=cours-dev;charset=UTF8", "cours-dev", "webecom42");
         }
         return static::$bdd;
 
 
     }
    */
     
    // CONSTRUCTEUR

    function __construct($id = null) {
        // Cette fonction se déclenche à chaque fois que l'on instancie un objet (new nomClasse())
        // Les paramètres du constructeur devront être valorisés dans les parenthèses du new nomClasse() 
        // rôle : charger l'objet correspondant à l'id (si non null)
        // paramètre : l'id de la ligne à chargé
        // retour : constructeur, pas de retour

        // Si l'id est non null
        //  Charger l'objet avec cet id
        if ( ! is_null($id)) {
            $this->load($id);
        }
    }

    // METHODES

    // **si l'objet est chargé**

    function is() {
        // Rôle : dire si l'objet est chargé (si il y a un contact de la BDD dedans)
        // Paramères : néant
        // Retour : true si il est chargé, false sinon

        return ! empty($this->id);      
            // empty recouvre variable non initialisée, variable valant null, et toutes les valeurs apparentées à false (false, 0, "", [])
    }

    // **Getters : récupérer les attributs**

    // Au lieu de $contact->getEmail(), on va avoir une syntaxe $contact->get("email")

    function get($fieldName) {
        // Rôle : récupérer la valeur d'un attribut
        // Paramètres :
        //      $fieldName : nom de l'attribut
        // Retour : la valeur de l'attribut (chaine vide si l'attribut n'existe)

        // On a la valeur dans l'attribut values, à l'index qui a le même nom que l'attribut cherché
        // l'attribut values est accessible $this->values
        // l'index qui nous intéresse est dans $fieldName

        //  cad $this->values[$fieldName];

        // On contrôle que la valeur existe, sinon, on retourne ""
        // Si la valeur existe (isset(....)) retourne la valeur, sinon retourne ""
        if (isset($this->values[$fieldName])) {
            return $this->values[$fieldName];
        } else {
            return "";
        }
    }

    /* PRESISION ----------------------------------------------
    role : recupere un objet associé à un champ, si l'objet est deja chargé il est simplement recupéré ds la mémoire et n'est pas rechargé à chaque appel.
    L'objet associé au champ peut etre deja chargé pour plusieurs raions : une rquette dans la bdd, un prechargement, le cache
    La fct getTraget permet :
    - une encapsulation de la logique de chargement : le stockage des objet chargé est centralisé dans la methode
    - gestion de la mémoire : en stochkant les objet déja chargé dans un tableau ($target) on evite de charger les objet plusieur fois
    - abstraction de la structure de donnée : met en evidence les relations complaxes entre diffeentes entités
    ------------------------------------------------------------
    */

    // ** recuperer un objet associé**

    function getTarget($fieldName) {
        // Rôle : retourner un objet pointé par un champ
        // paramètre : 
        //      $fieldName : nom du champ
        // Retour : objet (d'une classe héritée de la classe _model), chargé avec l'objet pointé
        //       si on ne trouve pas :
        //          si champ inconnu ou pas un lien : retourne un objet _model (vide)
        //          si le champ est un lien, mais vide, ou pas d'bjet en face : le bon objet, mais pas chargé

        // Verification si l'objet associé au champs est deja chargé dans le tableu $targets (dans $this->targets)
        if (isset($this->targets[$fieldName])) {
            return $this->targets[$fieldName];
        }

        // Si ce n'est pas un lien on instencie un objet qu'on retourne
        if ( ! isset($this->links[$fieldName])) {
            // Ce n'est pas un lien : on retourne un objet de la classe _model
            $this->targets[$fieldName] = new _model();
            return $this->targets[$fieldName];
        }

        // c'est un lien : l'objet pointé est de la classe indiquée dans $this->links[$fieldName]
        $nomClasse = $this->links[$fieldName];
        $this->targets[$fieldName] = new $nomClasse($this->get($fieldName));

        return $this->targets[$fieldName];
    }

    // ** retourner l'id de l'objet **
    function id() {
        // Rôle : récupérer l'id
        // paramètres : néant
        // Retour : l'id ou O (un nombre entier)

        //L'id est stocké dans l'atttrbut id
        return $this->id;
    }

    // ** Setters : donne des valeurs aux attributs **

    // Au lieu de $contact->setNom("Durand), on va avoir une syntaxe $contact->set("nom", "Durand")
    function set($fieldName, $value) {
        // Rôle : changer / initialiser la valeur d'un attribut
        // Paramètres : quel attrribut, quelle nouvelle valeur
        //      $fieldName : nom de l'attribut
        //      $value : nouvelle valeur
        // Retour : true si accepté, false sinon

        // Il faut stocker la valeur à l'index correspondant à l'attribut de nom $fieldName, dans $this->values
        $this->values[$fieldName] = $value;

        // On retourne true (on a pas d'infos pour vérifier si la valeur est valide, on ne peut que l'accepter)
        return true;
    }

    // ** defnit toutes les valeurs des objets)**

    function loadFromTab($tab) {
        // Rôle : initialiser l'objet (complètement) à partir d'un tableau de données (simialire à celui réupéré par fetch)
        // Paramètres : 
        //      $tab : tableau valorisant les champs du MPD
        // Retour : true 
        if (isset($tab["id"])) $this->id = $tab["id"];
        foreach($this->fields as $nomChamp) {
            if (isset($tab[$nomChamp])) 
                $this->values[$nomChamp] = $tab[$nomChamp];
        }
        return true;
    }

    // ** recupere un objet de la bdd selon l'id **

    function load($id) {
        
        // Rôle : chargement de l'objet (de ses attributs) depuis une ligne de la base de données
        // Paramètres : 
        //      $id : id du contact à charger
        // Retour : true si on l'a trouvé, false sinon

        // Passe la requête : SELECT champs FROM table WHERE id = monId
        // Construire la requête SELECT `champ1`, `champ2`, .... FROM `table` WHERE id = :id
        // On valorise :id dans un tableau pour l'excéution
        $sql = "SELECT " ;
        // Ajouter tous les noms de champs, encadrés par `, séparés par ,
        // Le noms des champs : ils sont dans l'attribut fields (tableau $this->fields)
        // On met les noms de tous les champs, encadrés par ` `, séparés par une virgule

        // faire un tableau avec les morceux de texte à séparer
        // Utiliser la fonction implode pour générer le texte compoésé de tous les éléments séparés un texte donné

        // On génère un tableau composés des noms des champs encadrés par ` ` 
        $tableau = [];
        foreach($this->fields as $nomChamp) {
            $tableau[] = "`$nomChamp`";
        }
        $sql .= implode(", ", $tableau);
        
        // Ajouter FROM puis  le nom de la table (il est dans $this->table) encadré par `
        $sql .= " FROM `$this->table` ";

        // Ajouter le texte WHERE `id` = :id
        $sql .= " WHERE `id` = :id";

        // Faire le tableau pour valoriser :id
        $param = [ ":id" => $id];

        //      Préparer / exécuter
        global $bdd;
        $req = $bdd->prepare($sql);
        if ( ! $req->execute($param)) {
            // On a une erreur de requête (on peut afficher des messages en phase de debug)
            return false;
        }

        // On s'assure que l'on a trouvé une ligne
        $listeExtraite = $req->fetchAll(PDO::FETCH_ASSOC);
        // Si le tabeu $liste est vide (0 elt), c'est qu'on a pas l'id cherché
        if (empty($listeExtraite)) {
            return false;
        }

        // Transfere son résultat dans les valeurs des attributs internes
        // On récupère le premier (et seul) élément
        $tab = $listeExtraite[0];

        // Pour chaque champ de l'objet, on valorise $this->values[champ];
        foreach($this->fields as $nomChamp) {
            $this->values[$nomChamp] = $tab[$nomChamp];
        }

        // On renseigne l'id :
        $this->id = $id;

        return true;
    }

    // ** insere un objet en bdd **

    function insert() {
        // Rôle : création du contact courant dans la base de données
        // paramètres : néant (on utilise les attributs de l'objet)
        // retour : true si réussi, false si échoué

        // Créer la requête : INSERT INTO `nomDeLaTable` SET `nomChamp1` = :nomChamp1, `nomChamp2` = :nomChamp2, ...
        // En paralèle, faire un tableau de valorisation des :nomChampX : [ ":nomChamp1" => valeurChamp1, ":nomChamp1" => valeurChamp2, ...]
        $sql = "INSERT INTO `$this->table`SET " . $this->makeRequestSet();
        $param  = $this->makeRequestParamForSet();

        // On prépare la requête
        global $bdd;
        $req = $bdd->prepare($sql);
        //  - on exécute cette requête
        if ( ! $req->execute($param)) {
            // Erreur sur la requête
            return false;
        }
        // ne pas oublier d'enregistrer l'id qui a été généré par la BDD
        // il est donné par la méhode lastInsertId de l'objet $bdd
        $this->id = $bdd->lastInsertId();
        return true;
    }

    // ** modifie un objet en bdd **

    function update() {
        // Rôle : mettre à jour l'objet courant dans la base de données
        // Paramètres : néant
        // Retour : true si réussi, false si échoué

        // On va devoir exécuter une requête SQL de mise à jour (UPDATE)
        //  - Construire le texte de la requête SQL
        //          UPDATE `nomDeLaTable` 
        //              SET `nomChamp1` = :nomChamp1, `nomChamp2` = :noùmChamp2, ...
        //              WHERE `id` = :id
        //      et valoriser les paramètres
        //          [ ":id" => idLigneAModifier, ":nomChamp1" => valeurChamp1, ":nomChamp1" => valeurChamp2, ...]
        // On va donc préparer deux variables : 
        //      un texte pour la requête ($sql)
        //      un tableau pour les paramètres :xx de cette requête
        //      on construit la chaine : texte UPDATE `nomDeLaTable` SET    (nomDeLaTable est dans l'atribut table de l'objet)
        //      on va ajouter tous les champs : `nomChamp1` = :nomChamp1 (en les séparant par une virgule)
        //      on va mettre la partie finale ( WHERE ìd`= :id)
        // Et pour le tableau : on met l'élément :id (la valeur est dans l'attrribut id)
        //      et tous les champs (un par un "pour chaque" ) : attribut :nomChamp, valeur : elle est dans la tableau values
        //                      on peut aussi récupérer la valeur avec la méthode get(nomChamp)
        $sql = "UPDATE  `$this->table` SET " . $this->makeRequestSet() . " WHERE `id` = :id ";
        $param = $this->makeRequestParamForSet();
        $param[":id"] = $this->id;
           
        // On prépare la requête
        global $bdd;
        $req = $bdd->prepare($sql);

        //  - on exécute cette requête
        if ( ! $req->execute($param)) {
            // Erreur sur la requête
            return false;
        }
        return true;
    }

    function makeRequestSet() {
        // Rôle : construire la partie d'une requête de mise à jour ou de création valorisant les champs
        // paramètres : néant
        // Retour : le texte à mettre derrère SET dans une requête SQL : `nomChamp1` = :nomChamp1, `nomChamp2` = :noùmChamp2, ...

        // Je n'ai comme information disponible que :
            // - les attributs de la classe
            // - les paramètres de ma méthode (aucun dans ce cas)
            // - les élments que d'autres méthodes peuvent me donner

        // On a des bouts de texte ( `nomChamp` = :nomChamp) à fabriquer (un pour chaque champ ), et à les séparer par ,
        // Une solution est de :
        //          - fabriquer un tableau simple contenant les bouts de texte
        //          - utiliser implode pour générer la chaine de caractère finale avec les séprateurs
        
        // Fabrique un tableau simplde des bouts de texte ( `nomChamp` = :nomChamp) 
        $tableau = $this->makeTableauSimpleSet();

        // Générer le texte final :
        return implode(", ", $tableau);
    }

    function makeTableauSimpleSet() {
        // Rôle : faire un tableau contenant pour chaque champ, un élément avec le texte `nomChamp` = :nomChamp
        // paramètres : néant
        // Retour : le tableau décrit ci-dessus

        // Faire un tableau : on part d'un tableau vide
        $result = [];

        // Pour chaque champ : ajouter dans $result un élément `nomChamp` = :nomChamp
        foreach($this->fields as $nomChamp) {
            // On a le nom du champ dans $nomchamp
            $result[] = "`$nomChamp` = :$nomChamp";
        }
        return $result;
    }

    function makeRequestParamForSet() {
        // Rôle : préparer (et retourner) le tableau de valorisation des paramètres pour mise à jour des champs
        // Paramètres : néant
        // Retour : le tableau contenant les valeurs associées aux :nomChamp (pour chaque champ)
        //               [ ":nomChamp1" => valeur1, ":nomChamp2" => valeur2, ... ]

        // Je n'ai comme information disponible que :
            // - les attributs de la classe
            // - les paramètres de ma méthode (aucun dans ce cas)
            // - les élments que d'autres méthodes peuvent me donner

        // On doit faire un tableau, qui a un élément pour chaque champ (du modèle conceptuel) de la table
        //      pour le chmpa dont le nom est nomChamp, l'élément du tabelau résultat 
        //          à pour valeur la valeur courant du champ
        //          pour index le caractère : suivi du nom du champ
        // Pour chaque champ : il faut parcourir la liste des champs : attribut fields ($this->fields)
        $result = [];       // On part d'un tableau vide
        foreach($this->fields as $nomChamp) {
            // On doit ajouter dans le tableau result l'index :nomChamp avecla valeur du champ
            // ON doit construire $result[":nomChamp"] = valeurDuChamp;
            $index = ":$nomChamp";          
            // Valeur : elle est dans le tableau des valeurs, l'attribut values ($this->values)
            // Si on a une valeur pour $nomChamp, on crée l'élément de tableau avec cette valeur,
            // Sinon, on crée avec null
            if (isset($this->values[$nomChamp])) {
                $result[$index] = $this->values[$nomChamp];
            } else {
                $result[$index] = null;
            }
        }
        return $result;
    }

    // ** supprime un objet en bdd **

    function delete() {
        // Rôle : supprimer l'objet courant dans la base de données
        // Paramètres : néant
        // Retour : Ceux qui sont sur les cp

        // On va devoir exécuter la requête de suppression d'une ligne

        // En PHP, pour faire une requête sur la BDD :
        //  - on construit le texte de la requête en langage en langae SQL
        // La requête à construire : DELETE FROM `nomDeLaTable` WHERE `id` = lidQueJeVeux
        // Les parties "variables" sont : 
        //      - nomDeLaTable : elle est das l'attribut table de l'objet courant
        //      - lidQueJeVeux : il est dans mon attribut id 
        // La syntaxe pour récupérer un attribut de l'objet courant : $this->nomAttribut
        $sql = "DELETE FROM `$this->table` WHERE `id` = :id";
        $param = [":id" => $this->id];
    
        //  - on préparer un objet requête
        // Cela s'aplique à l'objet base de données : il est en variable globale, c'est $bdd
        global $bdd;
        $req = $bdd->prepare($sql);

        //  - on exécute cette requête
        if ( ! $req->execute($param)) {
            // Erreur sur la requête
            return false;
        }
        //  - on exploite le résultat
        // Marquer le fait que cette objet n'est plus dans la BDD : la régle choisie est de mettre l'id à 0
        $this->id = 0;

        return true;
    }

    // ** donner la liste de tous les objets de cette calsse (depuis la BDD) **

    function listAll(...$tris) {
        // Rôle : donner la liste de tous les objets de cette calsse (depuis la BDD)
        // paramètres : gérer les critères de tri
        //          "+/-nomChamp", "+/-nnomChamp", ....
        //      autant de paramètres que de critères de tri, 
        //     chaque paramètre est le nom du champ précédé de - pour un tri descedant, 
        //              optionnellement de + pour un tri ascendant
        //      $obj->tri("+nom", "+prenom")
        //  $tris : on donne les paramètres séparés par une virgle à l'appel, 
        //        on récupère un tableau simple dans la fonction
        // retour : liste d'objet de la classe courante, indexées par les id

        // Construire la requête SQL, et ses paramètres
        // SELECT `nomChamp1`, `nomChamp2`, ... FROM `nomTable`
        //      ORDER BY tri1 ASC/DESC, ....

        $sql = "SELECT "; 
        // Construire la liste des champs encadrés par ` 
        // On met d'abord l'id
        $tableau = [ "`id`" ];
        foreach($this->fields as $nomChamp => $type) {
            $tableau[] = "`$type`";
        }

        $sql .= implode(", ", $tableau);
        $sql .= " FROM `$this->table` ";

        // Construire la liste des critères de tri
        $tabOrder = [];
        foreach($tris as $tri) {
            // tri : +nomChamp ou - nomChamp ou nomChamp
            $car1 = substr($tri, 0, 1);
            if ($car1 === "-") {
                $ordre = "DESC";
                $nomField = substr($tri, 1);
            } else if ($car1 === "+") {
                $ordre = "ASC";
                $nomField = substr($tri, 1);
            } else {
                $ordre = "ASC";
                $nomField = $tri;
            }
            $tabOrder[] = "`$nomField` $ordre";
        }
        if (!empty($tabOrder))  $sql .= " ORDER BY " . implode(",", $tabOrder);
        // préparer / exécuter
        global $bdd;
        $req = $bdd->prepare($sql);
        if ( ! $req->execute()) {
            // Echec de la requête
            return [];
        }

        // Construire le tableau résultat
        $result = [];
        // tant que j'ai une ligne de résultat de la requête à lire
        while ($tabObject = $req->fetch(PDO::FETCH_ASSOC)) {
            // "transférer" $tabObject en objet de la classe courante
            // Récupération du nom de la classe de l'objet courant
            $classe = get_class($this);
            $obj = new $classe();
            // Charger l'objet
            $obj->loadFromtab($tabObject);
            // ON ajoute cela dans $result
            $result[$obj->id()] = $obj;
        }
        return $result;
    }

    // ------------- DATE --------------------


}
