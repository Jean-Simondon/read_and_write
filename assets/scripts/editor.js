export default class Editor {

    constructor(summary)
    {
        this.currentManuscript = $('body').data('currentManuscript');
        this.popin = $('.section-edit-popin')[0];
        this.textArea = $('.section-edit-popin .form textArea')[0];
        this.currentEdit = undefined;
        this.saveButton = $('.section-edit-popin .form .save-popin-editor')[0];
        this.isOn = false;
        this.summary = summary
    }

    init()
    {
        let self = this;

        // Passage du mod edition on / off grâce au switch
        $('.edit-switch').on('click', function() {
            if( self.isOn ) {
                $(this).children()[0].innerText = "Editing is off / Switch";
                self.off();
            } else {
                $(this).children()[0].innerText = "Editing is on / Switch";
                self.on();
            }
        });

        // Apparition popin au clic sur un éditable
        $('.editable-new').on('click', function() {
            self.currentEdit = this;
            $(self.textArea).val($(self.currentEdit).text());
            $(self.popin).fadeIn();
        });
        $('.editable-new').addClass('editable');
        $('.editable').removeClass('editable-new');

        // Disparition popin au clic en dehors de la popin
        $('.close-popin').on('click', function() {
            $(self.popin).fadeOut();
            $(self.textArea).val("");
        })
        $(self.popin).on('click', function() {
            if (this !== event.target) {
                return;
            }
            $(self.textArea).val("");
            $(self.popin).fadeOut();
        });

        // Au clic sur le btn sauvegarde
        // on recopie la valeur dans le DOM et on efface la popin
        $(self.saveButton).on('click', function() {
            $(self.currentEdit).text($(self.textArea).val());
            if( $(self.currentEdit).text() == "") {
                $(self.currentEdit).text("...");
            }
            $(self.textArea).val("");
            $(self.popin).fadeOut();
            self.saveAjax(self.currentEdit);
        });

        self.initListening();

        $('.add_element').fadeOut(); // tous les élément pour ajouter doivent disparaitre
        $('.editable').addClass('editable-off'); // tous les éditable passent à -off
        $('.editable-off').removeClass('editable');
        $('.editable-off').off('click'); // on retire les évènement au clic

    }

    saveAjax(toSave)
    {
        let self = this;

        if ( $(toSave).hasClass('acte-edit') ) {

            $.ajax({
                url: `${$('body').data('urlServer')}/manuscript/edit_act/${self.currentManuscript}`,
                method: 'POST',
                data: {
                    actId: $(toSave).data('actId'),
                    actTitle: $(toSave).text(),
                },
                datatype: 'json',
            }).done(function(data) {
                console.log('acte édité');
            });

        } else if ( $(toSave).hasClass('chapter-edit') ) {

            $.ajax({
                url: `${$('body').data('urlServer')}/manuscript/edit_chapter/${self.currentManuscript}`,
                method: 'POST',
                data: {
                    chapterId: $(toSave).data('chapterId'),
                    chapterTitle: $(toSave).text(),
                },
                datatype: 'json',
            }).done(function(data) {
                console.log('chapitre édité');
            });

        } else if ( $(toSave).hasClass('scene-edit') ) {

            $.ajax({
                url: `${$('body').data('urlServer')}/manuscript/edit_scene/${self.currentManuscript}`,
                method: 'POST',
                data: {
                    sceneId: $(toSave).data('sceneId'),
                    sceneTitle: $(toSave).text(),
                },
                datatype: 'json',
            }).done(function(data) {
                console.log('scène édité');
            });

        } else if ( $(toSave).hasClass('cell-edit') ) {

            $.ajax({
                url: `${$('body').data('urlServer')}/manuscript/edit_cell/${self.currentManuscript}`,
                method: 'POST',
                data: {
                    cellId: $(toSave).data('cellId'),
                    cellContent: $(toSave).text(),
                },
                datatype: 'json',
            }).done(function(data) {
                console.log('cellules édité');
            });

        } else {

            console.log('element pas pris en charge encore');

        }
    }

    off(instant)
    {
        let self = this;
        self.isOn = false;
        if( !instant) {
            $('.add_element').fadeOut(); // tous les élément pour ajouter doivent disparaitre
        }
        $('.editable').addClass('editable-off'); // tous les éditable passent à -off
        $('.editable-off').removeClass('editable');
        $('.editable-off').off('click'); // on retire les évènement au clic
        // self.summary.listeningAct();
        // self.summary.listeningChapter();
        // self.summary.listeningScene();
    }

    on(instant)
    {
        let self = this;
        self.isOn = true;

        $('.editable-new').on('click', function() {
            self.currentEdit = this;
            $(self.textArea).val($(self.currentEdit).text());
            $(self.popin).fadeIn();
        });
        $('.editable-off').on('click', function() {
            self.currentEdit = this;
            $(self.textArea).val($(self.currentEdit).text());
            $(self.popin).fadeIn();
        });

        $('.editable-new').addClass('editable');
        $('.editable-off').addClass('editable'); // tous les élément -off passent à éditable
        $('.editable').removeClass('editable-off');
        $('.editable').removeClass('editable-new');
        
        if( !instant) {
            $('.add_element').fadeIn(); // tous les élément d'ajout doivent réapparaitre
        }
    }

    // -------------------- Listening to element that can add another ----------

    initListening()
    {
        let self = this;
        self.addActListening();
        self.addChapterListening();
        self.addSceneListening();
        self.addCellListening();
    }

    addActListening()
    {
        let self = this;
        $('.add_act').on('click', function() {
            $(this).before(`<div class="breadcrumb__item act__item"><p data-act-id="..." class="editable act-edit">...</p></div>`);
            // branchement avec l'ouverture de la popin
            $(this).prev().children().on('click', function() {
                self.currentEdit = this;
                $(self.textArea).val($(self.currentEdit).text());
                $(self.popin).fadeIn();
            });
            self.summary.addAct();
            self.summary.listeningOneAct($(this).prev()[0]);
        });
    }

    addChapterListening()
    {
        let self = this;
        $('.add_chapter').on('click', function() {
            $(this).before(`<div class="breadcrumb__item chapter__item"><p data-chapter-id="$..." class="editable chapter-edit">...</p></div>`);
            $(this).prev().children().on('click', function() {
                self.currentEdit = this;
                $(self.textArea).val($(self.currentEdit).text());
                $(self.popin).fadeIn();
            });
            self.summary.addChapter();
            self.summary.listeningOneChapter($(this).prev()[0]);
        });
    }

    addSceneListening()
    {
        let self = this;
        $('.add_scene').on('click', function() {
            $(this).before(`<div class="breadcrumb__item scene__item"><p data-scene-id="..." class="editable scene-edit">...</p></div>`);
            $(this).prev().children().on('click', function() {
                self.currentEdit = this;
                $(self.textArea).val($(self.currentEdit).text());
                $(self.popin).fadeIn();
            });
            self.summary.addScene();
            self.summary.listeningOneScene($(this).prev()[0]);
        });
    }

    addCellListening()
    {
        let self = this;
        $('.add_cell').on('click', function() {

            $(this).before(`<div data-cell-id="..." class="breadcrumb__mini-cell mini-cell__item"></div>`);

            let cardContainer = $('.section-horizontal-reader .card__list .card__wrapper')[0];
            let html = `<div class="card">
                        <div class="card__text">
                            <p data-cell-id="..." class="editable cell-edit">...</p>
                        </div>
                    </div>`;
            $(cardContainer).append(html);

            $('.section-horizontal-reader .card__list .card__wrapper .card .cell-edit').last().on('click', function() {
                self.currentEdit = this;
                $(self.textArea).val($(self.currentEdit).text());
                $(self.popin).fadeIn();
            });

            self.summary.addCell();

        });
    }

}










// if( $(element).hasClass('title--main') ) {

// } else if ( $(element).hasClass('4eme-de-couv') ) {

// } else if ( $(element).hasClass('meta-histoire') ) {

// } else if ( $(element).hasClass('acte-edit') ) {

// } else if ( $(element).hasClass('chapter-edit') ) {
    
// } else if ( $(element).hasClass('scene-edit') ) {

// } else if ( $(element).hasClass('cell-edit') ) {

// }
