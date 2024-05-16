/**
 * Role :  appel le controleur pour l'action avancer 
 * Parm : neant
 */

document.getElementById("btnAvancer").addEventListener("click", ()=> {
    avancer();
});
document.getElementById("btnReculer").addEventListener("click", ()=> {
    reculer();
});

//------------------------ MOUVEMENT ---------------------------------
/**
 * Role :  appel le controleur pour l'evenement avancer du personnage
 * Parm : neant
 * return : 
 */
function avancer() {
    console.log("test");
   // Appeler le controleur php lister_contacts_fragment.php
    fetch("update_avancer_personnage_controleur.php")
        .then(response=>{
            console.log(response);
            return response.text();
            // Si json : return response.json();
        
        })
        .then();
};

/**
 * Role :  appel le controleur php pour l'evenement reculer du personnage
 * Parm : neant
 * return : 
 */
function reculer() {
    console.log("test");
   // Appeler le controleur lister_contacts_fragment.php
    fetch("update_reculer_personnage_controleur.php")
        .then(response=>{
            console.log(response);
            return response.text();
            // Si json : return response.json();
        
        })
        .then();
};

