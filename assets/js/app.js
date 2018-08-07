// main.js

// Jquery
var $ = require('jquery');

// Boostrap 4
require('bootstrap');

// Iconos fontawesome
//import fontawesome from '@fortawesome/fontawesome';
//import { faPlus, faEye, faEdit, faTrash, faList, faSave, faHome, faAddressBook, faUser, faSignOutAlt } from '@fortawesome/fontawesome-free-solid';
//fontawesome.library.add(faPlus, faEye, faEdit, faTrash, faList, faSave, faHome, faAddressBook, faUser, faSignOutAlt );

// Imágenes
//require('../img/x-office-address-book.png');
require('../img/agenda2.png');
//require('../img/user-id.png');

// Tooltips
$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
