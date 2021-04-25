@push('scripts')

<script>
    $('.userEdit').on('click', function(){
        $(this).hide();
        $('#notes-temp').hide();
        $('#temp-attr').hide();

        $('.saveEdit, .cancelEdit, #attr, #notes').show();
    })


    $('.saveEdit').on('click', function(){
        $(this).closest('form').submit();
    })

    $("#form-submit").validate({
        submitHandler: function(form) {
            form.submit();
        }
    })

    var options = {
        strings: ["{{ request()->user()->notes ?? 'Hello there im using Panorama Apps' }}"],
        typeSpeed: 40,
        loop: true,
        cursorChar: ' ',
    };

    var typed = new Typed('.notes', options);


</script>
@endpush
