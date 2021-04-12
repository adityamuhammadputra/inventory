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


    $('#noreg').on('keyup', function(){
        let val = $(this).val();
        if(val.length > 4){
            checkVisibleNoreg('noreg', val)
        }

        if(val.length == 1 && val == 'I' || val.length < 1)
            $(this).val('IP')

    })

    $("#addEquipment").on('click', function(){
        let countRow =  $(this).closest('table').find('tr').length
        let html = '<tr id="'+countRow+'">\
                        <td>' + countRow + '</td>\
                        <td><input type="text" class="form-control" name="equpment[' + countRow + ']"></td>\
                        <td>\
                            <div class="input-group">\
                                <input type="text" class="form-control" name="item[' + countRow + '][' + countRow + ']">\
                                <div class="input-group-prepend">\
                                    <div class="input-group-text">\
                                        <a class="addItem" data-id="' + countRow + '"><span class="fa fa-plus"></span></a>\
                                    </div>\
                                </div>\
                            </div>\
                        </td>\
                        <td><input type="text" class="form-control rupiah" name="price[' + countRow + ']"></td>\
                        <td class="text-right"><a class="removeEquipment"><i class="fa fa-trash"></i></a></td>\
                    </tr>'
        $(this).closest('table').append(html);
    })

    $(document).on('click', '.removeEquipment', function(){
        $(this).closest('tr').remove();
    })

    var countRow = 1;
    $(document).on('click', '.addItem', function(){
        countRow++
        let idRow = $(this).data('id');
        let html = '<input type="text" class="form-control" name="item['+idRow+']['+countRow+']"></a>';
        $(this).closest('td').append(html);
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
                    // toastr.info(res.barang.merk + ' Berhasil disimpan')
                    $('#form-submit')[0].reset()
                    $('.card-form').slideUp();
                },
                error: function(res) {
                    console.log(res);
                }
            });
            return false;
        }
    });

    let checkVisibleNoreg = (column, value) => {
        $.ajax({
            url: "/api/v1/check-visible-noreg",
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

    var loadingIconButton = (that, reset = false) => {
        that.attr('disabled', 'disabled')
        if(reset == true) {
            that.find('span').addClass('fa-check-circle').removeClass('spinner-border spinner-border-sm')
            that.attr('disabled', false)
            return false;
        }
        that.find('span').removeClass('fa-check-circle').addClass('spinner-border spinner-border-sm')
    }

</script>
@endpush
