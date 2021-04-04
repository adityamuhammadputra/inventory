@push('scripts')

<script>
    var table;
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        urlTable = "{{ url('api/v1/barang/datatable') }}?" + $('#wrap-filter').serialize();
        table = $('#dataTable').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : urlTable,
                method: 'POST'
            },
            columns: [
                {
                    data: null,
                    searchable:false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'barcode',
                    orderable:false,
                    searchable:false,
                },
                { data: 'kode'},
                { data: 'jenis'},
                { data: 'merk'},
                { data: 'type'},
                { data: 'serial_number'},
                { data: 'harga'},
                { data: 'status_label'},
                {
                    data: 'action',
                    orderable:false,
                    searchable:false,
                },
                { data: 'created_at', searchable:false, visible:false},
            ],
            order:[[10, 'desc']],
        });
    });

    $('#kode').on('keyup', function(){
        let val = $(this).val();
        if(val.length > 4){
            checkVisibleBarang('kode', val)
            generateBarcodeTemp(val)
        }

        if(val.length == 1 && val == 'I' || val.length < 1)
            $(this).val('IP')

    })

    $("#form-submit").validate({
        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: function(){
                    loadingIconButton($('#submit'))
                },
                success: function(res) {
                    table.api().ajax.reload()
                    loadingIconButton($('#submit'), reset = true)
                    toastr.info(res.barang.merk + ' Berhasil disimpan')
                    generateBarcodeTemp(res.maxKode)
                    $('#form-submit')[0].reset()
                    $('#kode').val(res.maxKode)
                    $('.card-add').slideUp();
                },
                error: function(res) {
                    console.log(res);
                }
            });
            return false;
        }
    });

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
            // jconfirm.defaults.content = isicontent;
            // // jconfirm.defaults.type = 'red';
            // $.confirm({
            //     buttons: {
            //         confirm: {
            //             btnClass: 'btn-info',
            //             action: function(){
            //                 $.ajax({
            //                     url: "{{ url('master') }}/" +id+'/'+type,
            //                     type: "DELETE",
            //                     success: function(data){
            //                         berhasil(data,pesan=' Berhasil dihapus', table='#data-register', form=null);
            //                     },
            //                     error: function(){
            //                         alert(alerterror);
            //                     }
            //                 })
            //             }
            //         },

            //         batal: function () {
            //         },
            //     }
            // });
        });


    let generateBarcode = (kode) => {
        $.ajax({
            url: "/api/v1/generate-barcode/" + kode,
            method : 'GET',
            beforeSend: function() {
            },
            success: function(data) {
                setTimeout(function(){
                    $('#wrap-barcode').html('<img src= "' + data.path +'" style="width:100%;">')
                }, 1000);
            },
            error: function(error) {
                console.log(error)
            }
        })
    }

    let generateBarcodeTemp = (kode) => {
        setTimeout(function(){
            $('#label-barcode').html(kode)
        }, 500);
    }

    let loadingIconText = (that, reset = false) => {
        if(reset == true) {
            that.closest('div').find('.loading-icon').remove();
            return false;
        }
        let html = '<div class="spinner-border spinner-border-sm text-secondary loading-icon" role="status">\
                    </div>';
        that.before(html);
    }

    let loadingIconButton = (that, reset = false) => {
        if(reset == true) {
            that.find('i').addClass('fa-check-circle').removeClass('spinner-border spinner-border-sm')
            return false;
        }
        that.find('i').removeClass('fa-check-circle').addClass('spinner-border spinner-border-sm')
    }


    let checkVisibleBarang = (column, value) => {
        $.ajax({
            url: "/api/v1/check-visible-barang",
            method : 'GET',
            data: {
                'column' : column,
                'value' : value,
            },
            beforeSend: function() {
                loadingIconText($('#' + column))
            },
            success: function(data) {
                loadingIconText($('#' + column), reset = true);
                if(data) {
                    $('#' + column).css('border-color', '#bd2130')
                    $('#' + column +'-has-value').html(column + ' already available').show()
                } else {
                    $('#' + column).removeAttr('style')
                    $('#' + column +'-has-value').hide()
                }
            },
            error: function(error) {
                console.log(error)
            }
        })
    }

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

    // jQuery(function($) {
    //     $('.rupiah').autoNumeric('init');
    // });


</script>
@endpush
