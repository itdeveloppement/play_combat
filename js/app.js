/**
 * Role :  initialise la partie js de l'application 
 * Parm : neant
 */

document.addEventListener("DOMContentLoaded", function() {
    boutonsAction()
    
});

setInterval(function() {
    rafraichirPage()
}, 500);
// ------------------------ ATTAQUER ---------------------------------

/**
 * role : gerer l'attaque d'un personnage sur un autre
 * @param : l'id de la personne attaquée
 */
function attaquer(idSubirAttaque) {
    // console.log (idSubirAttaque);
    fetch(`update_attaque_controleur.php?id=${idSubirAttaque}`)
        .then(response=>{
            return response.json();
        })  .then (response=>{
           // console.log(response.personnage.pts_force);
            // affichage des modifciations
            document.getElementById('ptsVie').textContent = response.personnage.pts_vie;
            document.getElementById('ptsForce').value = response.personnage.pts_force;
            document.getElementById('ptsForce2').textContent = response.personnage.pts_force;
            document.getElementById('ptsResistance').value = response.personnage.pts_resistance;
            document.getElementById('ptsResistance2').textContent = response.personnage.pts_resistance;
            document.getElementById('ptsAgilite').value = response.personnage.pts_agilite;
            document.getElementById('ptsAgilite2').textContent = response.personnage.pts_agilite;
            // afficher historique et liste personnages dans la salle
            affichageHistorique(response.historique);
            affichageListePerssonagesSalle(response.listePersonnageSalle);
        })
        // recuperation des erreurs
        .catch(erreur=>{
            console.log(erreur);
        });
}

//------------------------ MOUVEMENT ---------------------------------
/**
 * Role :  appel le controleur pour l'evenement avancer du personnage
 * @Param : neant
 * @return : 
 */
function avancer() {
    fetch("update_avancer_personnage_controleur.php")
        .then(response=>{
            return response.json();
        })  .then (response=>{
            
            // affichage des modifciations
            document.getElementById('salle').textContent = response.personnage.salle;
            document.getElementById('ptsVie').textContent = response.personnage.pts_vie;
            document.getElementById('ptsAgilite').value = response.personnage.pts_agilite;
            document.getElementById('ptsAgilite2').textContent = response.personnage.pts_agilite;
            let main = document.querySelector("main");
            let numSallePrecedente = response.personnage.salle+1;
            main.classList.remove(`mainImgS${numSallePrecedente}`);
            main.classList.add(`mainImgS${response.personnage.salle}`);
            console.log(main);

            // afficher historique et liste personnages dans la salle
            affichageHistorique(response.historique);
            affichageListePerssonagesSalle(response.listePersonnageSalle);
            boutonsAction ();
        })
        // recuperation des erreurs
        .catch(erreur=>{
            console.log(erreur);
        });
};

/**
 * Role :  appel le controleur php pour l'evenement reculer du personnage
 * @Param : neant
 * @return : 
 */

function reculer() {
    fetch("update_reculer_personnage_controleur.php")
        .then(response=>{
            return response.json();
        })  .then (response=>{
            // affichage des modifciation
            document.getElementById('salle').textContent = response.personnage.salle;
            document.getElementById('ptsVie').textContent = response.personnage.pts_vie;
            // afficher historique et liste personnages dans la salle
            affichageHistorique(response.historique);
            affichageListePerssonagesSalle(response.listePersonnageSalle)
            let main = document.querySelector("main");
            let numSallePrecedente = response.personnage.salle+1;
            main.classList.remove(`mainImgS${numSallePrecedente}`);
            main.classList.add(`mainImgS${response.personnage.salle}`);
            console.log(main);
            boutonsAction ();
        })
        // recuperation des erreurs
        .catch(erreur=>{
            console.log(erreur);
        });
};

//------------------------ TRANSFORMER FORCE - RRESISTANCE ---------------------------------
/**
 * Role :  appel le controleur php pour la transformation d'un point de force en point de resistance
 * @Param : neant
 * @return : 
 */
