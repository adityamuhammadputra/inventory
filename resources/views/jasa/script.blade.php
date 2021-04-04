@push('scripts')

<script>
    var tableOperator;
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        tableOperator = $('#dataTable').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ url('api/v1/jasa/datatable') }}?model=" + "{{ $data->model }}",
                method: 'POST',
            },
            columns: [
                {
                    data: null,
                    searchable:false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'vendor_nama'},
                { data: 'kode'},
                { data: 'tugas'},
                { data: 'harga'},
                {
                    data: 'action',
                    orderable:false,
                    searchable:false,
                },
                { data: 'created_at', searchable:false, visible:false},
            ],
            order:[[6, 'desc']],
        });
    });
</script>
@endpush;
