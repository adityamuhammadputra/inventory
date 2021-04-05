$(document).on('click','.deleteData', function(){
    let id  = $(this).data('id');
    let url  = $(this).data('url');
    let title = 'Anda yakin menghapus data ' + $(this).data('title');
    swal({
        title: "Konfirmasi",
        text: title,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    '_method' : 'DELETE',
                },
                success: function(res){
                    toastr.info('Data Berhasil Dihapus')
                    table.api().ajax.reload()
                },
                error: function(){
                }
            })
        }
    });
});


$('.card-header-down').on('click', function(){
    let cardBody = $(this).closest('.card').find('.card-body');
    if(cardBody.attr('style') != '')
        cardBody.slideDown();
    else
        cardBody.slideUp();
})


$('.filter-icon').on('click', function(){
    $('.card-filter').slideDown();
})

$('#btn-add').on('click', function(){
    $('.card-add').slideDown();
})


const autoNumericRupiah = {
    digitGroupSeparator        : '.',
    decimalCharacter           : ',',
    floatPos                   : true,
    currencySymbol             : 'Rp. ',
};

if ($(".card-body .rupiah")[0]){
    new autoNumeric('.rupiah', autoNumericRupiah);
}

if ($(".card-body .rupiahFilter")[0]) {
    new autoNumeric('.rupiahFilter', autoNumericRupiah);
}



