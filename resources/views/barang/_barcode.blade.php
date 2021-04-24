<br>
<h4 style="text-align: center;">
    Cetak Barcode
</h4>

@foreach ($barangs as $kode => $img)
    <img src="{{ $img }}" width="150" style="padding: 8px;">
@endforeach

<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 0;  /* this affects the margin in the printer settings */
    }
    </style>

<script>
    setTimeout(function(){
        window.print();
     }, 1000);
</script>
