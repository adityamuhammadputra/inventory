<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <tr>
        <td colspan="10">Data Rental {{ $attr->title }}</td>
    </tr>
    <tr>
        <td colspan="10">Date : {{ $attr->dateStart }} s/d {{ $attr->dateEnd }} {{ $attr->total }}</td>
    </tr>
</table>


<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Noreg</th>
        <th>Client</th>
        <th>Rental Date</th>
        <th>Equipment Total</th>
        <th>Item Total</th>
        <th>Subtotal</th>
        <th>Discount</th>
        <th>Total</th>
        <th>created at</th>
    </tr>
    </thead>
    <tbody>
        <tr style="background-color: #f1eded;">
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
            <td>9</td>
        </tr>
        @foreach($data as $key => $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>#{{ $item->noreg }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->start }} s/d {{ $item->end }}</td>
                <td>{{ $item->rentalBarangs->count() }}</td>
                <td>{{ $item->rentalBarangs->sum('count_item') }}</td>
                <td>{{ $item->sub_total }}</td>
                <td>{{ $item->diskon }} %</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
