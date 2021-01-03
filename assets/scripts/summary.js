export default class Summary {

    constructor()
    {
        this.currentManuscript = $('body').data('currentManuscript');
        this.currentAct = undefined;
        this.currentChapter = undefined;
        this.currentScene = undefined;
        this.sceneNumber = undefined;
        this.cells = undefined;
        this.cellNumber = undefined;
    }

    listeningAct()
    {
        let self = this;
        $('.breadcrumb__item.act__item').each(function(index, el) {
            $(el).on('click', function() {
                self.deleteCurrentAct();
                self.setCurrentAct(el);
                self.deleteCurrentChapter();
                self.deleteCurrentScene();
                $('.breadcrumb__item.chapter__item').remove();
                $('.breadcrumb__item.scene__item').remove();
                $('.breadcrumb__item.mini-cell__item').remove();
                $('.section-horizontal-reader .card__list .card__wrapper').empty();
                self.loadChapters();
            })
        });
    }

    listeningOneAct(act)
    {
        console.log(act);
        let self = this;
        $(act).on('click', function() {
            self.deleteCurrentAct();
            self.setCurrentAct(act);
            self.deleteCurrentChapter();
            self.deleteCurrentScene();
            $('.breadcrumb__item.chapter__item').remove();
            $('.breadcrumb__item.scene__item').remove();
            $('.breadcrumb__item.mini-cell__item').remove();
            $('.section-horizontal-reader .card__list .card__wrapper').empty();
            self.loadChapters();
        })
    }

    listeningChapter()
    {
        let self = this;
        $('.breadcrumb__item.chapter__item').each(function(index, el) {
            $(el).on('click', function() {
                self.deleteCurrentChapter();
                self.setCurrentChapter(el);
                self.deleteCurrentScene();
                $('.breadcrumb__item.scene__item').remove();
                $('.breadcrumb__item.mini-cell__item').remove();
                $('.section-horizontal-reader .card__list .card__wrapper').empty();
                self.loadScenes();
            })
        });
    }

    listeningOneChapter(chapter)
    {
        let self = this;
        $(chapter).on('click', function() {
            self.deleteCurrentChapter();
            self.setCurrentChapter(chapter);
            self.deleteCurrentScene();
            $('.breadcrumb__item.scene__item').remove();
            $('.breadcrumb__item.mini-cell__item').remove();
            $('.section-horizontal-reader .card__list .card__wrapper').empty();
            self.loadScenes();
        })
    }

    listeningScene()
    {
        let self = this;
        $('.breadcrumb__item.scene__item').each(function(index, el) {
            $(el).on('click', function() {
                self.deleteCurrentScene();
                self.setCurrentScene(el);
                $('.breadcrumb__item.mini-cell__item').remove();
                $('.section-horizontal-reader .card__list .card__wrapper').empty();
                self.loadCells();
            })
        });
    }

    listeningOneScene(scene)
    {
        let self = this;
        $(scene).on('click', function() {
            self.deleteCurrentScene();
            self.setCurrentScene(scene);
            $('.breadcrumb__item.mini-cell__item').remove();
            $('.section-horizontal-reader .card__list .card__wrapper').empty();
            self.loadCells();
        })
    }

    loadChapters()
    {
        let self = this;
        $.ajax({
            url: `${$('body').data('urlServer')}/manuscript/chapters/${self.currentManuscript}`,
            method: 'POST',
            data: {
                currentAct: self.currentAct,
            },
            datatype: 'json',
        }).done(function(data) {
            self.fillChapter(data);
            if(self.editor.isOn) {
                self.editor.off('instant');
                self.editor.on('instant');
            }
        });
    }

    loadScenes()
    {
        let self = this;
        $.ajax({
            url: `${$('body').data('urlServer')}/manuscript/scenes/${self.currentManuscript}`,
            method: 'POST',
            data: {
                currentChapter: self.currentChapter,
            },
            datatype: 'json',
        }).done(function(data) {
            self.fillScene(data);
            if(self.editor.isOn) {
                self.editor.off('instant');
                self.editor.on('instant');
            }
        });
    }

    loadCells()
    {
        let self = this;
        $.ajax({
            url: `${$('body').data('urlServer')}/manuscript/cells/${self.currentManuscript}`,
            method: 'POST',
            data: {
                currentScene: self.currentScene,
            },
            datatype: 'json',
        }).done(function(data) {
            self.fillCell(data);
            if(self.editor.isOn) {
                self.editor.off('instant');
                self.editor.on('instant');
            }
        });
    }

    fillChapter(data)
    {
        let self = this;
        $('.breadcrumb__item.chapter__item').remove();
        let html = '';
        for (let i = 0; i < data.length; i++) {
            html = `<div data-chapter-id="${ data[i].id }" class="breadcrumb__item chapter__item">
                        <p data-chapter-id="${ data[i].id }" class="editable-off chapter-edit">${data[i].title}</p>
                    </div>`;
            $('.add_chapter').before(html);
        }
        self.listeningChapter();
    }

    fillScene(data)
    {
        let self = this;
        $('.breadcrumb__item.scene__item').remove();
        let html = '';
        for (let i = 0; i < data.length; i++) {
            html = `<div data-scene-id="${data[i].id}" class="breadcrumb__item scene__item">
                        <p data-scene-id="${data[i].id}" class="editable-off scene-edit">${data[i].title}</p>
                    </div>`;
            $('.add_scene').before(html);
        }
        self.listeningScene();
    }

    fillCell(data)
    {
        let self = this;

        let cardContainer = $('.section-horizontal-reader .card__list .card__wrapper')[0];

        $('.breadcrumb__mini-cell').remove();
        $(cardContainer).empty();

        for (let i = 0; i < data.length; i++) {
            $('.add_cell').before(`<div data-cell-id="${data[i].id}" class="breadcrumb__mini-cell mini-cell__item"></div>`);
        }

        let html = '';
        for (let i = 0; i < data.length; i++) {
            html = `<div class="card">
                        <div class="card__text">
                            <p data-cell-id="${data[i].id}" class="editable-off cell-edit">${data[i].text_content}</p>
                        </div>
                    </div>`;
            $(cardContainer).append(html);
        }
    }

    addAct()
    {
        let self = this;
        $.ajax({
            url: `${$('body').data('urlServer')}/manuscript/new_act/${self.currentManuscript}`,
            method: 'POST',
            data: {
                currentAct: self.currentAct,
            },
            datatype: 'json',
        }).done(function(data) {
            console.log('Nouvel acte ajouté');
            $('.add_act').prev().children().data("actId", data.id);
        });
    }

    addChapter()
    {
        let self = this;
        $.ajax({
            url: `${$('body').data('urlServer')}/manuscript/new_chapter/${self.currentManuscript}`,
            method: 'POST',
            data: {
                currentAct: self.currentAct,
            },
            datatype: 'json',
        }).done(function(data) {
            console.log('Nouveau chapitre ajouté');
            $('.add_chapter').prev().children().data("chapterId", data.id);
        });
    }

    addScene()
    {
        let self = this;
        $.ajax({
            url: `${$('body').data('urlServer')}/manuscript/new_scene/${self.currentManuscript}`,
            method: 'POST',
            data: {
                currentChapter: self.currentChapter,
            },
            datatype: 'json',
        }).done(function(data) {
            console.log('Nouvelle scène ajoutée');
            $('.add_scene').prev().children().data("sceneId", data.id);
        });
    }

    addCell()
    {
        let self = this;
        $.ajax({
            url: `${$('body').data('urlServer')}/manuscript/new_cell/${self.currentManuscript}`,
            method: 'POST',
            data: {
                currentScene: self.currentScene,
            },
            datatype: 'json',
        }).done(function(data) {
            console.log('Nouvelle cellule ajoutée');
            $('.add_cell').prev().children().data("cellId", data.id);
            $('.section-horizontal-reader .card__list .card__wrapper .card .cell-edit').last().data("cellId", data.id);
        });
    }

    setCurrentAct(el)
    {
        let self = this;
        self.currentAct = $(el).children().data('actId');
        $(el).addClass("current");
    }

    deleteCurrentAct()
    {
        let self = this;
        self.currentAct = undefined;
        $('.breadcrumb__list.breadcrumb__list-act .current').removeClass("current");
    }

    setCurrentChapter(el)
    {
        let self = this;
        self.currentChapter = $(el).children().data('chapterId');
        $(el).addClass("current");
    }

    deleteCurrentChapter()
    {
        let self = this;
        self.currentChapter = undefined;
        $('.breadcrumb__list.breadcrumb__list-chapter .current').removeClass("current");
    }

    setCurrentScene(el)
    {
        let self = this;
        self.currentScene = $(el).children().data('sceneId');
        $(el).addClass("current");
    }

    deleteCurrentScene()
    {
        let self = this;
        self.currentScene = undefined;
        $('.breadcrumb__list.breadcrumb__list-scene .current').removeClass("current");
    }

}
