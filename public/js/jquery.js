
// On attend que la page soit chargée
$(document).ready(function () {
    // On cache la zone de texte
    $('.contentParameters').hide();
    // toggle() lorsque le lien avec l'ID #toggler est cliqué
    $('.titleParameters').click(function () {
        $('.contentParameters').toggle('slow');
    });
    window.console&&console.log('foo');
});

 //On attend que la page soit chargée
$(document).ready(function () {
    // On cache la zone de texte
    $('.listcommentsPart').hide();
    // toggle() lorsque le lien avec l'ID #toggler est cliqué
    $('.titleCommentPart').click(function () {
        $('.listcommentsPart').toggle('slow');
    });
    window.console&&console.log('foo');
});
