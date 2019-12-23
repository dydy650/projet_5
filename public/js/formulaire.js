//TEST//
var validation =  document.getElementById('bouton_envoi');
var username =  document.getElementById('username');
var nom =  document.getElementById('nom');
var prenom =  document.getElementById('prenom');
var city =  document.getElementById('city');
var password =  document.getElementById('password');
var password2 =  document.getElementById('password2');
//
var birthday_date =  document.getElementById('birthday_date');
var code_parrainage =  document.getElementById('code_parrainage');
var missing_info=  document.getElementById('missing_info');

//////////////////////////////////////////////////////////////////////

//LONGUEUR PASSWORD
var passwordElt = document.getElementById('password');
// Vérification de la longueur du mot de passe saisi
document.getElementById("password").addEventListener("input", function (e) {
    var mdp = e.target.value; // Valeur saisie dans le champ mdp
    var longueurMdp = "faible";
    var couleurMsg = "red"; // Longueur faible => couleur rouge
    if (mdp.length >= 8) {
        longueurMdp = "suffisante";
        couleurMsg = "green"; // Longueur suffisante => couleur verte
    } else if (mdp.length >= 4) {
        longueurMdp = "moyenne";
        couleurMsg = "orange"; // Longueur moyenne => couleur orange
    }
    var aideMdpElt = document.getElementById("aideMdp");
    aideMdpElt.textContent = "Sécurité : " + longueurMdp; // Texte de l'aide
    aideMdpElt.style.color = couleurMsg; // Couleur du texte de l'aide
});


//VERIFICATION PASSWORD
function verifMdp(){
var password =  document.getElementById('password').value;
var password2 =  document.getElementById('password2').value;

    if (password === password2)
    {
        var message = "mots de passe correspondant";
    }else{
        alert("Erreur les 2 mots de passe ne correspondent pas");
    }
    document.getElementById("infoMdp").textContent = message;
    verifMdp.preventDefault(); //On utilise la fonction preventDefault de notre objet event pour empêcher le comportement par défaut de cet élément lors du clic de la souris
}

//VERIFICATION EMAIL
function verifEmail(champ) {

    var regexCourriel = /.+@.+\..+/;
    if (!regexCourriel.test(champ.value)){
        alert("Adresse invalide");
    }else {
        var message = "adresse valide";
    }
        document.getElementById("aideCourriel").textContent = message;
}
// Correspond à une chaîne de la forme xxx@yyy.zzz