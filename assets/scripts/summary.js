class book {

	constructor() {
        this.currentChapter = undefined;
        this.sceneNumber = undefined;
        this.currentScene = undefined;
        this.cells = undefined;
        this.cellNumber = undefined;
        emptyElement(document.querySelector(".summary__scene-box"));
	}

listeningChapter() {
    let self = this;
    let chapter = document.querySelectorAll(".summary__chapter");
    chapter.forEach(element =>
        element.addEventListener("click", function() {
            self.currentChapter = element.id;
            self.currentScene = undefined;
            let reader = document.querySelector('.book_scene');
            emptyElement(reader);
            self.LoadChapterScene();
    }));
}

// Callback au click sur un chapitre
// On récupère le nombre de scène pour ce chapitre
// On vide les scène, on en créer x nouvelles
// On vide les cellules
// On focus sur la première scène
// et on remplie la première scène de ses cellules
LoadChapterScene() {
    let self = this;
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/data/summary.json", true);
    xhr.addEventListener('readystatechange', function() {
        let chapters = JSON.parse(xhr.responseText);
        self.sceneNumber = chapters[self.currentChapter]['scene'];
        self.fillScene();
    });
    xhr.send(null);
}

fillScene() {
    let self = this;
    let scene_box = document.querySelector(".summary__scene-box");
    emptyElement(scene_box);
    for(let i = 1; i <= self.sceneNumber; i++) {
        let button = document.createElement('button');
        button.classList.add('summary__scene');
        button.classList.add('btn');
        button.classList.add('btn--tertiary');
        button.classList.add('btn--white');
        button.setAttribute('id', i);
        button.innerText = 'Scene ' + i;
        scene_box.appendChild(button);
        self.listeningScene();
        // plus qu'à appeler le chargement de la scène 1
    }
}

// On place un évènement au click sur chacune des scènes 
listeningScene() {
    let self = this;
    let scene = document.querySelectorAll('.summary__scene');
    scene.forEach(element => {
       element.addEventListener('click', function() {
            self.currentScene = element.id;
            self.pickScene();
       })
    });
}

// callback au clic sur une scène
// Si la scène n'est pas en focus
// On vide le lecteur de ses cellules
// On reremplie le lecteur avec les cellules de la scène en question
pickScene() {
    let self = this;
    let url = '/data/c' + self.currentChapter + 's' + self.currentScene + '.json';
    let xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.addEventListener('readystatechange', function() {
        self.cells = JSON.parse(xhr.responseText);
        self.cellNumber = Object.keys(B.cells).length;
        self.getSceneContent();
    });
    xhr.send(null);
}

// récupère le contenu d'une scène
// remplie la scène avec les cellules récupéré
getSceneContent() {
    let self = this;
    let reader = document.querySelector('.book_scene');
    emptyElement(reader);
    document.querySelector('.book').style.width = (self.cellNumber * 50) + 10 + "rem";
    let count = 1;
    for (const [key, value] of Object.entries(self.cells)) {
        let page_main = document.createElement('div');
        page_main.classList.add('book__page');
        page_main.setAttribute('data-spy', '');
        page_main.setAttribute('id', 'page_' + count);
        count++;
        let page_sub = document.createElement('div');
        page_sub.classList.add('book__page--content');
        page_sub.classList.add('book__page--action');
        let text = document.createElement('p');
        text.innerHTML = `${value}`;
        reader.appendChild(page_main);
        page_main.appendChild(page_sub);
        page_sub.appendChild(text);
    }

}

prog(w) {
    var x = document.querySelector('.summary__progress-bar');
    x.style.value = w;
}

}


var B = new book();
B.listeningChapter();


let observer = new IntersectionObserver(function (observables) {

}, {
    threshold: [0.5]
});