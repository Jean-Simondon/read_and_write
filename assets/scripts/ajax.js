function getContentByAjax(chapter, scene) {
    let requete = new XMLHttpRequest();
    requete.open("GET", "../data/c" + chapter + "s" + scene + ".json", true);
    requete.send(null);
    let contenu = requete.responsetText;
    contenu = JSON.parse(contenu);
    return contenu;
}