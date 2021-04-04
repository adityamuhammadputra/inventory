
const autoNumericRupiah = {
    digitGroupSeparator        : '.',
    decimalCharacter           : ',',
    floatPos                   : true,
    currencySymbol             : 'Rp. ',
};

new autoNumeric('.rupiah', autoNumericRupiah);
new autoNumeric('.rupiahFilter', autoNumericRupiah);

