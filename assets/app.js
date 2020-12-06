// any CSS you import will output into a single css file (app.css in this case)
import './styles/main.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

import main from './scripts/main';

$(document).ready(function($) {
    main($);
});