function force() {
    fetch("update_transforme_force_controleur.php")
        .then(response=>{
            return response.json();
        })  .then (response=>{
            
            // affichageModif(response);
            document.getElementById('ptsForce').value = response.pts_force;
            document.getElementById('ptsForce2').textContent = response.pts_force;
            document.getElementById('ptsResistance').value = response.pts_resistance;
            document.getElementById('ptsResistance2').textContent = response.pts_resistance;
            document.getElementById('ptsAgilite').value = response.pts_agilite;
            document.getElementById('ptsAgilite2').textContent = response.pts_agilite;
        })
        // recuperation des erreurs
        .catch(erreur=>{
            console.log(erreur);
        });
};

/**
 * Role :  appel le controleur php pour la transformation d'un point de resistance en point de force
 * @Param : neant
 * @return : 
 */
function resistance() {
    fetch("update_transforme_resistance_controleur.php")
        .then(response=>{
            return response.json();
        })  .then (response=>{
            
            document.getElementById('ptsForce').value = response.pts_force;
            document.getElementById('ptsForce2').textContent = response.pts_force;
            document.getElementById('ptsResistance').value = response.pts_resistance;
            document.getElementById('ptsResistance2').textContent = response.pts_resistance;
            document.getElementById('ptsAgilite').value = response.pts_agilite;
            document.getElementById('ptsAgilite2').textContent = response.pts_agilite;
        })
        // recuperation des erreurs
        .catch(erreur=>{
            console.log(erreur);
        });
};

// ------ FCTS AFFICHAGE HISTO  ----------------            
/** 
 * Role : affiche la mise à jour de l'historique
 * @param {Objet} l'objet contenant les données de l'historique
 * @return
 */
function affichageHistorique(historiques){
    // mise à jour numero de salle
    let zoneHistorique = document.getElementById("zoneHistorique");
    let template = '';
    historiques.forEach (function (historique) {
        template +=
        `
        <tr>
            <td> ${historique.evenement !== null ? historique.evenement : ''} </td>
            <td> ${historique.salle !== null ? historique.salle : ''} </td>
            <td> ${historique.adversaire !== null ? historique.adversaire : ''} </td>
            <td> ${historique.pts_vie !== null ? historique.pts_vie : ''} </td>
            <td> ${historique.pts_force !== null ? historique.pts_force : ''} </td>
            <td> ${historique.pts_agilite !== null ? historique.pts_agilite : ''} </td>
            <td> ${historique.pts_resistance !== null ? historique.pts_resistance : ''} </td>
        </tr>
        `;
        zoneHistorique.innerHTML = template;
});
}

// ------ FCTS AFFICHAGE LISTE PERSONNAGE SALLE ----------------  

/** 
 * Role : affiche la mise à jour de la liste des personnages dans une salle
 * @param {Objet} l'objet contenant les données de la liste des personnages
 * @return
 */
function affichageListePerssonagesSalle(listePersonnagesSalle){ 
    let zoneListePersonnage = document.getElementById("zoneListePersonnage");

    if (Object.values(listePersonnagesSalle).length > 0) {
        // Récupérer les clés
        let keys = Object.keys(listePersonnagesSalle);

        let template = '';

        Object.values(listePersonnagesSalle).forEach (function (personnage, index) {
            template +=
           `
            <button class="btn_attaquer" data-id="${keys[index]}">Attaquer ${personnage !== null ? personnage : ''}</button>
            `;
        });

        // Insérer le HTML dans le DOM
        zoneListePersonnage.innerHTML = template;

        // Ajouter les écouteurs d'événements après l'insertion et raffraichir affichage liste personnages ds la salle
        let buttons = document.querySelectorAll('.btn_attaquer');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                let idSubirAttaque = button.getAttribute('data-id');
                attaquer(idSubirAttaque);
            });
        });
    } else {
        template = '';
        zoneListePersonnage.innerHTML = template;
    }
}

// ------ FCTS AFFICHAGE BOUTONS ACTION ----------------  

/**
 * role : affiche les boutons des actions possible 
 * @param : le numero de la salle ou le personnage se situe
 * @return :
 */
