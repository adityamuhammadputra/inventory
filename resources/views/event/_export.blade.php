<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <tr>
        <td colspan="13">Data Event {{ $attr->title }}</td>
    </tr>
    <tr>
        <td colspan="13">Date : {{ $attr->dateStart }} s/d {{ $attr->dateEnd }} {{ $attr->total }}</td>
    </tr>
</table>


<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Noreg</th>
        <th>Vendor</th>
        <th>Client</th>
        <th>Event Detail</th>
        <th>Event Date</th>
        <th>Operator</th>
        <th>Equipment</th>
        <th>Item</th>
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
            <td>10</td>
            <td>11</td>
            <td>12</td>
            <td>13</td>
        </tr>
        @foreach($data as $key => $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>#{{ $item->noreg }}</td>
                <td>{{ $item->vendor_name }}</td>
                <td>{{ $item->client_name }}</td>
                <td>{{ $item->name }}, Alamat : {{ $item->location }}</td>
                <td>{{ $item->date_start }} s/d {{ $item->date_end }}</td>
                <td>{{ $item->eventOperator->count() }}</td>
                <td>{{ $item->eventBarangs->count() }}</td>
                <td>{{ $item->eventBarangs->sum('count_item') }}</td>
                <td>{{ $item->sub_total_all }}</td>
                <td>{{ $item->diskon }} %</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
