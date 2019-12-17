document.addEventListener("DOMContentLoaded", function() {
    ajaxGet("https://www.prevision-meteo.ch/services/json/nantes", afficherDatasMeteo);
});

function ajaxGet(url, callback) {
    let req = new XMLHttpRequest();
    req.open("GET", url);
    req.addEventListener("load", function () {
        if (req.status >= 200 && req.status < 400) {
            // Appelle la fonction callback en lui passant la réponse de la requête
            callback(req.responseText);
        } else {
            console.error(req.status + " " + req.statusText + " " + url);
        }
    });
    req.addEventListener("error", function () {
        console.error("Erreur réseau avec l'URL " + url);
    });
    req.send(null);}

function afficherDatasMeteo(reponse) {
    let nantes = JSON.parse(reponse);
    console.log(nantes);
        let maMeteo = new Meteo(nantes);
        maMeteo.fillInfo();
        console.log(Meteo);

}







