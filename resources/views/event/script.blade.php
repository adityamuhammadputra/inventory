@push('scripts')
<script>
    var table;
    var urlTable = "{{ url('event/datatable') }}?" + $('#wrap-filter').serialize();
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
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'noreg',
                    render: function (data, type, row, meta) {
                        return '#' + data;
                    }
                },
                {
                    data: 'vendor_name',
                },
                {
                    data: 'client_name',
                },
                {
                    data: 'name',
                    render: function (data, type, row, meta) {
                        return data + '<br><i class="fa fa-map-pin"></i> ' + row.location;
                    }
                },
                {
                    data: 'date',
                    render: function (data, type, row, meta) {
                        return data + ' ' + row.time;
                    },

                },
                {
                    data: 'count_op',
                    className: 'text-center'
                },
                {
                    data: 'count_equipment',
                    className: 'text-center'
                },
                {
                    data: 'count_item',
                    className: 'text-center'
                },
                {
                    data: 'sub_total_all',
                },
                {
                    data: 'diskon',
                    render: function (data, type, row, meta) {
                        return '<code>' + data + '%</code>';
                    },
                    className: 'text-center'
                },
                { data: 'total'},
                { data: 'created_at', searchable:false },
                {
                    data: 'action',
                    orderable:false,
                    searchable:false,
                },
            ],
            order:[[12, 'desc']],
        });
    });

    $('#aproved-filter').on('change', function(){
        console.log('x')
        table.api(urlTable).ajax.url("{{ url('api/v1/barang/datatable') }}?" + $('#wrap-filter').serialize()).load();
    })
    $('#total-filter').on('keyup', function(){
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

    var id
    var countRow = 1;
    $("#addEquipment").on('click', function(){
        countRow++
        valueDay = $('.day1').val();
        let html = '<tr id="'+countRow+'">\
                        <td class="text-center">' + countRow + '</td>\
                        <td><input type="text" class="form-control autoCompleteEquipment equipment' + countRow + '" dataid="' + countRow + '" name="equpment[' + countRow + ']"></td>\
                        <td>\
                            <div class="input-group">\
                                <input type="text" class="form-control autoCompleteItem item' + countRow + '" dataid="' + countRow + '" name="item[' + countRow + '][' + countRow + ']">\
                                <div class="input-group-prepend">\
                                    <div class="input-group-text">\
                                        <a class="addItem" data-id="' + countRow + '"><span class="fa fa-plus"></span></a>\
                                    </div>\
                                </div>\
                            </div>\
                        </td>\
                        <td>\
                            <input type="number" class="form-control day day'+countRow+' text-center valid" name="day['+countRow+']" dataid="'+countRow+'" tabindex="2000" value="'+valueDay+'" aria-invalid="false">\
                        </td>\
                        <td><input type="text" class="form-control price price' + countRow + ' rupiah text-right" name="price[' + countRow + ']" tabindex="2001"></td>\
                        <td class="text-center"><a class="removeEquipment" data-id="' + countRow + '"><i class="fa fa-trash"></i></a></td>\
                    </tr>'
        $(this).closest('table').append(html);
        $('input[name="equpment[' + countRow + ']"]').focus();
        setAutoCompleteEquipment()
        setAutoCompleteItem()
    })

    var countRow = 1;
    $(document).on('click', '.addItem', function(){
        countRow++
        let idRow = $(this).data('id');
        // <input type="text" class="form-control autoCompleteItem item' + idRow + '" dataid="' + idRow + '" name="item['+idRow+']['+countRow+']">
        let html = '<div class="input-group">\
                        <input type="text" class="form-control autoCompleteItem item' + idRow + '" dataid="' + idRow + '" name="item[' + idRow + '][' + countRow + ']">\
                        <div class="input-group-prepend">\
                            <div class="input-group-text">\
                                <a class="removeItem" data-id="' + idRow + '"><span class="fa fa-trash"></span></a>\
                            </div>\
                        </div>\
                    </div>';
        $(this).closest('td').append(html);
        $('input[name="item[' + idRow + '][' + countRow + ']"]').focus();
        setAutoCompleteItem()
    })

    var idRow = 1;
    $(document).on('click', '.addOp', function(){
        idRow++
        let html = '<tr id="1">\
                        <td class="text-center">' + idRow + '</td>\
                        <td>\
                            <input type="text" class="form-control autoCompleteOp op' + idRow + '" dataid="' + idRow + '" name="op[' + idRow + ']" tabindex="[' + idRow + ']">\
                        </td>\
                        <td>\
                            <input type="number" class="form-control dayOp dayOp' + idRow + ' text-ceneter" name="dayOp[' + idRow + ']" tabindex="[' + idRow + ']00" dataid="' + idRow + '" value="1">\
                        </td>\
                        <td>\
                            <div class="input-group">\
                                <input type="text" class="form-control rupiah priceOp priceOp' + idRow + ' text-right" name="priceOp[' + idRow + ']" tabindex="[' + idRow + ']01">\
                                <div class="input-group-prepend">\
                                    <div class="input-group-text">\
                                        <a class="removeOp" data-id="' + idRow + '"><span class="fa fa-trash"></span></a>\
                                    </div>\
                                </div>\
                            </div>\
                        </td>\
                    </tr>';
        $(this).closest('table').append(html);
        $('input[name="op[' + idRow + ']"]').focus();

        setAutoCompleteOp()
    })

    $('.autocompleteNama').autocomplete({
        lookup: function (query, done) {
            $.ajax({
                url: '/api/v1/lookup-client',
                dataType: "json",
                data: {
                    q : query
                },
                success: function(data) {
                    done(data);
                }
            });
        },
        onSelect: function (suggestion) {
            let data = suggestion.data;
        },
        minChars : 2,
    });

    $('.autocompleteVendor').autocomplete({
        lookup: function (query, done) {
            $.ajax({
                url: '/api/v1/lookup-vendor',
                dataType: "json",
                data: {
                    q : query
                },
                success: function(data) {
                    done(data);
                }
            });
        },
        onSelect: function (suggestion) {
            let data = suggestion.data;
        },
        minChars : 2,
    });

    let setAutoCompleteOp = () => {
        $('.autoCompleteOp').autocomplete({
            lookup: function (query, done) {
                $.ajax({
                    url: '/api/v1/lookup-operator',
                    dataType: "json",
                    data: {
                        q : query,
                    },
                    success: function(data) {
                        done(data);
                    }
                });
            },
            onSelect: function (suggestion, that) {
                let data = suggestion.data;
                $(that.element).val(data.tugas + ' - ' + data.kode + ' - ' + data.nama + ' - ' + data.harga);
                let $this = that.element.attributes;
                let id = $this.dataid.value;
                setPrice(id);
            },
            minChars : 2,
            lookupLimit : 10,
            noSuggestionNotice: 'Sorry, no matching results',
        });
    }
    setAutoCompleteOp()

    let setAutoCompleteEquipment = () => {
        $('.autoCompleteEquipment').autocomplete({
            lookup: function (query, done) {
                $.ajax({
                    url: '/api/v1/lookup-barang',
                    dataType: "json",
                    data: {
                        q : query,
                        kategori : 'EP'
                    },
                    success: function(data) {
                        done(data);
                    }
                });
            },
            onSelect: function (suggestion, that) {
                let data = suggestion.data;
                $(that.element).val(data.kode + ' - ' + data.jenis + ' ' + data.merk + ' - ' + data.harga);
                let $this = that.element.attributes;
                let id = $this.dataid.value;
                setPrice(id);
            },
            minChars : 2,
            lookupLimit : 10,
            noSuggestionNotice: 'Sorry, no matching results',
        });
    };
    setAutoCompleteEquipment()

    let setAutoCompleteItem = () => {
        $('.autoCompleteItem').autocomplete({
            lookup: function (query, done) {
                $.ajax({
                    url: '/api/v1/lookup-barang',
                    dataType: "json",
                    data: {
                        q : query,
                        kategori : 'IP'
                    },
                    success: function(data) {
                        done(data);
                    }
                });
            },
            onSelect: function (suggestion, that) {
                let data = suggestion.data;
                $(that.element).val(data.kode + ' - ' + data.jenis + ' ' + data.merk + ' - ' + data.harga);
                let $this = that.element.attributes;
                let id = $this.dataid.value;
                setPrice(id);
            },
            minChars : 2,
            lookupLimit : 10,
            noSuggestionNotice: 'Sorry, no matching results',
        });
    }
    setAutoCompleteItem()

    let inputRupiah = (val) => {
        if(val)
            return parseInt(val.split('Rp.')[1].replace('.', '').replace('.', '').replace('.', '').split(',')[0]);
    }

    let outputRupiah = (val) => {
        if(val && val !== NaN) {
            var 	bilangan = val;
            var	reverse = bilangan.toString().split('').reverse().join(''),
                ribuan 	= reverse.match(/\d{1,3}/g);
                ribuan	= ribuan.join('.').split('').reverse().join('');
            return 'Rp.' + ribuan;
        }
    }

    let setPrice = (id) => {
        let totalItemRow = 0;
        let totalOpRow = 0;
        let subtotal = 0;
        let subtotalOp = 0;
        let total = 0;
        $(".item" + id).each(function(){
            if($(this).val())
                totalItemRow += inputRupiah($(this).val());
        });
        $(".equipment" + id).each(function(){
            if($(this).val())
                totalItemRow += inputRupiah($(this).val());
        });

        $(".op" + id).each(function(){
            if($(this).val())
                totalOpRow += inputRupiah($(this).val());
        });

        $(".day" + id).each(function(){
            if($(this).val())
                totalItemRow = totalItemRow * $(this).val();
        });

        $(".dayOp" + id).each(function(){
            if($(this).val())
                totalOpRow = totalOpRow * $(this).val();
        });

        $('.price' + id).val(outputRupiah(totalItemRow))
        $('.priceOp' + id).val(outputRupiah(totalOpRow))

        $(".price").each(function(){
            $(this).val()
                subtotal += inputRupiah($(this).val());
            $(this).val()
                total += inputRupiah($(this).val());
        });

        $(".priceOp").each(function(){
            if($(this).val())
                subtotalOp += inputRupiah($(this).val());

            if($(this).val())
                total += inputRupiah($(this).val());
        });

        if(subtotal && subtotal !== NaN)
            $('.subtotal').val(outputRupiah(subtotal))

        if(subtotalOp && subtotalOp !== NaN) {
            $('.subtotalOp').val(outputRupiah(subtotalOp))
        }

        if($('.diskon').val()){
            subtotal = subtotal + subtotalOp;
            let diskonTemp = subtotal * $('.diskon').val() / 100;
            total = total - diskonTemp;
        }

        if(total && total !== NaN)
            $('.total').val(outputRupiah(total))
    }

    $('.diskon').on('keyup', function(){
        let subtotal = inputRupiah($('.subtotal').val()) + inputRupiah($('.subtotalOp').val())
        let diskonTemp = subtotal * $(this).val() / 100;
        let total = subtotal - diskonTemp;
        if(total && total !== NaN)
            $('.total').val(outputRupiah(total))
    })

    $(document).on('keyup', '.dayOp', function(){
        let id = $(this).attr('dataid');
        console.log(id);
        setPrice(id)
    })

    $(document).on('keyup', '.day', function(){
        let id = $(this).attr('dataid');
        console.log(id);
        setPrice(id)
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
                    if(res.url !== null) {
                        toastr.info('Event Berhasil diperbaharui')
                    } else {
                        table.api().ajax.reload()
                        loadingIconButton($('#submit'), reset = true)
                        toastr.info('Event Berhasil disimpan')
                        $('#form-submit')[0].reset()
                        $('.card-form').slideUp();
                        $('#noreg').val(res.noReg);
                    }

                },
                error: function(res) {
                    console.log(res);
                }
            });
            return false;
        }
    });

    $(document).on('click', '.removeEquipment', function(){
        $(this).closest('tr').remove();
        setPrice($(this).data('id'));
    })
    $(document).on('click', '.removeItem', function(){
        $(this).closest('.input-group').remove();
        setPrice($(this).data('id'));
    })
    $(document).on('click', '.removeOp', function(){
        $(this).closest('tr').remove();
        setPrice($(this).data('id'));
    })

    var loadingIconButton = (that, reset = false) => {
        that.attr('disabled', 'disabled')
        if(reset == true) {
            that.find('span').addClass('fa-check-circle').removeClass('spinner-border spinner-border-sm')
            that.attr('disabled', false)
            return false;
        }
        that.find('span').removeClass('fa-check-circle').addClass('spinner-border spinner-border-sm')
    }

    // let checkVisibleNoreg = (column, value) => {
    //     $.ajax({
    //         url: "/api/v1/check-visible-noreg",
    //         method : 'GET',
    //         data: {
    //             'column' : column,
    //             'value' : value,
    //         },
    //         beforeSend: function() {
    //             loadingIconText($('#' + column))
    //         },
    //         success: function(data) {
    //             loadingIconText($('#' + column), reset = true);
    //             if(data) {
    //                 $('#' + column).css('border-color', '#bd2130')
    //                 $('#' + column +'-has-value').html(column + ' already available').show()
    //             } else {
    //                 $('#' + column).removeAttr('style')
    //                 $('#' + column +'-has-value').hide()
    //             }
    //         },
    //         error: function(error) {
    //             console.log(error)
    //         }
    //     })
    // }

</script>
@endpush
