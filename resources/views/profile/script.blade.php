@push('scripts')

<script>
    $('.userEdit').on('click', function(){
        alert('c')
    })
</script>

<script>

var options = {
    strings: ['Suka sama kamu huhu.', 'Suka sama dia huhu.'],
    typeSpeed: 40,
    loop: true,
    cursorChar: ' ',
};

var typed = new Typed('.notes', options);

</script>
@endpush