function boutonsAction () {
    fetch("select_personnage_controleur.php")
    .then(response=>{
        return response.json();
    })  .then (response=>{
    
    numSalle = response.personnage.salle;
    
    zone = document.getElementById("boutonAction");
    let template = '';
    if (numSalle < 11 && numSalle > 0) {
        template += 
        `  
            <button id="btnReculer">Retour</button>
            <button id="btnForce">Transformer force en resistance</button>
            <button id="btnResistance">Transformer resistance en force</button>
            <button id="btnAvancer">Avancer</button>
        `;
        zone.innerHTML = template;
        
        document.getElementById("btnAvancer").addEventListener("click", ()=> {avancer();});
        document.getElementById("btnReculer").addEventListener("click", ()=> {reculer();});
        document.getElementById("btnForce").addEventListener("click", ()=> {force(); });
        document.getElementById("btnResistance").addEventListener("click", ()=> {resistance();});
    } else if (numSalle < 1) {
        template += `
            <button id="btnForce">Transformer force en resistance</button>
            <button id="btnResistance">Transformer resistance en force</button>
            <button id="btnAvancer">Avancer</button>
        `;
        zone.innerHTML = template;
       
        document.getElementById("btnAvancer").addEventListener("click", ()=> {avancer();});
        document.getElementById("btnForce").addEventListener("click", ()=> {force(); });
        document.getElementById("btnResistance").addEventListener("click", ()=> {resistance();});
    } else if (numSalle > 10) {
        template += `
            <button id="btnReculer">Retour</button>
            <button id="btnForce">Transformer force en resistance</button>
            <button id="btnResistance">Transformer resistance en force</button>
        `;
        zone.innerHTML = template;
        document.getElementById("btnReculer").addEventListener("click", ()=> {reculer();});
        document.getElementById("btnForce").addEventListener("click", ()=> {force(); });
        document.getElementById("btnResistance").addEventListener("click", ()=> {resistance();});
    }
    
    })
    // recuperation des erreurs
    .catch(erreur=>{
        console.log(erreur);
    });
    
}

// --------------------- RAFRAICHIR PAGE ----------------  

/**
 * role : rafraichir la page toute les x seconde
 * @param :
 * @return :
 */
function rafraichirPage(){
    fetch("select_personnage_controleur.php")
    .then(response=>{
        return response.json();
    })  .then (response=>{
            document.getElementById('salle').textContent = response.personnage.salle;
            document.getElementById('ptsVie').textContent = response.personnage.pts_vie;
            document.getElementById('ptsForce').value = response.personnage.pts_force;
            document.getElementById('ptsForce2').textContent = response.personnage.pts_force;
            document.getElementById('ptsResistance').value = response.personnage.pts_resistance;
            document.getElementById('ptsResistance2').textContent = response.personnage.pts_resistance;
            document.getElementById('ptsAgilite').value = response.personnage.pts_agilite;
            document.getElementById('ptsAgilite2').textContent = response.personnage.pts_agilite;
            affichageHistorique(response.historique);
            affichageListePerssonagesSalle(response.listePersonnageSalle);
    })
    // recuperation des erreurs
    .catch(erreur=>{
        console.log(erreur);
    });
    
}


















// OBSOLETTE ----------------- AFFICHAGE MESSAGE SI PERSONNAGE MORT ------------------------

/**
 * role : affiche page rejouer si personnage morts
 * @param :
 * @return :
 */
function isdead () {
    zone = document.getElementById("messageDead");
    zone.style.display = "block";
    let  template = 
    `
    <p>Vous êtes mort !</p>
    <p>Quitter ou rejouer en creant un nouveau personnage</p>
    <button class="btn_dead"><a href="deconnexion_controleur.php">Quitter ou rejouer</a></button>
    `;
    zone.innerHTML = template;

    // Ajouter les écouteurs d'événements après l'insertion et raffraichir affichage liste personnages ds la salle
    document.querySelector('.btn_dead').addEventListener('click', function() {
        zone.style.display = "none";
    });
}
