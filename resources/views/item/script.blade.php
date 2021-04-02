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
                    searchable:false
                },
                {data: 'kode'},
                { data: 'jenis'},
                { data: 'merk'},
                { data: 'type'},
                { data: 'harga',},
                {
                    data: 'action',
                    orderable:false,
                    searchable:false,
                },
                { data: 'created_at', searchable:false, visible:false},
            ],
            order:[[7, 'desc']],

        });
        // table.on('draw.dt', function () {
        //     var info = table.page.info();
        //     table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
        //         cell.innerHTML = i + 1 + info.start;
        //     });
        // });
        // table.on( 'click', 'button', function () {
        //     var data = table.row( $(this).parents('tr') ).data();
        //     window.location = "/project/disposisi/" + data.Id
        // } );
    });
</script>
@endpush
