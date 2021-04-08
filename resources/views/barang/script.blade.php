@push('scripts')

<script>
    var table;
    var urlTable = "{{ url('api/v1/barang/datatable') }}?" + $('#wrap-filter').serialize();
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
                { data: 'created_at', searchable:false },
                {
                    data: 'action',
                    orderable:false,
                    searchable:false,
                },
            ],
            order:[[9, 'desc']],
        });
    });

    $('#status-filter, #jenis-filter').on('change', function(){
        table.api(urlTable).ajax.url("{{ url('api/v1/barang/datatable') }}?" + $('#wrap-filter').serialize()).load();
    })
    $('#harga-filter').on('keyup', function(){
        table.api(urlTable).ajax.url("{{ url('api/v1/barang/datatable') }}?" + $('#wrap-filter').serialize()).load();
    })


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
                    $('.card-form').slideUp();
                },
                error: function(res) {
                    console.log(res);
                }
            });
            return false;
        }
    });

    $(document).on('click', '.editData', function(){
        let url =  $(this).data('url');
        $.ajax({
            url: url,
            method : 'GET',
            success: function(res) {
                $('.card-form').slideDown();
                $("#kode").val(res.barang.kode)
                $('#label-barcode').html(res.barang.kode)
                $("#jenis").val(res.barang.jenis)
                $("#merk").val(res.barang.merk)
                $("#type").val(res.barang.type)
                $("#serial_number").val(res.barang.serial_number)
                $("#harga").val(res.barang.harga)
                $("#harga").val(res.barang.harga)

                $('.card-form').find('form').attr('action', res.action)
                $('.card-form').find('form').attr('method', 'PATCH')
            },
            error: function(error) {
                console.log(error)
            }
        })
    })

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


    var loadingIconText = (that, reset = false) => {
        if(reset == true) {
            that.closest('div').find('.loading-icon').remove();
            return false;
        }
        let html = '<div class="spinner-border spinner-border-sm text-secondary loading-icon" role="status">\
                    </div>';
        that.before(html);
    }

    var loadingIconButton = (that, reset = false) => {
        that.attr('disabled', 'disabled')
        if(reset == true) {
            that.find('span').addClass('fa-check-circle').removeClass('spinner-border spinner-border-sm')
            that.attr('disabled', false)
            return false;
        }
        that.find('span').removeClass('fa-check-circle').addClass('spinner-border spinner-border-sm')
    }


    // jQuery(function($) {
    //     $('.rupiah').autoNumeric('init');
    // });


</script>
@endpush
