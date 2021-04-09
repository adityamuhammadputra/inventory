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
    $('.card-form').slideDown();
    $('.card-form').find('form [name="_method"]').val('POST')
    $('.card-form').find('form').attr('action', $(this).data('action'))
})

$('#btn-cancel').on('click', function(){
    $('.card-form').slideUp();
    if($(this).data('max-kode') == true)
        var kodeTemp = $(this).closest('form').find('#kode').val();
    $(this).closest('form')[0].reset();
    $(this).closest('form')[0].reset();
    if($(this).data('max-kode') == true)
        getMaxKode(kodeTemp);

    $(this).closest('form').attr('action', $(this).data('action'))
    $(this).closest('form').find('[name="_method"]').val('POST')
})

$(document).on('click', '.editData', function(){
    let url =  $(this).data('url');
    $.ajax({
        url: url,
        method : 'GET',
        success: function(res) {
            $('.card-form').slideDown();
            for (var key in res.data)  {
                if (!res.data.hasOwnProperty(key)){
                    continue;
                }
                $("#" + key).val(res.data[key])

                if($(".card-form select")[0])
                    $("#" + key).val(res.data[key]).trigger('change')
            };

            if($(".card-body #label-barcode")[0])
                $('#label-barcode').html(res.data.kode)

            $('.card-form').find('form').attr('action', res.action)
            $('.card-form').find('form [name="_method"]').val('PATCH')
            $("html, body").animate({ scrollTop: 0 }, "slow");
        },
        error: function(error) {
            console.log(error)
        }
    })
})


let getMaxKode = (kode) => {
    $.ajax({
        url: '/api/v1/barang/max-kode/' + kode,
        type: "GET",
        success: function(res){
            $('#kode').val(res)
            $('#label-barcode').html(res)
        },
        error: function(res){
            console.log(res);
        }
    })
}

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



