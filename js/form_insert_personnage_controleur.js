// ------------------ECOUTEUR PASSWORD ---------------------------------
document.getElementById("createPassword").addEventListener("click", ()=> {
    seePassword();
})
document.getElementById("confPasswordInput").addEventListener("input", ()=> {
    comparePassword();
});
document.getElementById("identifiant").addEventListener("input", ()=> {
    compareIdentifiant();
})


// ------------------ MOT DE PASSE -------------------------------------

/**
 * role : rendre visible le mot de passe dans le champ creation mot de passe et confirmation mot de passe
 * @param : neant
 * @retuen : true si password visible sinon false
 */
function seePassword () {
    const createPasswordInput= document.getElementById ("createPasswordInput");
    const confPasswordInput = document.getElementById ("confPasswordInput");

    if (createPasswordInput.getAttribute("type") == "password") {
        createPasswordInput.setAttribute("type", "text");
        confPasswordInput.setAttribute("type", "text");
        return true;
    } else {
        createPasswordInput.setAttribute("type", "password");
        confPasswordInput.setAttribute("type", "password");
        return false
    }
}

/**
 * @returns role : comparre le password créé et le password de confirmation
 * @param : neat
 * @return : true si password identique et false sinon
 */
function comparePassword () {

    const passwordCreate = document.getElementById("createPasswordInput");
    const passwordConf = document.getElementById("confPasswordInput");
    const error = document.getElementById("errorPassword");

    if (passwordCreate.value !== passwordConf.value) {
        error.style.display = 'block';
        return false;
    } else {
        error.style.display = 'none';
        return true;
    }
}

/**
 * @returns role : verifie si le l'identifiant existe deja dans la base
 * @param : neant
 * @return : true si il n'existe pas, false sinon
 */
function compareIdentifiant () {
    login = document.getElementById("identifiant");

    fetch(`verifier_new_pseudo_personnage_controleur.php?idt=${login.value}`,
        {
        method: "GET"
        }
    )
        .then(response=>{ 
            return response.json();
        })  
        .then (response=>{
            affichageMessageErreurIdentifiant(response);
        })
        // recuperation des erreurs
        .catch(erreur=>{
            console.log(erreur);
        });
}
/**
 * role : affiche le message erreur pour l identifiant
 * @param {*} response 
 * @returns true si aucun message affiché sinon false
 */
function affichageMessageErreurIdentifiant(response) {
    if(response === false) {
        document.getElementById("errorIdentifiant").style.display = 'block';
        return false;
    } else {
        document.getElementById("errorIdentifiant").style.display = 'none';
        return true;
    }
}
// SOUMISSION DU FORMULAIRE

let monform = document.getElementById('form_create_personnage')
monform.addEventListener("submit",(event)=>{
    event.preventDefault();
    let test1 = comparePassword ();
    let test2 = affichageMessageErreurIdentifiant();
   
    console.log("non soumission");
    console.log(test1);
    console.log(test2);
    if(test1===true && 
        test2 === true
         ){
        monform.submit();
        console.log("soumission");
    }
})