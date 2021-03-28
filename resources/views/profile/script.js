
$('.userEdit').on('click', function(){
    alert('c')
})

var Typed = require( 'typed.js' );
var options = {
    strings: ['Suka sama kamu huhu.', 'Suka sama dia huhu.'],
    typeSpeed: 40,
    loop: true,
    cursorChar: ' ',
};

var typed = new Typed('.notes', options);
