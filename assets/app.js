// any CSS you import will output into a single css file (app.css in this case)
import './styles/main.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
global.$ = global.jQuery = $;
import main from './scripts/main';
import Editor from './scripts/editor';
import Summary from './scripts/summary';

$(document).ready(function($) {

    main($);

    let summ = new Summary();
    let editor = new Editor(summ);
    
    summ.editor = editor;

    editor.init();
    summ.listeningAct();

});
