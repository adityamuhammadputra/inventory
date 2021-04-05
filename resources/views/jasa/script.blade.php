@push('scripts')

<script>
    var tableColumn, tableOrder;
    if ($('#dataTable').data('model') == 'OP') {
        tableColumn = [
                            {
                                data: null,
                                searchable:false,
                                render: function (data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                data: 'vendor_nama',
                            },
                            { data: 'kode'},
                            { data: 'nama'},
                            { data: 'tugas'},
                            { data: 'harga'},
                            { data: 'created_at', searchable:false},
                            {
                                data: 'action',
                                orderable:false,
                                searchable:false,
                            },
                        ];
        tableOrder = [[6, 'desc']];

    } else if ($('#dataTable').data('model') == 'VE') {

        tableColumn = [
                            {
                                data: null,
                                searchable:false,
                                render: function (data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            { data: 'kode'},
                            { data: 'nama'},
                            { data: 'kontak'},
                            { data: 'harga'},
                            { data: 'keterangan'},
                            { data: 'created_at', searchable:false},
                            {
                                data: 'action',
                                orderable:false,
                                searchable:false,
                            },
                        ];
        tableOrder = [[6, 'desc']];

    } else {

        tableColumn = [
                            {
                                data: null,
                                searchable:false,
                                render: function (data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            { data: 'nama'},
                            { data: 'kontak'},
                            { data: 'alamat'},
                            { data: 'keterangan'},
                            { data: 'created_at', searchable:false},
                            {
                                data: 'action',
                                orderable:false,
                                searchable:false,
                            },
                        ];
        tableOrder = [[5, 'desc']];
    }

    var table;
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
                url : "{{ url('api/v1/jasa/datatable') }}?model=" + "{{ $data->model }}",
                method: 'POST',
            },
            columns : tableColumn,
            order : tableOrder,

        });
    });

    var loadingIconButton = (that, reset = false) => {
        that.attr('disabled', 'disabled')
        if(reset == true) {
            that.find('span').addClass('fa-check-circle').removeClass('spinner-border spinner-border-sm')
            that.attr('disabled', false)
            return false;
        }
        that.find('span').removeClass('fa-check-circle').addClass('spinner-border spinner-border-sm')
    }

    $("#form-submit").validate({
        submitHandler: function(form) {
            loadingIconButton($('#submit'));
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(res) {
                    table.api().ajax.reload()
                    loadingIconButton($('#submit'), reset = true)
                    toastr.info(res.data.nama + ' Berhasil disimpan')
                    $('#form-submit')[0].reset()
                    $('.card-add').slideUp();
                    return false;
                },
                error: function(res) {
                    console.log(res);
                    return false;
                }
            });
            return false;
        }
    });
</script>
@endpush;
