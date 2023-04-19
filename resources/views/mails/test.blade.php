<h1> Bestelling met goede orde ontvangen </h1>

<table>
    <tbody>
    <tr>
        Besteld op: {{date('d-m-Y H:i', strtotime($order->created_at))}}
    </tr>
    <tr>
        <td>Naam: {{$order->name}}</td>
    </tr>
    <tr>
        <td>Straatnaam: {{$order->street}}</td>
    </tr>
    <tr>
        <td>Huisnummer: {{$order->house_number}} {{$order->addition}}</td>
    </tr>
    <tr>
        <td>Postcode: {{$order->zipcode}}</td>
    </tr>
    <tr>
        <td>Woonplaats: {{$order->city}}</td>
    </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Aantal</th>
            <th>Naam</th>
            <th>Prijs excl.</th>
            <th>Prijs incl.</th>
            <th>Totaal incl.</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($order->orderdetails as $orderdetail)
            <tr>
                <td data-th="Aantal">{{ $orderdetail->quantity }}</td>
                <td data-th="Naam">{{ $orderdetail->product_name }}</td>
                <td data-th="Prijs excl.">€ {{ str_replace('.', ',', number_format($orderdetail->product_price , 2))}}</td>
                <td data-th="Prijs incl.">€ {{ str_replace('.', ',', number_format($orderdetail->product_price * $orderdetail->vat/100 , 2))}}</td>
                <td data-th="Totaal incl.">€ {{ str_replace('.', ',', number_format($orderdetail->product_price * $orderdetail->quantity * $orderdetail->vat/100 + $orderdetail->product_price * $orderdetail->quantity, 2))}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
    <tbody>
    <tr>
        <td>Totaal excl. btw: €{{ str_replace('.', ',', number_format($order->total_excl, 2))}}</td>
    </tr>
    <tr>
        <td>Totaal excl. btw: €{{ str_replace('.', ',', number_format($order->vat, 2))}}</td>
    </tr>
    <tr>
        <td>Totaal excl. btw: €{{ str_replace('.', ',', number_format($order->total_incl, 2))}}</td>
    </tr>
    </tbody>
</table>
