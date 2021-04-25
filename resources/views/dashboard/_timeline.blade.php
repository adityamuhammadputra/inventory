@if (count($data->timeline) > 0)
    @foreach ($data->timeline as $item)
    <li class="{{ $item->jenis }}{{ $item->status }}">
        <a target="_blank" href="{{ $item->url }}">{{ $item->name }}</a>
        <code class="float-right">{!! ($item->status == 1) ? '<i class="mdi mdi-timer-sand"></i>Onprogress' : '<i class="mdi mdi-check"></i>Approved' !!}</code>
        <p>
            {{ $item->jenis }} <b>{{ $item->name }}</b> beralamat {{ $item->location }}, acara untuk tanggal <b>{{ $item->start }} s/d {{ $item->end }}</b>. <br>
            {{ $item->jenis }} ini mempunya potensi omset sebesar <b>{{ $item->total }}</b>
        </p>
        <p>
            <span class="mdi mdi-information"></span> Total Items {{ $item->items }}
        </p>
    </li>
    @endforeach
@else
<div class="alert alert-primary alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
    <div class="alert-message">
        <strong>Hello there!</strong> No data available
    </div>
</div>
@endif

