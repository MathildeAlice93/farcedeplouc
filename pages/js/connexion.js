window.onload = function() {
    history.replaceState('', '', '');
}
function error($element_faux) {
    var elem = document.getElementById($element_faux);
    elem.style.backgroundColor = "red";
}
function setValue($id, $valeur) {
    var elem = document.getElementById($id);
    elem.setAttribute("value", $valeur);
}
function setOption($id) {
    var elem = document.getElementById($id);
    elem.setAttribute("selected", "selected");
}
//NB : le js ne nécessite pas de balise
//Pour écrire en js deux options 
//1. Ecrire dans un fichier .js
//2. L'inclure dans des balises <script> au html qui se trouve dans le php