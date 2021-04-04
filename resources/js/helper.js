$(document).on('click','.deleteData', function(){
    let id  = $(this).data('id');
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
                url: "/api/v1/barang/" + id,
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



