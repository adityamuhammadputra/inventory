// require('./bootstrap');

// require( 'datatables.net' );
require( 'datatables.net-bs4' );
window.$ = require('jquery');
window.validate = require('./jquery.validate');
window.Typed = require( 'typed.js' );
window.swal = require( 'sweetalert' );
window.toastr = require( 'toastr' );
window.select2 = require( 'select2' );

window.autoNumeric = require('autonumeric');

const autoNumericRupiah = {
    digitGroupSeparator        : '.',
    decimalCharacter           : ',',
    decimalCharacterAlternative: '.',
    currencySymbol             : 'Rp. ',
};

new autoNumeric('.rupiah', autoNumericRupiah);

require( './helper' );


import "mdi-icons/css/materialdesignicons.min.css";
// require('../views/profile/script');


