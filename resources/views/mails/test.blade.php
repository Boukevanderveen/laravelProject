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
<h2>Producten</h2>

    <table style="width: 100%">
        <thead>
            <tr>
                <th style="text-align:left;">Hoeveelheid</th>
                <th style="text-align:left;">Naam</th>
                <th style="text-align:left;">BTW</th>
                <th style="text-align:left;">Prijs</th>
                <th style="text-align:left;">Totaal</th>
            </tr>
        </thead>
        @foreach ($order->orderdetails as $orderdetail)
            <tbody>
                <td>{{ $orderdetail->quantity }}</td>
                <td>{{ $orderdetail->product_name }}</td>
                <td>
                    <p> {{$orderdetail->vat}}% </p>
                </td>
                <td>€ {{ number_format($orderdetail->product_price, 2, ',', '') }}</td>
                @php $totaal_product = $orderdetail->product_price * $orderdetail->quantity; @endphp

                <td>€ {{ number_format($totaal_product, 2, ',', '') }}</td>
            </tbody>
        @endforeach
    </table>

    <div style="float: left">
        <p><b>Subtotaal</b> € {{ number_format($order->total_excl, 2, ',', '') }}</p>
        <p><b>BTW</b> € {{ number_format($order->vat, 2, ',', '') }}</p>
        <p><b>Totaal €</b> {{ number_format($order->total_incl, 2, ',', '') }}</p>
    </div>
</table>


