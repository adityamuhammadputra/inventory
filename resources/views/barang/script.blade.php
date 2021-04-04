@push('scripts')

<script>
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

    let loadingIcon = (that, reset = false) => {
        if(reset == true) {
            that.closest('div').find('.loading-icon').remove();
            return false;
        }
        let html = '<div class="spinner-border spinner-border-sm text-secondary loading-icon" role="status">\
                    </div>';
        that.before(html);
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
                loadingIcon($('#' + column))
            },
            success: function(data) {
                loadingIcon($('#' + column), reset = true);
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

    $("#form-submit").validate();

</script>
@endpush
