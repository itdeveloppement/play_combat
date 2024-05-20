// ------------------ECOUTEUR PASSWORD ---------------------------------
document.getElementById("createPassword").addEventListener("click", ()=> {
    seePassword();
})


// ------------------ MOT DE PASSE -------------------------------------

/**
 * role : rendre visible le mot de passe dans le champ creation mot de passe et confirmation mot de passe
 * @param : neant
 * @retuen : soit type = text, soit type = password
 */
function seePassword () {
    const createPasswordInput= document.getElementById ("createPasswordInput");
    const confPasswordInput = document.getElementById ("confPasswordInput");
    if (createPasswordInput.getAttribute("type") == "password") {
        createPasswordInput.setAttribute("type", "text");
        confPasswordInput.setAttribute("type", "text");
    } else {
        createPasswordInput.setAttribute("type", "password");
        confPasswordInput.setAttribute("type", "password");
    }
}