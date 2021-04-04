@push('scripts')

<script>
    $('.userEdit').on('click', function(){
        toastr.info('Test 1234?')
    })

    var options = {
        strings: ['Suka sama kamu huhu.', 'Suka sama dia huhu.'],
        typeSpeed: 40,
        loop: true,
        cursorChar: ' ',
    };

    var typed = new Typed('.notes', options);


</script>
@endpush
