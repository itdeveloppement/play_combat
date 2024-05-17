/**
 * Role :  initialise la partie js de l'application 
 * Parm : neant
 */

// ------------------ECOUTEUR ---------------------------------
document.getElementById("btnAvancer").addEventListener("click", ()=> {
    avancer();
});
document.getElementById("btnReculer").addEventListener("click", ()=> { 
    reculer();
});
document.getElementById("btnForce").addEventListener("click", ()=> { 
    force();
});
document.getElementById("btnResistance").addEventListener("click", ()=> { 
    resistance();
});

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

            affichageHistorique(response.historique);
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
            affichageHistorique(response.historique);
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
            console.log(response);
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
            // console.log(response);
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

/** OBSOLETTE
 * Role : affiche la mise à jour de l'historique
 * @param {Objet} l'iobjet contenant les données de l'historique
 * @return
 */
function affichageHistorique(historiques){
    // mise à jour numero de salle
    zone = document.getElementById("zone");
    let template = '';
    historiques.forEach (function (historique) {
        template +=
        `
        <tr>
            <td> ${historique.evenement !== null ? historique.evenement : ''} </td>
                <td> ${historique.salle !== null ? historique.salle : ''} </td>
                <td> ${historique.adverssaire !== null ? historique.adverssaire : ''} </td>
                <td> ${historique.pts_vie !== null ? historique.pts_vie : ''} </td>
                <td> ${historique.pts_force !== null ? historique.pts_force : ''} </td>
                <td> ${historique.pts_agilite !== null ? historique.pts_agilite : ''} </td>
                <td> ${historique.pts_resistance !== null ? historique.pts_resistance : ''} </td>
            </tr>
        `;
    zone.innerHTML = template;
});
}

// ------------------ MODIFICATION AFFICHAGE ----------------------
/** OBSOLETTE
 * Role : affiche la mise à jour des points de vie et du numero de la salle
 * @param {Objet} response 
 * @return
 */
function affichageModifTest(response){
    // mise à jour numero de salle
    zone1 = document.getElementById("zone1");
    let template = `Salle numéro : ${response.salle}</p>`;
    zone1.innerHTML = template;
    // mise à jour pts de vie
    zone2 = document.getElementById("zone2");
    let  template2 = 
    `
    <label for="ptsVie">Points de vie : </label>
    <progress id="ptsVie" value="${response.pts_vie}" max="100"></progress>
    `;
    zone2.innerHTML = template2;
};


/** OBSOLETTE
 * Role : affiche la mise à jour des caracteristique d'un personnage
 * @param {Objet} response 
 * @return
 */
function caracteristiquePersonnage(response){
    document.getElementById('salle').textContent = response.salle;
    document.getElementById('ptsVie').textContent = response.pts_vie;
    document.getElementById('ptsAgilite').value = response.pts_agilite;
    document.getElementById('ptsAgilite2').textContent = response.pts_agilite;
    document.getElementById('ptsForce').value = response.pts_force;
    document.getElementById('ptsForce2').textContent = response.pts_force;
};


