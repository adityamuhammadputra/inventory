@push('scripts')

<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        urlTable = "{{ url('api/v1/item/datatable') }}?" + $('#wrap-filter').serialize();
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
            generateBarcode(val)
        }

        if(val.length == 1 && val == 'I' || val.length < 1)
            $(this).val('IP')

    })

    let generateBarcode = (kode) => {
        $.ajax({
            url: "/api/v1/generate-barcode/" + kode,
            method : 'GET',
            beforeSend: function() {
                // $('#wrap-barcode').html(loadingBarcode(50))
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

    let loadingBarcode = (wh) => {
        let html = '<div class="text-center pt-5">\
                        <div class="spinner-grow text-secondary mr-3 wh-' + wh + '" role="status">\
                        </div>\
                        <div class="spinner-grow text-secondary mr-3 wh-' + wh + '" role="status">\
                        </div>\
                        <div class="spinner-grow text-secondary mr-3 wh-' + wh + '" role="status">\
                        </div>\
                    </div>'

        return html;
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
                if(data)
                    $('#' + column).css('border-color', 'red')
                else
                    $('#' + column).removeAttr('style')

            },
            error: function(error) {
                console.log(error)
            }
        })
    }

</script>
@endpush
